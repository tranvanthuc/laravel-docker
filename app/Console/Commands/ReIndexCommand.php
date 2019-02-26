<?php

namespace App\Console\Commands;

use App\Entities\Article;
use App\Entities\User;
use App\Events\MessagePosted;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to elasticsearch';

    private $search;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->search = app(Client::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Indexing all articles. Might take a while...');

        foreach (Article::all() as $model) {
            $this->search->index([
                'index' => $model->getSearchIndex(),
                'type'  => $model->getSearchType(),
                'id'    => $model->id,
                'body'  => $model->toSearchArray(),
            ]);

            // PHPUnit-style feedback
            $this->output->write('.' . $model->id);
        }

        $this->info("nDone!");
    }
}
