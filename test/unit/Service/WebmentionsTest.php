<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Db\WebmentionsRepository;
use Asgrim\Service\Webmentions;
use ColinODell\PsrTestLogger\TestLogger;
use DateTimeImmutable;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

use function json_encode;
use function str_contains;
use function urlencode;

/** @covers \Asgrim\Service\Webmentions */
final class WebmentionsTest extends TestCase
{
    private WebmentionsRepository&MockObject $repository;
    private ClientInterface&MockObject $httpClient;
    private Webmentions $webmentions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(WebmentionsRepository::class);
        $this->httpClient = $this->createMock(ClientInterface::class);

        $this->webmentions = new Webmentions(
            $this->repository,
            'a-token',
            'www.jamestitcumb.com',
            $this->httpClient,
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

    public function testRefreshFromWebmentionIoFetchesEverythingWhenNeverSynced(): void
    {
        $this->repository->method('getLastSyncedAt')->willReturn(null);

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(static function (RequestInterface $request): bool {
                return ! str_contains((string) $request->getUri(), 'since=');
            }))
            ->willReturn($this->jsonResponse(['children' => []]));

        $this->repository->expects(self::once())->method('markSynced');

        $this->webmentions->refreshFromWebmentionIo();
    }

    public function testRefreshFromWebmentionIoFetchesOnlySinceLastSync(): void
    {
        $lastSynced = new DateTimeImmutable('2026-06-01T10:00:00+00:00');
        $this->repository->method('getLastSyncedAt')->willReturn($lastSynced);

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(static function (RequestInterface $request) use ($lastSynced): bool {
                return str_contains(
                    (string) $request->getUri(),
                    'since=' . urlencode($lastSynced->format(DateTimeImmutable::ATOM)),
                );
            }))
            ->willReturn($this->jsonResponse(['children' => []]));

        $this->webmentions->refreshFromWebmentionIo();
    }

    public function testRefreshFromWebmentionIoWithAllIgnoresStoredSyncCursor(): void
    {
        $this->repository->expects(self::never())->method('getLastSyncedAt');

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(static function (RequestInterface $request): bool {
                return ! str_contains((string) $request->getUri(), 'since=');
            }))
            ->willReturn($this->jsonResponse(['children' => []]));

        $this->webmentions->refreshFromWebmentionIo(true);
    }

    public function testRefreshFromWebmentionIoWithExplicitSinceOverridesStoredCursor(): void
    {
        $this->repository->expects(self::never())->method('getLastSyncedAt');

        $explicitSince = new DateTimeImmutable('2020-01-01T00:00:00+00:00');

        $this->httpClient->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(static function (RequestInterface $request) use ($explicitSince): bool {
                return str_contains(
                    (string) $request->getUri(),
                    'since=' . urlencode($explicitSince->format(DateTimeImmutable::ATOM)),
                );
            }))
            ->willReturn($this->jsonResponse(['children' => []]));

        $this->webmentions->refreshFromWebmentionIo(false, $explicitSince);
    }

    public function testRefreshFromWebmentionIoUpsertsFetchedMentions(): void
    {
        $this->repository->method('getLastSyncedAt')->willReturn(null);

        $this->httpClient->method('sendRequest')->willReturn($this->jsonResponse([
            'children' => [
                [
                    'wm-property' => 'like-of',
                    'wm-target' => 'https://www.jamestitcumb.com/posts/a-post',
                    'url' => 'https://example.com/liker',
                ],
            ],
        ]));

        $this->repository->expects(self::once())
            ->method('upsert')
            ->with(
                'https://www.jamestitcumb.com/posts/a-post',
                'https://example.com/liker',
                'like-of',
                null,
                self::isType('array'),
            );

        $this->webmentions->refreshFromWebmentionIo();
    }

    /** @param array<string, mixed> $body */
    private function jsonResponse(array $body): Response
    {
        $response = new Response();
        $response->getBody()->write(json_encode($body));
        $response->getBody()->rewind();

        return $response;
    }
}
