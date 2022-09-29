<?php

namespace Ardenthq\NovaTableMetrics;

enum Period : string
{
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case All = 'all';

    public function label() : string
    {
        return match ($this) {
            self::Day => 'Last 24 hours',
            self::Week => 'Last 7 days',
            self::Month => 'Last 30 days',
            self::All => 'All time',
        };
    }
}
