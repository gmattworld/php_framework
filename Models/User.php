<?php


namespace app\Models;

use app\core\DBModel;

class User extends DBModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;


    public int $id = 0;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public int $status = self::STATUS_ACTIVE;

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password'];
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [ self::RULE_UNIQUE, 'class' => self::class ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]]
        ];
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
}