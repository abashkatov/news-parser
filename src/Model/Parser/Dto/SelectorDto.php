<?php

declare(strict_types=1);

namespace App\Model\Parser\Dto;

final class SelectorDto
{
    private string $title;

    private string $overview;

    private string $content;

    private string $image;

    private string $link;

    public function __construct(string $link, string $title, string $overview, string $content, string $image)
    {
        $this->link = $link;
        $this->title = $title;
        $this->overview = $overview;
        $this->content = $content;
        $this->image = $image;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getLink(): string
    {
        return $this->link;
    }
}
