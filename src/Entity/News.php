<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="np_news")
 * @UniqueEntity(fields={"title,overview"}, message="There is already an news with this title and overview")
 */
class News
{
    /**
     * @var null|int
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id = null;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private string $title = '';

    /**
     * @var null|string
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $overview = null;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private string $content = '';

    /**
     * @var null|string
     * @ORM\Column(type="text", nullable=true)
     */
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

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): News
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
