<?php

namespace App\Observers;

use App\Entities\Article;
use App\Entities\User;
use App\Notifications\NewArticle;

class ArticleObserver
{
    public function created(Article $article)
    {
        $author = $article->user;
        $user  = User::first();
        $user->notify(new NewArticle($article, $author));
    }
}
