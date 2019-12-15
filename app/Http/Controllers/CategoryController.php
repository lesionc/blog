<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{

    public function index()
    {
        return view("category.index");
    }


    public function store(CategoryStoreRequest $request)
    {
        $category = new Category();

        $category->name = $request->name;
        $category->status = (int) $request->status;

        $category->save();

        return $category;
    }

    public function update(CategoryUpdateRequest $request)
    {
        $id = $request->id;
        $name = $request->name;
        $status = $request->status;
        $category = Category::find($id);
        $category->name = $name;
        $category->status = (int) $status;
        $category->save();
        return $category;
    }

    public function get()
    {
        $categorys = Category::all();
        foreach ($categorys as $category)
        {
            $category->category;

            $category->status;
        }
        return $categorys;

    }

    public function drop(Request $request){
        $id = $request->id;
        $category = Category::find($id);

        $category->id=$id;
        //判斷是否為空
        $article = Article::where('category_id', $id)->first();
        if(!empty($article)){
            //不為空，拋異常
            throw new Exception("不能刪除存在文章的分類", 500);
        }else{
            //為空，刪除
            $category->delete();
        }
    }

}

