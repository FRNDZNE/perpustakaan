<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Role;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Imports\UsersImport;
use App\Imports\SiswasImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = User::whereHas('siswa')->get();
        return view('siswa.index',compact('siswa'));
    }

    public function detail($id)
    {
        $siswa = User::where('id',$id)->whereHas('siswa')->first();
        return view('siswa.detail',compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        // Pengecekan Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'unique' => ucwords(':attribute sudah ada'),
            'numeric' => ucwords(':attribute harus berupa angka'),
        ];
        $attributes = [
            'uuid' => ucwords('NISN'),
            'name' => ucwords('nama'),
            'email' => ucfirst('email'),
            'password' => ucfirst('password'),
            'foto' => ucfirst('foto'),
            'address' => ucfirst('alamat'),
            'phone' => ucwords('nomor telepon')
        ];

        $request->validate([
            'uuid' => 'required|unique:users',
            'name' =>  'required',
            'email' =>  'required|unique:users',
            'password' =>  'required',
            'address' =>  'required',
            'foto' =>  'required|image|mimes:jpeg,png,jpg,gif,svg',
            'phone' => 'required|numeric'
        ], $messages, $attributes);

        // Upload foto
        // Path untuk lokasi gambar
        $path = 'profiles/'. md5(date('dmyhis')) . '.jpg';
        // proses upload gambar
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($request->file('foto'));
        $encoded = $image->toJpeg(50)->save($path);

        $role = Role::where('name','siswa')->first();
        $user = User::create([
            'role_id' => $role->id,
            'uuid' => $request->uuid,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'phone' => preg_replace('/^0/', '62', $request->phone),
            'foto' => $path
        ]);

        return redirect()->route('index.user')->with('success','Berhasil Menambah Siswa');
    }

    public function edit($id)
    {
        $data = User::where('id',$id)->wherehas('siswa')->first();
        return view('siswa.edit',compact('data'));
    }

    public function update($id, Request $request)
    {
        // Pengecekan Validasi
        $messages = [
            'required' => ucwords(':attribute tidak boleh kosong !'),
            'unique' => ucwords(':attribute sudah ada'),
            'numeric' => ucwords(':attribute harus berupa angka'),
        ];
        $attributes = [
            'uuid' => ucwords('NISN'),
            'name' => ucwords('judul buku'),
            'email' => ucfirst('email'),
            'password' => ucfirst('password'),
            'foto' => ucfirst('foto'),
            'address' => ucfirst('alamat'),
            'phone' => ucwords('nomor telepon')
        ];

        $request->validate([
            'uuid' => 'required|unique:users,uuid,'. $request->uuid . ',uuid',
            'name' =>  'required',
            'email' =>  'required|unique:users,email,'. $request->email . ',email',
            'address' =>  'required',
            'foto' =>  'image|mimes:jpeg,png,jpg,gif,svg',
            'phone' => 'required|numeric'
        ], $messages, $attributes);


        $user = User::where('id', $id)->first();
        $siswa = Siswa::where('user_id', $id)->first();

        // handling gambar
        if ($request->file('foto')) {
            # code...
            if (file_exists($siswa->foto)) {
                # code...
                unlink($siswa->foto);
            }
            // Upload foto
            // Path untuk lokasi gambar
            $path = 'profiles/'. md5(date('dmyhis')) . '.jpg';
            // proses upload gambar
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($request->file('foto'));
            $encoded = $image->toJpeg(50)->save($path);
            $siswa->foto = $path;
        }
        if ($request->uuid != $user->uuid) {
            $user->uuid = $request->uuid;
        }
        if ($request->email != $user->email) {
            $user->email = $request->email;
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $siswa->address = $request->address;
        $siswa->phone = preg_replace('/^0/', '62', $request->phone);
        $user->save();
        $siswa->save();
        return redirect()->route('index.user')->with('success','Berhasil Mengubah User');

    }

    public function delete($id)
    {
        $siswa = User::where('id', $id)->first();
        if (file_exists($siswa->siswa->foto)) {
            # code...
            unlink($siswa->siswa->foto);
        }
        $siswa->delete();
        return redirect()->back()->with('success','Berhasil Hapus Siswa');
    }

    public function import()
    {
        try {
            //code...
            Excel::import(new UsersImport, request()->file('file'));
            Excel::import(new SiswasImport, request()->file('file'));
            return redirect()->back()->with('success','Berhasil Upload');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
            //throw $th;
        }

    }
}
