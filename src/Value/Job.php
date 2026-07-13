<?php

declare(strict_types=1);

namespace Asgrim\Value;

use DateTimeImmutable;

use function mb_strtoupper;
use function mb_substr;

/**
 * @psalm-type JobData = array{
 *     company: string,
 *     title: string,
 *     start: string,
 *     end?: string|null,
 *     description: string,
 *     url?: string|null,
 *     logo?: string|null,
 *     tags?: string[]|null,
 * }
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class Job
{
    private string $company;
    private string $title;
    private DateTimeImmutable $start;
    private DateTimeImmutable|null $end;
    private string $description;
    private string|null $url;
    private string|null $logoUrl;

    /** @var string[] */
    private array $tags;

    private function __construct()
    {
    }

    /** @psalm-param JobData $data */
    public static function fromArrayData(array $data, string|null $logoUrl = null): self
    {
        $instance = new self();

        $instance->company     = $data['company'];
        $instance->title       = $data['title'];
        $instance->start       = new DateTimeImmutable($data['start']);
        $instance->end         = isset($data['end']) ? new DateTimeImmutable($data['end']) : null;
        $instance->description = $data['description'];
        $instance->url         = $data['url'] ?? null;
        $instance->logoUrl     = $logoUrl;
        $instance->tags        = $data['tags'] ?? [];

        return $instance;
    }

    public function company(): string
    {
        return $this->company;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function end(): DateTimeImmutable|null
    {
        return $this->end;
    }

    public function isCurrent(): bool
    {
        return $this->end === null;
    }

    public function dateRangeLabel(): string
    {
        $endLabel = $this->end === null ? 'Present' : $this->end->format('M Y');

        return $this->start->format('M Y') . ' &ndash; ' . $endLabel;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function url(): string|null
    {
        return $this->url;
    }

    public function logoUrl(): string|null
    {
        return $this->logoUrl;
    }

    /** @return string[] */
    public function tags(): array
    {
        return $this->tags;
    }

    public function initials(): string
    {
        return mb_strtoupper(mb_substr($this->company, 0, 1));
    }
}
