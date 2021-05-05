<?php
namespace App\Repositories\Params;

class UserParams
{
    private ?object $file;
    private string $name;
    private string $email;
    private string $phone;
    private int $circleId;
    private string $birthday;
    private int $sex;

    public function __construct(
        ?object $file,
        string $name,
        string $email,
        string $phone,
        int $circleId,
        string $birthday,
        int $sex
    )
    {
        $this->file = $file;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->circleId = $circleId;
        $this->birthday = $birthday;
        $this->sex = $sex;
    }

    public function getFile(): ?object
    {
        return $this->file;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getCircleId(): int
    {
        return $this->circleId;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getSex(): int
    {
        return $this->sex;
    }
}