<?php

namespace App\Http\Controllers\API;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /** @var ArticleRepository $articleRepo */
    protected $articleRepo;


    public function __construct()
    {
        $this->articleRepo = app(ArticleRepository::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function list(Request $request)
    {
        $articles = $this->articleRepo->search($request->get('q'));
        $view = view('articles.list', compact('articles'))->render();
        return response()->json($view);
    }
}
