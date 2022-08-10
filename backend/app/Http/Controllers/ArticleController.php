<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Article;
use App\Http\Requests\ArticleFormRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::paginate(5);

        return response($articles, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleFormRequest $request)
    {
        $article = new Article();
        $article->name = $request->name;
        $article->description = $request->description;
        $article->content = $request->content;
        $article->category_id = $request->category_id;
        $article->user_id = Auth::id();

        $article->save();

        return response($article, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return response($article, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleFormRequest $request, Article $article)
    {
        $article->name = $request->name;
        $article->description = $request->description;
        $article->content = $request->content;
        $article->category_id = $request->category_id;
        $article->save();

        return response($article, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        Article::destroy($article->id);

        return response('Artigo removido com sucesso!', 200);
    }
}
