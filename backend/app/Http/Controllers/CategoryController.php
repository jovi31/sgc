<?php

namespace App\Http\Controllers;

use App\Category;
use App\Article;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $this->addPath($categories);

        $sorted = $categories->sortBy(function ($category) {
            return $category->path;
        });

        return response($sorted->values()->all(), 200);
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
    public function store(CategoryFormRequest $request)
    {
        $category = Category::create($request->all());

        return response($category, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response($category, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;

        $category->save();

        return response($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);

        return response('Categoria removida com sucesso!', 200);
    }

    private function addPath($categories)
    {
        function getParent($categories, $parent_id)
        {
            $isParent = function($category) use (&$parent_id) {
                return ($category->id == $parent_id);
            };

            $parent = $categories->first($isParent);
            return $parent;
        }

        foreach($categories as $category)
        {
            $path = '';
            $parent = $category;
            do {
                $path = '/' . $parent->name . $path;
                $parent = getParent($categories, $parent->parent_id);
            } while($parent);
            $category['path'] = $path;
        }
    }

    private function categoryTree($categories)
    {
        foreach($categories as $category)
        {
            $subCategories = $category->children;
            if ($subCategories) {
                $category['children'] = $subCategories;
                $this->categoryTree($subCategories);
            }
        }
    }

    public function tree()
    {
        $categories = Category::where('parent_id', null)->get();

        if($categories) {
            $this->categoryTree($categories);
        }

        return response($categories, 200);
    }

    public function getRelatedArticles($categoryId)
    {
        $query = 
            'WITH RECURSIVE subcategories (id) AS (
                SELECT id FROM categories WHERE id = ?
                UNION ALL
                SELECT c.id FROM subcategories, categories c
                    WHERE c.parent_id = subcategories.id
            )
            SELECT id FROM subcategories';

        $db_categories = DB::select($query, array($categoryId));
        $categories = Category::hydrate($db_categories);

        $articles = Article::select('id', 'name', 'description', 'category_id')
            ->whereIn('category_id', $categories)
            ->get();

        return $articles;
    }
}
