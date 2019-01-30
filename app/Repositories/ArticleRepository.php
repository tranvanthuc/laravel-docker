<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ArticleRepository.
 *
 * @package namespace App\Repositories;
 */
interface ArticleRepository extends RepositoryInterface
{
    public function search($params = []);
}
