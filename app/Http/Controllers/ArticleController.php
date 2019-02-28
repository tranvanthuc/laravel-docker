<?php

namespace App\Http\Controllers;

use App\Entities\Article;
use App\Events\MessagePosted;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /** @var ArticleRepository $articleRepo */
    protected $articleRepo;


    public function __construct()
    {
        $this->articleRepo = app(ArticleRepository::class);
    }

    public function index()
    {
        //        $articles = $this->articleRepo->with('user')->paginate(10);
        //        return view('articles.index', compact('articles'));
        return redirect()->route('search');
    }

    public function search()
    {
        $articles = $this->articleRepo->search();
        return view('articles.index', compact('articles'));
    }

    public function getCreate()
    {
        return view('articles.create');
    }

    public function postCreate(Request $request)
    {
        $params            = $request->all();
        $params['user_id'] = auth()->id();
        $params['tags']    = explode(",", $request->input('tags'));
        $article           = $this->articleRepo->create($params);
        return redirect()->route('edit.get', ['id' => $article->id]);
    }

    public function getEdit($id)
    {
        $article = $this->articleRepo->find($id);
        return view('articles.edit', compact('article'));
    }

    public function postEdit(Request $request, $id)
    {
        $params = $request->all();

        // convert string to array
        $params['tags'] = explode(",", $request->input('tags'));
        $this->articleRepo->update($params, $id);
        return redirect()->route('edit.get', ['id' => $id]);
    }
}
