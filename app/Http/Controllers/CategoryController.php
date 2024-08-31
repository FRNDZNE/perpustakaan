<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $kategori = Category::all();
        return view('kategori.index',compact('kategori'));
    }

    public function store(Request $request)
    {
        // Pengecekan Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'), // Pesan Validasi
        ];

        $attributes = [ // kustomasi nama atribut
            'kategori' => ucwords('nama kategori'),
        ];

        $request->validate([ //pemberian validasi
            'kategori' => 'required',
        ], $messages, $attributes);

        $kategori = Category::updateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'name' => $request->kategori,
            ]
        );

        if ($kategori->wasRecentlyCreated) {
            # code...
            return redirect()->back()->with('success', 'Berhasil Menambah Kategori');
        }else{
            return redirect()->back()->with('success', 'Berhasil Mengubah Kategori');
        }
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus Kategori');
    }
}
