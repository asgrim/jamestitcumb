<?php

declare(strict_types=1);

namespace Asgrim\Value;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

/**
 * @psalm-type TalkType = Talk::TYPE_TALK|Talk::TYPE_TUTORIAL|Talk::TYPE_LIGHTNING
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class Talk
{
    private const TYPE_TALK = 'talk';
    private const TYPE_TUTORIAL = 'tutorial';
    private const TYPE_LIGHTNING = 'lightning';

    /** @var string */
    private $name;

    /**
     * @var string
     *
     * @psalm-var TalkType
     */
    private $type;

    /** @var DateTimeImmutable */
    private $date;

    /** @var string */
    private $event;

    /** @var string */
    private $abstract;

    /** @var array<string, array{url: string, class: string}> */
    private $links;

    private function __construct()
    {
    }

    public static function fromArrayData(array $data) : self
    {
        Assert::oneOf($data['type'], [self::TYPE_TALK, self::TYPE_TUTORIAL, self::TYPE_LIGHTNING]);

        $instance = new self();

        $instance->name = $data['name'];
        $instance->type = $data['type'];
        $instance->date = DateTimeImmutable::createFromMutable($data['date']);
        $instance->event = $data['event'];
        $instance->abstract = $data['abstract'];
        $instance->links = $data['links'];

        return $instance;
    }

    public function date() : DateTimeImmutable
    {
        return $this->date;
    }

    public function isTutorial() : bool
    {
        return $this->type === self::TYPE_TUTORIAL;
    }

    public function isLightning() : bool
    {
        return $this->type === self::TYPE_LIGHTNING;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function abstract() : string
    {
        return $this->abstract;
    }

    public function event() : string
    {
        return $this->event;
    }

    /**
     * @return array<string, array{url: string, class: string}>
     */
    public function links() : array
    {
        return $this->links;
    }
}
