@extends('layouts.app')
@section('title','Daftar Buku')
@section('page-title','Daftar Buku')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('create.buku') }}" class="btn btn-md btn-primary">Tambah Buku</a>
                    <hr>
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Judul Buku</th>
                            <th>Stok</th>
                            <th>Tersedia</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @foreach ($buku as $b)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $b->category->name }}</td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->stock }}</td>
                                    <td>0</td>
                                    <td>
                                    {{-- Button Edit Buku --}}
                                        <a href="{{ route('detail.buku', $b->id) }}" class="btn btn-info btn-md"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('edit.buku', $b->id) }}" class="btn btn-warning btn-md"><i class="fas fa-edit"></i></a>
                                    {{-- End Button Edit --}}
                                    {{-- Modal Delete --}}
                                        <!-- Modal trigger button -->
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-md"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDelete-{{ $b->id }}"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div
                                            class="modal fade"
                                            id="modalDelete-{{ $b->id }}"
                                            tabindex="-1"
                                            data-bs-backdrop="static"
                                            data-bs-keyboard="false"

                                            role="dialog"
                                            aria-labelledby="modalTitleId"
                                            aria-hidden="true"
                                        >
                                            <div
                                                class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                                role="document"
                                            >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitleId">
                                                            Hapus Kategori
                                                        </h5>
                                                        <button
                                                            type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close"
                                                        ></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Ingin Menghapus Buku {{ $b->name }} Dari Daftar Buku ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal"
                                                        >
                                                            Kembali
                                                        </button>
                                                        <form action="{{ route('delete.buku', $b->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- End Modal Delete --}}
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
