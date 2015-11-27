<?php

namespace Asgrim\Service;

use Elasticsearch\Client as ElasticsearchClient;

class SearchWrapper
{
    /**
     * @var IndexerService
     */
    private $indexerService;

    /**
     * @var ElasticsearchClient
     */
    private $client;

    public function __construct(ElasticsearchClient $client, IndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
        $this->client = $client;
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
    public function search($text)
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

        $results = $this->client->search($params);

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
     */
    public function indexAllPosts()
    {
        $posts = $this->indexerService->getAllPostsFromCache();

        // Clear index first
        $this->client->indices()->delete(['index' => 'posts']);

        // Repopulate
        foreach ($posts as $post) {
            $params = [
                'body' => [
                    'content' => $this->indexerService->getPostContentWithoutMetadata($post['slug'])
                ],
                'index' => 'posts',
                'type' => 'post',
                'id' => $post['slug'],
            ];

            $this->client->index($params);
        }
    }
}
