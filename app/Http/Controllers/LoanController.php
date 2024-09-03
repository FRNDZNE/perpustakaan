<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Auth;
class LoanController extends Controller
{
    // bagian peminjaman siswa
    public function index_siswa()
    {
        $user = Auth::user();
        $buku = Book::all();
        return view('loan.siswa.index',compact('buku','user'));
    }

    public function store_siswa(Request $request)
    {
        // cek user apakah sedang meminjam buku ini sebelumnya
        $user = Auth::user()->id;
        $book = $request->buku;
        $existingLoan = Loan::where('user_id',$user)
                            ->where('book_id',$book)
                            ->first();
        if ($existingLoan) {
            # code...
            return redirect()->back()->with('error','Anda Sudah Melakukan Proses Pinjam Pada Buku Ini, Silahkan Kembalikan Buku Terlebih Dahulu Jika Ingin Melakukan Peminjaman Kembali');
        }

        $loan = new Loan;
        $loan->user_id = $user;
        $loan->book_id = $book;
        $loan->loan_date = date('Y-m-d');
        $mustReturnDate = date('Y-m-d', strtotime('+7 days'));
        $loan->must_return = $mustReturnDate;
        $loan->save();

        return redirect()->back()->with('success','Berhasil Mengajukan Peminjaman Buku. Silahkan Cek Halaman Daftar Pinjam Untuk Informasi Lebih Lanjut');
    }

    public function delete_siswa($id)
    {
        Loan::find($id)->delete();
        return redirect()->back()->with('success','Berhasil Membatalkan Peminjaman');
    }

    public function my_loan()
    {
        $user = Auth::user()->id;
        $loan = Loan::where('user_id', $user)->get();

        return view('loan.siswa.list',compact('loan'));
    }

    public function history()
    {
        $user = Auth::user()->id;
        $loan = Loan::where('user_id', $user)->withTrashed()->get();

        return view('loan.siswa.history',compact('loan'));

    }

    // akses admin
    public function index_permintaan()
    {
        $loan = Loan::where('validate','c')->get();
        return view('loan.admin.index',compact('loan'));
    }

    public function index_pinjaman()
    {
        $loan = Loan::where('validate','a')->withTrashed()->get();
        return view('loan.admin.list',compact('loan'));
    }

    public function store_admin(Request $request)
    {
        $loan = Loan::where('id', $request->id)->first();
        if ($request->validate) {
            # code...
            $loan->status = 'b';
            $loan->validate = 'a';
            $loan->save();
            return redirect()->back()->with('success','Berhasil Menerima');

        }else {
            # code...
            $loan->validate = 'd';
            $loan->save();
            $loan->delete();
            return redirect()->back()->with('success','Berhasil Menolak');
        }
    }
    public function store_pengembalian(Request $request)
    {
        $loan = Loan::where('id', $request->id)->first();
        $loan->status = 'r';
        $loan->return_date = date('Y-m-d');
        $loan->save();
        $loan->delete();
        return redirect()->back()->with('success','Buku Sudah Dikembalikan');

    }

}
