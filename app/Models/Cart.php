<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'items',
        'total_price',
        'agreed_to_privacy',
        'is_paid',
        'status'
    ];

    protected $casts = [
        'items' => 'array',
        'agreed_to_privacy' => 'boolean',
        'is_paid' => 'boolean'
    ];

    // Константы статусов
    const STATUS_NEW = 'new';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Метод для получения всех статусов
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_PROCESSING => 'В обработке',
            self::STATUS_COMPLETED => 'Выполнен',
            self::STATUS_CANCELLED => 'Отменен',
        ];
    }

    // Аксессор для автоматического преобразования JSON в массив
    public function getItemsAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        // Если это JSON-строка, декодируем ее
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return [];
    }
}
