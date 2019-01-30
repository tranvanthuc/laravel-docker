<?php

namespace App\Repositories;

use App\Entities\Article;
use Prettus\Repository\Eloquent\BaseRepository;
use Elasticsearch\Client;
use \Illuminate\Container\Container;

class ElasticSearchArticleRepositoryEloquent extends BaseRepository implements ArticleRepository
{
    private $search;

    public function __construct(Container $app)
    {
        parent::__construct($app);
        $this->search = app(Client::class);
    }

    /**
     * @param $params
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function search($params = [])
    {
        $items = $this->searchOnElasticSearch($params);
        return $this->buildCollection($items);
    }

    /**
     * @param $params
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    private function searchOnElasticSearch($params)
    {
        $query = $params['query'] ?? "";
        $size  = $params['size'] ?? 10;
        $from  = $params['from'] ?? 0;
        if (empty($query)) {
            $body = [
                'query' => [
                    'match_all' => (object)[],
                ],
            ];
        } else {
            $body = [
                'query' => [
                    'multi_match' => [
                        "operator" => "and",
                        "type"     => "phrase_prefix",
                        'fields'   => ['title^3', 'body', 'tags', 'user.name', 'user.email'],
                        'query'    => $query,
                    ],
                ],

            ];
        }
        $body['sort'] = [
            "id" => [
                "order" => "desc"
            ]
        ];
        $items        = $this->search->search([
            'size'  => $size,
            'from'  => $from,
            'index' => $this->makeModel()->getSearchIndex(),
            'type'  => $this->makeModel()->getSearchType(),
            'body'  => $body,


        ]);

        return $items;
    }

    private function buildCollection(array $items)
    {
        /**
         * The data comes in a structure like this:
         *
         * [
         *      'hits' => [
         *          'hits' => [
         *              [ '_source' => 1 ],
         *              [ '_source' => 2 ],
         *          ]
         *      ]
         * ]
         *
         * And we only care about the _source of the documents.
         */
        $hits = array_pluck($items['hits']['hits'], '_source') ?: [];

        $sources = array_map(function ($source) {
            // The hydrate method will try to decode this
            // field but ES gives us an array already.
            $source['tags'] = json_encode($source['tags']);
            return $source;
        }, $hits);

        // We have to convert the results array into Eloquent Models.
        return Article::hydrate($sources);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }
}
