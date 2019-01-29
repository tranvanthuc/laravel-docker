<?php

namespace App\Observers;

use Elasticsearch\Client;

class ElasticSearchObserver
{
    protected $elasticSearch;

    public function __construct()
    {
        $this->elasticSearch = app(Client::class);
    }

    public function saved($model)
    {
        $this->elasticSearch->index([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'id'    => $model->id,
            'body'  => $model->toSearchArray(),
        ]);
    }

    public function deleted($model)
    {
        $this->elasticSearch->delete([
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'id'    => $model->id,
        ]);
    }

}
