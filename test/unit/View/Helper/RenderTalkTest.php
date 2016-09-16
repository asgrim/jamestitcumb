<?php
declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\View\Helper\RenderTalk;

/**
 * @covers \Asgrim\View\Helper\RenderTalk
 */
final class RenderTalkTest extends \PHPUnit_Framework_TestCase
{
    public function testRenderRegularTalkContents()
    {
        $renderTalk = new RenderTalk();

        $date = new \DateTime('2016-12-31 23:59:59');

        $content = $renderTalk->__invoke([
            'type' => 'regular',
            'name' => 'My Great Talk',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [],
        ]);

        self::assertStringMatchesFormat('%s<h3>My Great Talk%s</h3>%s', $content);
        self::assertStringMatchesFormat('%s(Fantastic Conference%s)%s', $content);
        self::assertStringMatchesFormat('%s<p>This talk is simply fantastic.</p>%s', $content);
        self::assertStringMatchesFormat('%s(%s, 31st Dec \'16)%s', $content);
    }

    public function testRenderLightningTalkContents()
    {
        $renderTalk = new RenderTalk();

        $date = new \DateTime('2016-12-31 23:59:59');

        $content = $renderTalk->__invoke([
            'type' => 'lightning',
            'name' => 'My Great Lightning Talk',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [],
        ]);

        self::assertStringMatchesFormat('%s<h3><em>Lightning: </em>My Great Lightning Talk%s</h3>%s', $content);
    }

    public function testRenderTutorialTalkContents()
    {
        $renderTalk = new RenderTalk();

        $date = new \DateTime('2016-12-31 23:59:59');

        $content = $renderTalk->__invoke([
            'type' => 'tutorial',
            'name' => 'My Great Tutorial',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [],
        ]);

        self::assertStringMatchesFormat('%s<h3><strong>Tutorial: </strong>My Great Tutorial%s</h3>%s', $content);
    }

    public function testRenderTalkWithLinksContents()
    {
        $renderTalk = new RenderTalk();

        $date = new \DateTime('2016-12-31 23:59:59');

        $content = $renderTalk->__invoke([
            'type' => 'lightning',
            'name' => 'My Great Talk',
            'event' => 'Fantastic Conference',
            'date' => $date,
            'abstract' => 'This talk is simply fantastic.',
            'links' => [
                'Label for link 1' => ['url' => 'http://test-uri/1', 'class' => 'foo'],
                'Label for link 2' => ['url' => 'http://test-uri/2'],
            ],
        ]);

        self::assertStringMatchesFormat('%s<a href="http://test-uri/1" class="foo">Label for link 1</a>%s', $content);
        self::assertStringMatchesFormat('%s<a href="http://test-uri/2">Label for link 2</a>%s', $content);
    }
}
