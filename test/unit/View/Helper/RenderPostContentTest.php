<?php

declare(strict_types=1);

namespace AsgrimTest\View\Helper;

use Asgrim\Service\IndexerService;
use Asgrim\View\Helper\RenderPostContent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Asgrim\View\Helper\RenderPostContent
 */
final class RenderPostContentTest extends TestCase
{
    public function testBasicMarkdownConversion() : void
    {
        /** @var IndexerService|MockObject $indexer */
        $indexer = $this->createMock(IndexerService::class);
        $indexer->expects(self::once())
            ->method('getPostContentWithoutMetadata')
            ->with('test-slug')
            ->willReturn('# Some *content*');

        $renderer = new RenderPostContent($indexer);
        self::assertSame("<h1>Some <em>content</em></h1>\n", $renderer->__invoke('test-slug'));
    }
}
