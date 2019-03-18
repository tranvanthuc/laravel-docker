<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ArticleRepository;
use App\Entities\Article;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ArticleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ArticleRepositoryEloquent extends BaseRepository implements ArticleRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function search($params = [])
    {
        $query = optional($params)['query'];
        return $this->model->where('body', 'like', "%{$query}%")
            ->orWhere('title', 'like', "%{$query}%")
            ->get();
    }
}
