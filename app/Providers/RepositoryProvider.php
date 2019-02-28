<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\ElasticSearchArticleRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Aws\ElasticsearchService\ElasticsearchServiceClient as ElasticsearchServiceClient;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ArticleRepository::class, function ($app) {
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (!config('services.search.enabled')) {
                return new ArticleRepositoryEloquent($app);
            }

            return new ElasticSearchArticleRepositoryEloquent(
                $app
            );
        });

//        $this->bindSearchClient();
        // bind repository
        $this->app->singleton(UserRepository::class, UserRepositoryEloquent::class);
//        $this->app->singleton(ArticleRepository::class, ArticleRepositoryEloquent::class);

    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function () {
            $hosts = config('services.search.hosts');
            return ClientBuilder::create()
                ->setHosts($hosts)
                ->build();
        });
    }
}
