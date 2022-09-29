<?php

declare(strict_types=1);

namespace Ardenthq\NovaTableMetrics;

use Illuminate\Support\Collection;

abstract class Table
{
    abstract public function title() : string;
    abstract public function heading() : string;
    abstract public function detailHeading() : string;
    abstract public function defaultPeriod() : ?Period;
    abstract public function items(?Period $period) : Collection;

    public static function make() : NovaTableMetrics
    {
        return NovaTableMetrics::fromTable(new static());
    }

    public function periods() : array
    {
        return Period::cases();
    }

    public function hasPeriodSelector() : bool
    {
        return true;
    }
}
