<?php

declare(strict_types=1);

namespace Asgrim\Value;

use DateTime;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

/**
 * @psalm-type TalkType = Talk::TYPE_TALK|Talk::TYPE_TUTORIAL|Talk::TYPE_LIGHTNING
 * @psalm-type LinksData = array<string, array{url: string, class: string}>
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class Talk
{
    private const TYPE_TALK      = 'talk';
    private const TYPE_TUTORIAL  = 'tutorial';
    private const TYPE_LIGHTNING = 'lightning';

    private string $name;

    /** @psalm-var TalkType */
    private string $type;

    private DateTimeImmutable $date;

    private string $event;

    private string $abstract;

    /**
     * @var string[][]
     * @psalm-var LinksData
     */
    private array $links;

    private function __construct()
    {
    }

    /**
     * @param string[]|DateTime[]|string[][][] $data
     * @psalm-param array{name: string, type: TalkType, date: DateTime, event: string, abstract: string, links: LinksData} $data
     */
    public static function fromArrayData(array $data): self
    {
        Assert::oneOf($data['type'], [self::TYPE_TALK, self::TYPE_TUTORIAL, self::TYPE_LIGHTNING]);

        $instance = new self();

        $instance->name     = $data['name'];
        $instance->type     = $data['type'];
        $instance->date     = DateTimeImmutable::createFromMutable($data['date']);
        $instance->event    = $data['event'];
        $instance->abstract = $data['abstract'];
        $instance->links    = $data['links'];

        return $instance;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function isTutorial(): bool
    {
        return $this->type === self::TYPE_TUTORIAL;
    }

    public function isLightning(): bool
    {
        return $this->type === self::TYPE_LIGHTNING;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function abstract(): string
    {
        return $this->abstract;
    }

    public function event(): string
    {
        return $this->event;
    }

    /**
     * @return string[][]
     * @psalm-return LinksData
     */
    public function links(): array
    {
        return $this->links;
    }
}
