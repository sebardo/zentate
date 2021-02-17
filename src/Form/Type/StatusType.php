<?php

namespace App\Form\Type;

/**
 * Class StatusType
 * @package App\Form\Type
 *
 * A custom type for enum values on status param in SeatStatus entity
 */
abstract class StatusType
{
    const STATUS_FREE   = "free";
    const STATUS_HOLD = "hold";
    const STATUS_BOOKED = "booked";

    /** @var array user friendly named type */
    protected static $statusName = [
        self::STATUS_FREE    => 'Free',
        self::STATUS_HOLD => 'Hold',
        self::STATUS_BOOKED => 'Booked',
    ];

    /**
     * @param  string $statusShortName
     * @return string
     */
    public static function getStatusName($statusShortName)
    {
        if (!isset(static::$statusName[$statusShortName])) {
            return "Unknown type ($statusShortName)";
        }

        return static::$statusName[$statusShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableStatus()
    {
        return [
            self::STATUS_FREE,
            self::STATUS_HOLD,
            self::STATUS_BOOKED
        ];
    }
}
