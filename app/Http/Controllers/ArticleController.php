<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('id', 'asc')->paginate(10);
        return view('articles.index', [
                    'articles' => $articles
        ]);
    }

    public function create()
    {
        $creators = Creator::all();
        return view('articles.create', [
                'creators' => $creators
        ]);
    }

    public function edit($id)
    {
        $article = Article::find($id);
        $creators = Creator::all();
        return view('articles.edit',
                    [
                        'article' => $article,
                        'creators' => $creators
                    ]);
    }

    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();

        if($request->file('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $request->file('image')->storeAs('images', $fileName);
            $validated['image'] =  $fileName;
        }

        $validated['created_by'] = auth()->user()->id;

        $process = DB::transaction( function() use($validated){
            try {
                Article::create($validated);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        if($process){
            Session::flash('status', 'success');
            Session::flash('message', 'Data added succesfuly');
            return redirect()->route('article');
        } else{
            Session::flash('status', 'failed');
            Session::flash('message', 'Data added failed');
            return redirect()->back();
        }
    }


    public function update(ArticleRequest $request, $id)
    {
        $validated = $request->validated();
        Storage::delete('images/'. $request->oldimage);

        if($request->file('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileName = time().'.'.$extension;
            $request->file('image')->storeAs('images', $fileName);
            $validated['image'] =  $fileName;
        }


        $validated['updated_by'] = auth()->user()->id;

        $process = DB::transaction( function() use($validated, $id){
            try {
                Article::where('id', $id)->update($validated);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        if($process){
            Session::flash('status', 'success');
            Session::flash('message', 'Data updated successfuly');
            return redirect()->route('article');
        } else{
            Session::flash('status', 'failed');
            Session::flash('message', 'Data updated failed');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $process = DB::Transaction(function() use($id){
            try {
                $article = Article::find($id);
                Storage::delete('images/'. $article->image);

                Article::where('id', $id)->delete();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        if ($process) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data deleted successfuly');
            return redirect()->route('article');
        } else{
            Session::flash('status', 'failed');
            Session::flash('message', 'Data deleted failed');
            return redirect()->route('article');
        }
    }
}
