<?php

declare(strict_types=1);

namespace Asgrim\Value;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

/** @psalm-suppress PropertyNotSetInConstructor */
final class Post
{
    private string $title;

    /** @var array<string> */
    private array $tags;

    private DateTimeImmutable $date;

    private string $slug;

    private string $file;

    private bool $active;

    private function __construct()
    {
    }

    /**
     * @param string[]|DateTimeImmutable[]|string[][] $dataArray
     *
     * @return static
     */
    public static function __set_state(array $dataArray): self
    {
        Assert::string($dataArray['title']);
        Assert::isArray($dataArray['tags']);
        Assert::isInstanceOf($dataArray['date'], DateTimeImmutable::class);
        Assert::string($dataArray['slug']);
        Assert::string($dataArray['file']);

        return self::create(
            $dataArray['title'],
            $dataArray['tags'],
            $dataArray['date'],
            $dataArray['slug'],
            $dataArray['file']
        );
    }

    /** @param string[] $tags */
    public static function create(
        string $title,
        array $tags,
        DateTimeImmutable $date,
        string $slug,
        string $file
    ): self {
        Assert::allString($tags);

        $instance         = new self();
        $instance->title  = $title;
        $instance->tags   = $tags;
        $instance->date   = $date;
        $instance->slug   = $slug;
        $instance->file   = $file;
        $instance->active = false;

        return $instance;
    }

    public function title(): string
    {
        return $this->title;
    }

    /** @return array<string> */
    public function tags(): array
    {
        return $this->tags;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function file(): string
    {
        return $this->file;
    }

    public function shouldShowComments(): bool
    {
        return $this->active;
    }

    public function enableCommentsForPost(): void
    {
        $this->active = true;
    }
}
