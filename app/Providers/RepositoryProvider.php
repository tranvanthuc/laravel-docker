<?php

namespace App\Providers;

use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryEloquent;
use App\Repositories\ElasticSearchArticleRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Aws;
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

        $this->bindSearchClient();
        // bind repository
        $this->app->singleton(UserRepository::class, UserRepositoryEloquent::class);

    }

    private function bindSearchClient()
    {
        $isAws = config('services.search.isAws');
        if ($isAws) {
            $psr7Handler        = Aws\default_http_handler();
            $signer             = new Aws\Signature\SignatureV4('es', 'us-west-2');
            $credentialProvider = Aws\Credentials\CredentialProvider::defaultProvider();

            $handler = function (array $request) use ($psr7Handler, $signer, $credentialProvider) {
                // Amazon ES listens on standard ports (443 for HTTPS, 80 for HTTP).
                $request['headers']['host'][0] = parse_url($request['headers']['host'][0])['host'];

                // Create a PSR-7 request from the array passed to the handler
                $psr7Request = new \GuzzleHttp\Psr7\Request(
                    $request['http_method'],
                    (new \GuzzleHttp\Psr7\Uri($request['uri']))
                        ->withScheme($request['scheme'])
                        ->withHost($request['headers']['host'][0]),
                    $request['headers'],
                    $request['body']
                );

                // Sign the PSR-7 request with credentials from the environment
                $signedRequest = $signer->signRequest(
                    $psr7Request,
                    call_user_func($credentialProvider)->wait()
                );

                // Send the signed request to Amazon ES
                /** @var \Psr\Http\Message\ResponseInterface $response */
                $response = $psr7Handler($signedRequest)->wait();

                // Convert the PSR-7 response to a RingPHP response
                return new \GuzzleHttp\Ring\Future\CompletedFutureArray([
                    'status'         => $response->getStatusCode(),
                    'headers'        => $response->getHeaders(),
                    'body'           => $response->getBody()->detach(),
                    'transfer_stats' => ['total_time' => 0],
                    'effective_url'  => (string)$psr7Request->getUri(),
                ]);
            };
            $this->app->bind(Client::class, function () use($handler) {
                $hosts = config('services.search.hosts');
                return ClientBuilder::create()
                    ->setHandler($handler)
                    ->setHosts($hosts)
                    ->build();
            });
        } else {
            $this->app->bind(Client::class, function () {
                $hosts = config('services.search.hosts');
                return ClientBuilder::create()
                    ->setHosts($hosts)
                    ->build();
            });
        }
    }
}
