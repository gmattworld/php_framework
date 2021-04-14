<?php


namespace app\Models;
use app\core\DBModel;

class Feedback extends DBModel
{
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    public string $email;
    public string $message;
    public int $status = self::STATUS_UNREAD;

    public static function tableName(): string
    {
        return 'feedbacks';
    }

    public function attributes(): array
    {
        return ['email', 'message', 'status'];
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 150]],
            'message' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 255]],
        ];
    }
}