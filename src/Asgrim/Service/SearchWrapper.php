<?php
declare(strict_types=1);

namespace Asgrim\Service;

use Elasticsearch\Client as EsClient;

class SearchWrapper
{
    /**
     * @var IndexerService
     */
    private $indexerService;

    /**
     * @var EsClient
     */
    private $esClient;

    public function __construct(EsClient $esClient, IndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
        $this->esClient = $esClient;
    }

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
     * @param $text
     * @return array
     */
    public function search(string $text) : array
    {
        $params = [
            'index' => 'posts',
            'type' => 'post',
            'body' => [
                'query' => [
                    'simple_query_string' => [
                        'query' => $text,
                    ],
                ],
            ],
        ];

        $results = $this->esClient->search($params);

        if (!$results['hits']['total']) {
            return [];
        }

        $simplifiedResults = [];

        foreach ($results['hits']['hits'] as $hit) {
            $simplifiedResults[] = [
                'scorePercent' => (($hit['_score'] / $results['hits']['max_score']) * 100),
                'slug' => $hit['_id'],
            ];
        }
        return $simplifiedResults;
    }

    /**
     * Index all the posts
     * @throws \Asgrim\Service\Exception\PostNotFound
     */
    public function indexAllPosts()
    {
        $posts = $this->indexerService->getAllPostsFromCache();

        // Clear index first, if it exists
        if ($this->esClient->indices()->exists(['index' => 'posts'])) {
            $this->esClient->indices()->delete(['index' => 'posts']);
        }

        $this->esClient->indices()->create(['index' => 'posts']);

        // Repopulate the index
        foreach ($posts as $post) {
            $params = [
                'body' => [
                    'title' => $post['title'],
                    'content' => $this->indexerService->getPostContentWithoutMetadata($post['slug']),
                ],
                'index' => 'posts',
                'type' => 'post',
                'id' => $post['slug'],
            ];

            $this->esClient->index($params);
        }
    }
}
