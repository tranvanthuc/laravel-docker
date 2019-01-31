<?php

namespace App\Observers;

use App\Entities\Article;
use App\Notifications\NewArticle;

class ArticleObserver
{
    public function created(Article $article)
    {
        $user = $article->user;
        foreach ($user->followers as $follower) {
            $follower->notify(new NewArticle($user, $article));
        }
    }
}
