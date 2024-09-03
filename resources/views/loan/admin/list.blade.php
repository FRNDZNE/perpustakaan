@extends('layouts.app')
@section('title','Peminjaman Buku')
@section('page-title','Peminjaman Buku')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @foreach ($loan as $l)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $l->user->name }}</td>
                                <td>{{ $l->book->name }}</td>
                                <td>{{ $l->loan_date }}</td>
                                <td>{{ $l->return_date ? $l->return_date : 'Belum Dikembalikan' }}</td>
                                <td>
                                    <!-- Modal trigger button -->
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalLoan-{{ $l->id }}"
                                        @if ($l->deleted_at)
                                            disabled
                                        @endif
                                    >
                                        Pengembalian
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div
                                        class="modal fade"
                                        id="modalLoan-{{ $l->id }}"
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
                                                        Pengembalian Buku
                                                    </h5>
                                                    <button
                                                        type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    ></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Siswa Dengan Nama {{ $l->user->name }} Mengembalikan Buku {{ $l->book->name }} ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        Close
                                                    </button>
                                                    <form action="{{ route('admin.pinjaman.store') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $l->id }}">
                                                        <button type="submit" class="btn btn-info">Kembalikan</button>
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
