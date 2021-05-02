<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Repositories\CircleRepositoryContract;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USER_TOP;

    /**
     * サークルリポジトリ
     *
     * @var CircleRepositoryContract
     */
    private $circleRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CircleRepositoryContract $circleRepository)
    {
        $this->middleware('guest:user');
        $this->circleRepository = $circleRepository;
    }

    protected function guard()
    {
        return Auth::guard('user');
    }

    /**
     * 新規登録画面の表示
     *
     * @return void
     */
    public function showRegistrationForm()
    {
        $circles = $this->circleRepository->getAll()->toArray();

        return view('user.auth.register')->with('circles', $circles);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'regex:/\d{2,5}-\d{2,4}-\d{3,4}/'],
            'circle_id' => ['required', 'integer', 'exists:circles,id'],
            'birthday' => ['required'],
            'sex' => ['required', Rule::in([config('const.sex.male.id'), config('const.sex.female.id'), config('const.sex.do_not_answer.id')])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'circle_id' => $data['circle_id'],
            'birthday' => $data['birthday'],
            'sex' => $data['sex'],
            'password' => Hash::make($data['password']),
            // TODO: S3へのファイルアップロード実装後に追加
            // 'avatar' => $data['image']
        ]);
    }

    /**
     * 仮登録直後に遷移させるページ
     *
     * @return void
     */
    public function registered()
    {
        return view('user.auth.verify');
    }
}
