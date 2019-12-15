<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;

class ArticleController extends Controller
{
    public function index()
    {
        return view("article.index");
    }

    public function store(ArticleStoreRequest $request){
        $article = new Article();

        DB::transaction(function () use ($request, &$article)
        {
            // PHP閉包
            $ids = $request->post("tag_ids");
            $article->title = $request->post("title");
            $article->content = $request->post("content");
            $article->category_id = $request->post("category_id");
            $article->status = (int)$request->post("status");
            $file = $request->file("images");
            if(!empty($file))
            {
                $filepath = $file->store('files');

                $article->images = $filepath;
            }

            $article->save();
            if(!empty($ids))
            {
                $article->tags()->detach();
                $article->tags()->attach($ids);
            }
        });

        $article->category;
        $article->tags;

        return $article;
    }

    public function update(ArticleUpdateRequest $request){


        $id = $request->post("id");
        $title = $request->post("title");
        $content = $request->post("content");
        $category_id = $request->post('category_id');
        $tags = $request->post('tags');
        $status = (int)$request->post("status");
        $file = $request->file("images");

        $article = Article::find($id);
        $article->title = $title;
        $article->content = $content;
        $article->category_id = $category_id;
        $article->status = $status;

        $old = $article->images;

        if(!empty($file))
        {

            $filepath = $file->store('files', "");
            $article->images = $filepath;
        }

        DB::transaction(function () use ($article, $tags) {
            $article->save();
            $article->tags()->detach();
            if(!empty($tags))
            {
                $article->tags()->attach($tags);
            }
        });

        if(!empty($old))
        {
            Storage::delete($old);
        }

        $article->category;
        $article->tags;

        return $article;
    }

    public function get()
    {

        $articles = Article::all();

        foreach ($articles as $article)
        {
            $article->category;
            $article->tags;
        }

        return $articles;
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        //$tag = $request->post('tags');
        $article = Article::find($id);
        $article->delete();
    }

}
