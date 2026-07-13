<?php

declare(strict_types=1);

namespace AsgrimTest\View\Helper;

use Asgrim\View\Helper\RenderTagCloud;
use PHPUnit\Framework\TestCase;

/** @covers \Asgrim\View\Helper\RenderTagCloud */
final class RenderTagCloudTest extends TestCase
{
    private RenderTagCloud $renderTagCloud;

    public function setUp(): void
    {
        parent::setUp();

        $this->renderTagCloud = new RenderTagCloud();
    }

    public function testRenderEmptyTagCountsReturnsEmptyString(): void
    {
        self::assertSame('', $this->renderTagCloud->__invoke([]));
    }

    public function testRenderSingleTagGetsMaximumWeight(): void
    {
        $content = $this->renderTagCloud->__invoke(['PHP' => 3]);

        self::assertSame('<ul class="tag-cloud"><li class="tag-cloud__item tag-cloud__item--weight-5">PHP</li></ul>', $content);
    }

    public function testRenderScalesWeightBetweenMinAndMaxCount(): void
    {
        $content = $this->renderTagCloud->__invoke(['Java' => 1, 'PHP' => 5]);

        self::assertSame(
            '<ul class="tag-cloud">'
            . '<li class="tag-cloud__item tag-cloud__item--weight-1">Java</li>'
            . '<li class="tag-cloud__item tag-cloud__item--weight-5">PHP</li>'
            . '</ul>',
            $content,
        );
    }

    public function testRenderMidRangeCountGetsMidRangeWeight(): void
    {
        $content = $this->renderTagCloud->__invoke(['Java' => 1, 'Rust' => 3, 'PHP' => 5]);

        self::assertStringContainsString('tag-cloud__item--weight-4">Rust</li>', $content);
    }

    public function testRenderUsesLogarithmicScaleSoAFewUsesAreNoticeablyBiggerThanOne(): void
    {
        // A single dominant outlier (PHP used 18 times) shouldn't flatten every other
        // tag down to the smallest weight - a tag used 3 times should still stand out
        // from tags only used once.
        $content = $this->renderTagCloud->__invoke([
            'AI' => 1,
            'Java' => 3,
            'Leadership' => 8,
            'PHP' => 18,
        ]);

        self::assertStringContainsString('tag-cloud__item--weight-1">AI</li>', $content);
        self::assertStringContainsString('tag-cloud__item--weight-3">Java</li>', $content);
        self::assertStringContainsString('tag-cloud__item--weight-4">Leadership</li>', $content);
        self::assertStringContainsString('tag-cloud__item--weight-5">PHP</li>', $content);
    }
}
