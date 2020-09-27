<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\Models\User;

class Event extends Model
{
    // protected $keyType = 'string';
    // const ID_LENGTH = 12;

    // public function __construct(array $attrributes = [])
    // {
    //     parent::__construct($attrributes);
    //     if(! Arr::get($this->attrributes, 'id')) {
    //         $this->setId();
    //     }
    // }

    protected $fillable = [
        'name', 'description', 'date', 'open_time', 'close_time', 'place', 'price', 'image'
    ];

    // JSONに含める属性
//    protected $visible = [
//        'id', 'name'
//    ];

    // JSONに含めない属性
//    protected $hidden = [
//        self::CREATED_AT, self::UPDATED_AT
//    ];

    /**
     * ランダムなID値をid属性に代入する
     */
    // private function setId()
    // {
    //     $this->attrributes['id'] = $this->getRandomId();
    // }

    /**
     * ランダムなID値を生成する
     */
    // public function getRandomId()
    // {
    //     $characters = array_merge(
    //         range(0, 9), range('a', 'z'),
    //         range('A', 'Z'), ['-', '_']
    //     );

    //     $length = count($characters);

    //     $id = "";

    //     for($i = 0; $i < self::ID_LENGTH; $i++) {
    //         $id .= $characters[random_int(0, $length -1)];
    //     }
    //     return $i;
    // }


    // アソシエーション
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    // public function __construct(array $attrributes = [])
    // {
    //     parent::__construct($attrributes);
    //     if(! Arr::get($this->attrributes, 'id')) {
    //         $this->setId();
    //     }
    // }
}
