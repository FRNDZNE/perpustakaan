<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use Auth;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = ['admin','siswa'];
        if (in_array($user->role->name, $roles)) {
            return view('profiles.' . $user->role->name, compact('user'));
        } else {
            return abort(403); // Menggunakan abort untuk menampilkan halaman 403
        }
    }

    public function update(Request $request)
    {
        // Pengecekan Validasi
        // untuk siswa
        if (Auth::user()->role->name == 'siswa') {
            # code...
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

        }elseif (Auth::user()->role->name == 'admin') {
            $messages = [
                'required' => ucwords(':attribute tidak boleh kosong !'),
                'unique' => ucwords(':attribute sudah ada'),
                'numeric' => ucwords(':attribute harus berupa angka'),
            ];

            $attributes = [
                'uuid' => ucwords('NISN'),
                'email' => ucfirst('email'),
            ];

            $request->validate([
                'uuid' => 'required|unique:users,uuid,'. $request->uuid . ',uuid',
                'email' =>  'required|unique:users,email,'. $request->email . ',email',
            ], $messages, $attributes);
        }

        // end validate siswa
        // cari akun terlebih dahulu
        $user = Auth::user();
        $akun = User::where('id', $user->id)->first();
        // update akun di tabel USER

        if ($request->uuid != $akun->uuid) {
            $akun->uuid = $request->uuid;
        }
        if ($request->email != $akun->email) {
            $akun->email = $request->email;
        }
        if (isset($request->password)) {
            $akun->password = bcrypt($request->password);
        }

        switch ($user->role->name) {
            case 'siswa';
                $siswa = Siswa::where('user_id', $user->id)->first();
                // Proses Upload Foto
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
                // End Upload Foto
                $siswa->address = $request->address;
                $siswa->phone = preg_replace('/^0/', '62', $request->phone);
                $siswa->save();
                break;
            default:
                # code...
                break;
        }
        $akun->save();
        return redirect()->back()->with('success','Berhasil Mengupdate Data');
    }
}
