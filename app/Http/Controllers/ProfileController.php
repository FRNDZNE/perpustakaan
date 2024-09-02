<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use Auth;


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
        // cari akun terlebih dahulu
        $user = Auth::user();
        $akun = User::where('id', $user->id)->first();
        // update akun di tabel USER
        if ($request->username != $akun->name) {
            $akun->name = $request->username;
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
                $siswa->contact = $request->contact;
                $siswa->day = $request->day;
                $siswa->desc = $request->desc;
                $siswa->address = $request->address;
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
