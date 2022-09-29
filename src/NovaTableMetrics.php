<?php

declare(strict_types=1);

namespace Ardent\NovaTableMetrics;

use Laravel\Nova\Card;

class NovaTableMetrics extends Card
{
    public array $items = [];

    public bool $hasRanges = true;

    public array $ranges = [
        'daily'   => 'Last 24 hours',
        'weekly'  => 'Last 7 days',
        'monthly' => 'Last 30 days',
        'all'     => 'All time',
    ];

    public string $defaultRange = 'daily';

    public function __construct(
        public string $title,
        public string $heading,
        public string $detail,
    ) {
    }

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-table-metrics';
    }

    public function withoutRanges() : self
    {
        $this->hasRanges = false;

        return $this;
    }

    public function defaultRange(string $range) : self
    {
        $this->defaultRange = $range;

        return $this;
    }

    public function ranges(array $ranges) : self
    {
        $this->ranges = $ranges;

        return $this;
    }

    /**
     * @param TableRow[] $items
     * @return self
     */
    public function items(array $items) : self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge([
            'title'     => $this->title,
            'heading'   => $this->heading,
            'detail'    => $this->detail,
            'hasRanges' => $this->hasRanges,
            'range'     => $this->defaultRange,
            'ranges'    => collect($this->ranges)->map(fn ($range, $key) => [
                'label' => $range,
                'value' => $key,
            ])->values()->all(),
            'items' => $this->items,
        ], parent::jsonSerialize());
    }
}
