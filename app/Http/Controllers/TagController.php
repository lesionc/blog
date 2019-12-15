<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return view("tag.index");
    }

        public function store(Request $request){
            $tag = new Tag();
            $tag->name = $request->post('name');
            $tag->save();
            return $tag;
        }

        public function update(Request $request){
            $id = $request->post('id');
            $name = $request->post('name');
            $tag = Tag::find($id);
            $tag->name = $name;
            $tag->save();
            return $tag;
        }

        public function get(){
        $tags = Tag::all();
        foreach ($tags as $tag)
        {
            $tag->tags;
            }
        return $tags;
        }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $tag = Tag::find($id);
        $tag->delete();
    }
}
