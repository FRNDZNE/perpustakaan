<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    public function index()
    {
        $buku = Book::all();
        return view('buku.index',compact('buku'));
    }

    public function detail($id)
    {
        $buku = Book::where('id',$id)->first();
        return view('buku.detail',compact('buku'));

    }

    public function create()
    {
        $kategori = Category::all();
        return view('buku.create',compact('kategori'));
    }

    public function store(Request $request)
    {
        // Pengecekan Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'numeric' => ucwords(':attribute harus berupa angka'),
            'unique' => ucwords(':attribute sudah ada'),
            'image' => ucwords(':attribute harus berupa gambar'),
        ];
        $attributes = [
            'code' => ucwords('kode buku'),
            'kategori' => ucfirst('kategori'),
            'name' => ucwords('judul buku'),
            'authors' => ucfirst('penulis'),
            'publisher' => ucfirst('penerbit'),
            'release' => ucwords('tanggal rilis'),
            'foto' => ucfirst('foto'),
            'stock' => ucwords('stok buku')
        ];

        $request->validate([
            'code' => 'required|unique:books',
            'kategori' => 'required',
            'name' =>  'required',
            'authors' =>  'required',
            'publisher' =>  'required',
            'release' =>  'required',
            'foto' =>  'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|numeric'
        ], $messages, $attributes);

        // Upload foto
        // Path untuk lokasi gambar
        $path = 'books/'. md5(date('dmyhis')) . '.jpg';
        // proses upload gambar
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($request->file('foto'));
        $encoded = $image->toJpeg(50)->save($path);

        Book::create([
            'code' => $request->code,
            'category_id' => $request->kategori,
            'name' => $request->name,
            'authors' => $request->authors,
            'publisher' => $request->publisher,
            'release' => $request->release,
            'foto' => $path,
            'stock' => $request->stock,
        ]);

        return redirect()->route('index.buku')->with('success','Berhasil Menambah Buku');
    }

    public function edit($id)
    {
        $data['kategori'] = Category::all();
        $data['buku'] = Book::where('id',$id)->first();
        return view('buku.edit',compact('data'));
    }

    public function update($id, Request $request)
    {
        // Pengecekan Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'numeric' => ucwords(':attribute harus berupa angka'),
            'unique' => ucwords(':attribute sudah ada'),
            'image' => ucwords(':attribute harus berupa gambar'),
        ];
        $attributes = [
            'code' => ucwords('kode buku'),
            'kategori' => ucfirst('kategori'),
            'name' => ucwords('judul buku'),
            'authors' => ucfirst('penulis'),
            'publisher' => ucfirst('penerbit'),
            'release' => ucwords('tanggal rilis'),
            'foto' => ucfirst('foto'),
            'stock' => ucwords('stok buku')
        ];

        $request->validate([

            'code' => 'required|unique:books,code,'. $request->code . ',code',
            'kategori' => 'required',
            'name' =>  'required',
            'authors' =>  'required',
            'publisher' =>  'required',
            'release' =>  'required',
            'foto' =>  'image|mimes:jpeg,png,jpg,gif,svg',
            'stock' => 'required|numeric'
        ], $messages, $attributes);


        $buku = Book::where('id', $id)->first();

        // handling gambar
        if ($request->file('foto')) {
            # code...
            if (file_exists($buku->foto)) {
                # code...
                unlink($buku->foto);
            }
            // Upload foto
            // Path untuk lokasi gambar
            $path = 'books/'. md5(date('dmyhis')) . '.jpg';
            // proses upload gambar
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($request->file('foto'));
            $encoded = $image->toJpeg(50)->save($path);

            $buku->foto = $path;

        }

        if ($request->code == $buku->code) {
            # code...
            unset($buku->code);
        }

        $buku->category_id = $request->kategori;
        $buku->name = $request->name;
        $buku->publisher = $request->publisher;
        $buku->authors = $request->authors;
        $buku->release = $request->release;
        $buku->stock = $request->stock;
        $buku->save();
        return redirect()->route('index.buku')->with('success','Berhasil Mengupdate Buku');

    }

    public function delete($id)
    {
        $buku = Book::where('id', $id)->first();
        if (file_exists($buku->foto)) {
            # code...
            unlink($buku->foto);
        }
        $buku->delete();
        return redirect()->back()->with('success','Berhasil Menghapus Buku');
    }
}
