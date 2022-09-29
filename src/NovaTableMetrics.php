<?php

declare(strict_types=1);

namespace Ardenthq\NovaTableMetrics;

use Illuminate\Support\Collection;
use Laravel\Nova\Card;

class NovaTableMetrics extends Card
{
    public array $items = [];

    public bool $hasPeriodSelector = true;

    /**
     * @var Period[]
     */
    public array $periods = [];

    public ?Period $defaultPeriod = null;

    public function __construct(
        public string $title,
        public string $heading,
        public string $detail,
    ) {
    }

    public static function fromTable(Table $table) : self
    {
        $card = new self(
            title: $table->title(),
            heading: $table->heading(),
            detail: $table->detailHeading(),
        );

        $card->items(
            $table->items($table->defaultPeriod())
        )->withMeta([
            'uriKey' => get_class($table),
        ])->periods($table->periods())->defaultPeriod($table->defaultPeriod());

        if (! $table->hasPeriodSelector()) {
            $card->withoutPeriodSelector();
        }

        return $card;
    }

    public function component() : string
    {
        return 'nova-table-metrics';
    }

    public function withoutPeriodSelector() : self
    {
        $this->hasPeriodSelector = false;

        return $this;
    }

    public function defaultPeriod(?Period $period) : self
    {
        $this->defaultPeriod = $period;

        return $this;
    }

    /**
     * @param Period[] $periods
     * @return self
     */
    public function periods(array $periods) : self
    {
        $this->periods = $periods;

        return $this;
    }

    /**
     * @param Collection<int, TableRow> $items
     * @return self
     */
    public function items(Collection $items) : self
    {
        $this->items = $items->values()->all();

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
            'hasPeriodSelector' => $this->hasPeriodSelector,
            'period'     => $this->defaultPeriod?->value,
            'items' => $this->items,
            'periods'    => collect($this->periods)->map(fn ($period, $key) => [
                'label' => $period->label(),
                'value' => $period->value,
            ])->values()->all(),
        ], parent::jsonSerialize());
    }
}
