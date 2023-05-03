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

        self::assertStringMatchesFormat('%s<h3>My Great Talk%s</h3>%s', $content);
        self::assertStringMatchesFormat('%s(Fantastic Conference%s)%s', $content);
        self::assertStringMatchesFormat('%s<p>This talk is simply fantastic.</p>%s', $content);
        self::assertStringMatchesFormat('%s(%s, 31st Dec \'16)%s', $content);
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

        self::assertStringMatchesFormat('%s<h3><em>Lightning: </em>My Great Lightning Talk%s</h3>%s', $content);
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

        self::assertStringMatchesFormat('%s<h3><strong>Tutorial: </strong>My Great Tutorial%s</h3>%s', $content);
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
}
