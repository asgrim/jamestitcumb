<?php

declare(strict_types=1);

namespace AsgrimTest\View\Helper;

use Asgrim\Service\IndexerService;
use Asgrim\View\Helper\RenderPostContent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

use function assert;

/**
 * @covers \Asgrim\View\Helper\RenderPostContent
 */
final class RenderPostContentTest extends TestCase
{
    public function testBasicMarkdownConversion(): void
    {
        $indexer = $this->createMock(IndexerService::class);
        assert($indexer instanceof IndexerService || $indexer instanceof MockObject);
        $indexer->expects(self::once())
            ->method('getPostContentWithoutMetadata')
            ->with('test-slug')
            ->willReturn('# Some *content*');

        $renderer = new RenderPostContent($indexer);
        self::assertSame("<h1>Some <em>content</em></h1>\n", $renderer->__invoke('test-slug'));
    }
}
