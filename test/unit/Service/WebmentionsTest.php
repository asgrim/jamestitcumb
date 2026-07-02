<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Db\WebmentionsRepository;
use Asgrim\Service\Webmentions;
use ColinODell\PsrTestLogger\TestLogger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

/** @covers \Asgrim\Service\Webmentions */
final class WebmentionsTest extends TestCase
{
    private WebmentionsRepository&MockObject $repository;
    private Webmentions $webmentions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(WebmentionsRepository::class);

        $this->webmentions = new Webmentions(
            $this->repository,
            'a-token',
            'www.jamestitcumb.com',
            $this->createMock(ClientInterface::class),
            new TestLogger(),
        );
    }

    public function testMentionsForUrlReadsFromRepository(): void
    {
        $mentions = [
            [
                'wm-property' => 'like-of',
                'wm-target' => 'https://www.jamestitcumb.com/posts/a-post',
            ],
        ];

        $this->repository->expects(self::once())
            ->method('findMentionsForUrl')
            ->with('https://www.jamestitcumb.com/posts/a-post')
            ->willReturn($mentions);

        self::assertSame($mentions, $this->webmentions->mentionsForUrl('https://www.jamestitcumb.com/posts/a-post'));
    }
}
