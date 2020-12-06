<?php

declare(strict_types=1);

namespace App\Entity;

class News
{
    private ?int $id = null;
    private string $title = '';
    private string $overview = '';
    private string $content = '';
    private ?string $imageUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): News
    {
        $this->title = $title;

        return $this;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): News
    {
        $this->overview = $overview;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): News
    {
        $this->content = $content;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): News
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
