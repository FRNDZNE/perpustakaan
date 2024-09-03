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
                            <th>Tanggal Kembali</th>
                            <th>Status Peminjaman</th>
                        </thead>
                        <tbody>
                            @foreach ($loan as $l)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $l->book->name }}</td>
                                <td>{{ $l->loan_date }}</td>
                                <td>{{ $l->return_date }}</td>
                                <td>
                                    @switch($l->validate)
                                        @case('c')
                                            @if ($l->deleted_at)
                                            <span class="badge bg-dark">Dibatalkan</span>
                                            @else
                                            <span class="badge bg-info">Dikonfirmasi</span>
                                            @endif
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
