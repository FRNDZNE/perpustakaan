@extends('layouts.app')
@section('title','Daftar Pinjaman Saya')
@section('page-title','Daftar Pinjaman Saya')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Harus Kembalikan</th>
                            <th>Status Peminjaman</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @foreach ($loan as $l)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $l->book->name }}</td>
                                <td>{{ $l->loan_date }}</td>
                                <td>{{ $l->must_return }}</td>
                                <td>
                                    @switch($l->validate)
                                        @case('c')
                                            <span class="badge bg-info">Dikonfirmasi</span>
                                            @break
                                        @case('a')
                                            <span class="badge bg-success">Diterima</span>
                                            @break
                                        @case('d')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                        @default

                                    @endswitch
                                </td>
                                <td>
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-md"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalBatal-{{ $l->id }}"
                                        @if ($l->validate == 'a')
                                            disabled
                                        @endif
                                    >
                                        Batalkan
                                    </button>
                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalBatal-{{ $l->id }}"
                                        tabindex="-1"
                                        data-bs-backdrop="static"
                                        data-bs-keyboard="false"

                                        role="dialog"
                                        aria-labelledby="modalTitleId"
                                        aria-hidden="true"
                                    >
                                        <div
                                            class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                            role="document"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Batalkan Peminjaman
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Ingin Membatalkan Peminjaman Buku {{ $l->book->name }} ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('siswa.loan.delete',$l->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Batalkan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
