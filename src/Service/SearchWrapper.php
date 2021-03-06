<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Service\Exception\PostNotFound;
use Elasticsearch\Client as EsClient;
use Elasticsearch\Common\Exceptions\TransportException;

use function assert;
use function is_array;

class SearchWrapper
{
    private IndexerService $indexerService;

    private EsClient $esClient;

    public function __construct(EsClient $esClient, IndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
        $this->esClient       = $esClient;
    }

    /** @noinspection PhpDocRedundantThrowsInspection */

    /**
     * Perform a post search, returning simplified results, for example:
     *
     * [
     *     [
     *         'scorePercent' => '100',
     *         'slug' => 'exploring-hhvm-internals',
     *     ],
     *     [
     *         'scorePercent' => '12.8',
     *         'slug' => 'gdb-debugging-basics',
     *     ],
     * ]
     *
     * @return string[][]
     *
     * @throws TransportException
     */
    public function search(string $text): array
    {
        $params = [
            'index' => 'posts',
            'type' => 'post',
            'body' => [
                'query' => [
                    'simple_query_string' => ['query' => $text],
                ],
            ],
        ];

        $results = $this->esClient->search($params);

        /** @psalm-suppress RedundantConditionGivenDocblockType */
        assert(is_array($results));

        if (! $results['hits']['total']) {
            return [];
        }

        $simplifiedResults = [];

        foreach ($results['hits']['hits'] as $hit) {
            $simplifiedResults[] = [
                'scorePercent' => $hit['_score'] / $results['hits']['max_score'] * 100,
                'slug' => $hit['_id'],
            ];
        }

        return $simplifiedResults;
    }

    /** @noinspection PhpDocRedundantThrowsInspection */

    /**
     * Index all the posts
     *
     * @throws PostNotFound
     * @throws TransportException
     */
    public function indexAllPosts(): void
    {
        $posts = $this->indexerService->getAllPostsFromCache();

        // Clear index first, if it exists
        if ($this->esClient->indices()->exists(['index' => 'posts'])) {
            /** @noinspection UnusedFunctionResultInspection */
            $this->esClient->indices()->delete(['index' => 'posts']);
        }

        /** @noinspection UnusedFunctionResultInspection */
        $this->esClient->indices()->create(['index' => 'posts']);

        // Repopulate the index
        foreach ($posts as $post) {
            $params = [
                'body' => [
                    'title' => $post->title(),
                    'content' => $this->indexerService->getPostContentWithoutMetadata($post->slug()),
                ],
                'index' => 'posts',
                'type' => 'post',
                'id' => $post->slug(),
            ];

            /** @noinspection UnusedFunctionResultInspection */
            $this->esClient->index($params);
        }
    }
}
