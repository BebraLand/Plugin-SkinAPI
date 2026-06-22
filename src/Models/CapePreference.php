<?php

namespace Azuriom\Plugin\SkinApi\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class CapePreference extends Model
{
    use HasTablePrefix;

    protected string $prefix = 'skin_';

    protected $fillable = ['user_id', 'disabled'];

    public static function isDisabledForUser(int $userId): bool
    {
        return (bool) static::where('user_id', $userId)->value('disabled');
    }

    public static function disableForUser(int $userId): void
    {
        static::updateOrCreate(['user_id' => $userId], ['disabled' => true]);
    }

    public static function enableForUser(int $userId): void
    {
        static::where('user_id', $userId)->delete();
    }
}
