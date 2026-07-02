<?php

declare(strict_types=1);

namespace AsgrimTest\View\Helper;

use Asgrim\Service\Ratings;
use Asgrim\Value\Talk;
use Asgrim\View\Helper\RenderTalk;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Asgrim\View\Helper\RenderTalk */
final class RenderTalkTest extends TestCase
{
    private Ratings&MockObject $ratings;
    private RenderTalk $renderTalk;

    public function setUp(): void
    {
        parent::setUp();

        $this->ratings    = $this->createMock(Ratings::class);
        $this->renderTalk = new RenderTalk($this->ratings);
    }

    public function testRenderRegularTalkContents(): void
    {
        $date = new DateTime('2016-12-31 23:59:59');

        $content = $this->renderTalk->__invoke(Talk::fromArrayData([
            'type' => 'talk',
            'name' => 'My Great Talk',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [],
        ]));

        self::assertStringMatchesFormat('%s<span class="talk-card__badge talk-card__badge--talk">Talk</span><h3 class="talk-card__title">My Great Talk</h3>%s', $content);
        self::assertStringMatchesFormat('%s<p class="talk-card__meta">Fantastic Conference%s</p>%s', $content);
        self::assertStringMatchesFormat('%s<p class="talk-card__abstract">This talk is simply fantastic.</p>%s', $content);
        self::assertStringMatchesFormat('%s31st Dec \'16%s', $content);
    }

    public function testRenderLightningTalkContents(): void
    {
        $date = new DateTime('2016-12-31 23:59:59');

        $content = $this->renderTalk->__invoke(Talk::fromArrayData([
            'type' => 'lightning',
            'name' => 'My Great Lightning Talk',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [],
        ]));

        self::assertStringMatchesFormat('%s<span class="talk-card__badge talk-card__badge--lightning">Lightning</span>%s', $content);
        self::assertStringMatchesFormat('%s<h3 class="talk-card__title">My Great Lightning Talk</h3>%s', $content);
    }

    public function testRenderTutorialTalkContents(): void
    {
        $date = new DateTime('2016-12-31 23:59:59');

        $content = $this->renderTalk->__invoke(Talk::fromArrayData([
            'type' => 'tutorial',
            'name' => 'My Great Tutorial',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [],
        ]));

        self::assertStringMatchesFormat('%s<span class="talk-card__badge talk-card__badge--tutorial">Tutorial</span>%s', $content);
        self::assertStringMatchesFormat('%s<h3 class="talk-card__title">My Great Tutorial</h3>%s', $content);
    }

    public function testRenderTalkWithLinksContents(): void
    {
        $date = new DateTime('2016-12-31 23:59:59');

        $content = $this->renderTalk->__invoke(Talk::fromArrayData([
            'type' => 'lightning',
            'name' => 'My Great Talk',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [
                'Label for link 1' => ['url' => 'http://test-uri/1', 'class' => 'foo'],
                'Label for link 2' => ['url' => 'http://test-uri/2'],
            ],
        ]));

        self::assertStringMatchesFormat('%s<a href="http://test-uri/1" class="foo">Label for link 1</a>%s', $content);
        self::assertStringMatchesFormat('%s<a href="http://test-uri/2">Label for link 2</a>%s', $content);
    }

    public function testRenderPastTalkUsesCompactHeadingAndSkipsAbstract(): void
    {
        $date = new DateTime('2016-12-31 23:59:59');

        $content = $this->renderTalk->__invoke(Talk::fromArrayData([
            'type' => 'talk',
            'name' => 'My Great Talk',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [],
        ]), skipAbstract: true);

        self::assertStringMatchesFormat('<li class="talk-card talk-card--compact">%a', $content);
        self::assertStringMatchesFormat('%s<h4 class="talk-card__title">My Great Talk</h4>%s', $content);
        self::assertStringNotContainsString('talk-card__abstract', $content);
    }
}
