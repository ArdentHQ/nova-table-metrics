<?php

declare(strict_types=1);

namespace Ardent\NovaTableMetrics;

use JsonSerializable;
use Laravel\Nova\Makeable;

class TableRow implements JsonSerializable
{
    use Makeable;

    public string $subtitle = '';

    public string $url = '';

    public bool $openInNewTab = false;

    public function __construct(
        public string $title,
        public string $detail,
    ) {
    }

    public function subtitle(string $subtitle) : self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function url(string $url) : self
    {
        $this->url = $url;

        return $this;
    }

    public function openInNewTab() : self
    {
        $this->openInNewTab = true;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        return [
            'title'        => $this->title,
            'subtitle'     => $this->subtitle,
            'detail'       => $this->detail,
            'url'          => $this->url,
            'openInNewTab' => $this->openInNewTab,
        ];
    }
}
