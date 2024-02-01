<?php

namespace App\Enums;

class MarketsEnum
{
    const RUSSIA = 'russia';
    const EUROPE = 'europe';
    const JAPAN = 'japan';
    const USA = 'usa';

    /**
     * @return string[]
     */
    public static function all(): array
    {
        return [
            self::RUSSIA => 'для России',
            self::JAPAN => 'для Японии',
            self::EUROPE => 'для Европы',
            self::USA => 'для США'
        ];
    }

    /**
     * @param $key
     * @return string
     */
    public static function getByKey($key): string
    {
        return self::all()[$key] ?? '';
    }
}
