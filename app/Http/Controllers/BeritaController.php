<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$beritas = Berita::select('beritas.id', 'beritas.judul AS judul_berita', 'beritas.isi AS isi_berita')->get();
        return view('beritas.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validate = Validator::make(
            $request->all(),
            [
                'judul' => ['required'],
                'isi' => ['required'],
            ]
        );
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
        if ($request->id != null) {
            $berita = Berita::findOrFail($request->id);
        } else {
            $berita = new Berita();
        }
 
        $berita->judul = $request->judul;
        $berita->isi = $request->isi;
        try {
            $berita->save();
            return response()->json(['success' => 'data saved successfully']);
        } catch (\Throwable $th) {
            return response()->json(['db' => 'Berita failed to save']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
		if ($berita == null) {
            return response()->json(['errors' => ['data' => 'data was not found or an internet error occurred']]);
        }
        return response()->json(['result' => $berita]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
       if ($berita == null) {
            return response()->json(['errors' => ['data' => 'data was not found or an internet error occurred']]);
        }
        try {
            $berita->delete();
            return response()->json(['success' => 'berita deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['data' => 'berita failed to delete']]);
        }
    }
}
