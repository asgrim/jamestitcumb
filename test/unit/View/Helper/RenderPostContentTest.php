<?php
declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\View\Helper\RenderPostContent;

/**
 * @covers \Asgrim\View\Helper\RenderPostContent
 */
final class RenderPostContentTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicMarkdownConversion()
    {
        /** @var IndexerService|\PHPUnit_Framework_MockObject_MockObject $indexer */
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPostContentBySlug'])
            ->getMock();

        $indexer->expects(self::once())
            ->method('getPostContentBySlug')
            ->with('test-slug')
            ->willReturn("metadata: here\n---\n\n\n# Some *content*");

        $renderer = new RenderPostContent($indexer);
        self::assertSame("<h1>Some <em>content</em></h1>\n", $renderer->__invoke('test-slug'));
    }
}
