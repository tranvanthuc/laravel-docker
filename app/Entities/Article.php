<?php

namespace App\Entities;

use App\Search\Searchable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Article.
 *
 * @package namespace App\Entities;
 */
class Article extends Model implements Transformable
{
    use TransformableTrait, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'tags', 'user_id'];

    protected $casts = ['tags' => 'json'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getData()
    {
        $this->load('user');
        return parent::toArray();
    }

}
