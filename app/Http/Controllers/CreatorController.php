<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreatorRequest;
use Illuminate\Support\Facades\Session;

class CreatorController extends Controller
{
    public function index()
    {
        $creators = Creator::orderBy('id', 'asc')->paginate(10);
        return view('creators.index',
                    [
                        'creators' => $creators
                    ]);
    }

    public function create()
    {
        return view('creators.create');
    }

    public function edit($id)
    {
        $creator = Creator::find($id);
        return view('creators.edit',
                    [
                        'creator' => $creator
                    ]);
    }

    public function store(CreatorRequest $request)
    {
        $request['created_by'] = auth()->user()->id;

        $process = DB::transaction( function() use($request){
            try {
                Creator::create($request->all());
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        if($process){
            Session::flash('status', 'success');
            Session::flash('message', 'Data baru berhasil ditambahkan');
            return redirect()->route('creator');
        } else{
            Session::flash('status', 'failed');
            Session::flash('message', 'Data gagal disimpan, silakan ulangi lagi');
            return redirect()->back();
        }
    }


    public function update(CreatorRequest $request, $id)
    {
        $validated = $request->validated();
        $validated['updated_by'] = auth()->user()->id;

        $process = DB::transaction( function() use($validated, $id){
            try {
                Creator::where('id', $id)->update($validated);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        if($process){
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil diubah');
            return redirect()->route('creator');
        } else{
            Session::flash('status', 'failed');
            Session::flash('message', 'Data gagal diubah, silakan ulangi lagi');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $process = DB::Transaction(function() use($id){
            try {
                Creator::where('id', $id)->delete();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        });

        if ($process) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
            return redirect()->route('creator');
        } else{
            Session::flash('status', 'failed');
            Session::flash('message', 'Data gagal dihapus, silakan ulangi lagi');
            return redirect()->route('creator');
        }
    }

}
