<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController as BaseController;

class ArticleController extends BaseController
{
    public function all()
    {
        $articles = Article::all();
        return $this->sendResponse($articles, 'Articles retrieved successfully.');
    }

    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return $this->sendError('Article not found.');
        }
        $article->oldimage =  $article->image;

        return $this->sendResponse($article, 'Article retrieved successfully.');
    }

    public function store(Request $request)
    {

        $input = $request->all();

        $validator = \Validator::make($input, [
            'title' => 'required|max:25',
            'content' => 'required|max:255',
            'creator_id' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if($request->file('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $request->file('image')->storeAs('images', $fileName);
            $validated['image'] =  $fileName;
        }

        $validated['title'] =  $request->title;
        $validated['content'] =  $request->content;
        $validated['creator_id'] =  $request->creator_id;
        $validated['created_by'] = auth()->user()->id;

        $process = DB::transaction( function() use($validated){
            try {
                $result['data'] = Article::create($validated);
                $result['status'] = true;
                return $result;

            } catch (\Exception $e) {
                $result['data'] = $e;
                $result['status'] = false;
                return $result;
            }
        });

        if($process['status']){
            return $this->sendResponse($process['data'], 'Article created successfully.');
        } else{
            return $this->sendError('Insert data Error.', $process['data']);
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'title' => 'required|max:25',
            'content' => 'required|max:255',
            'creator_id' => 'required',
            'image' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        Storage::delete('images/'. $request->oldimage);

        if($request->file('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $request->file('image')->storeAs('images', $fileName);
            $validated['image'] =  $fileName;
        }

        $validated['title'] =  $request->title;
        $validated['content'] =  $request->content;
        $validated['creator_id'] =  $request->creator_id;
        $validated['updated_by'] = auth()->user()->id;

        $process = DB::transaction( function() use($validated, $id){
            try {
                $result['data'] = Article::where('id', $id)->update($validated);
                $result['status'] = true;
                return $result;

            } catch (\Exception $e) {
                $result['data'] = $e;
                $result['status'] = false;
                return $result;
            }
        });

        if($process['status']){
            return $this->sendResponse($process['data'], 'Article updated successfully.');
        } else{
            return $this->sendError('Update data Error.', $process['data']);
        }
    }

    public function delete($id)
    {
        $process = DB::Transaction(function() use($id){
            try {
                $article = Article::find($id);
                Storage::delete('images/'. $article->image);

                Article::where('id', $id)->delete();
                return true;

                $result['data'] = Article::where('id', $id)->delete();
                $result['status'] = true;

                return $result;
            } catch (\Exception $e) {
                $result['data'] = $e;
                $result['status'] = false;

                return $result;
            }
        });

        if($process['status']){
            return $this->sendResponse($process['data'], 'Article deleted successfully.');
        } else{
            return $this->sendError('Delete data Error.', $process['data']);
        }
    }
}
