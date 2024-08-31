@extends('layouts.app')
@section('title','Daftar Siswa')
@section('page-title','Daftar Siswa')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom untuk tombol Tambah Siswa -->
                        <div class="col">
                            <a href="{{ route('create.user') }}" class="btn btn-md btn-primary">Tambah Siswa</a>
                        </div>
                        <!-- Kolom untuk input file dan tombol Import di sebelah kanan -->
                        <div class="col text-end">
                            <form action="{{ route('import.user') }}" method="post" class="d-inline-flex" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" id="" class="form-control me-2" accept=".xlsx"> <!-- me-2 menambahkan margin kanan -->
                                <button type="submit" class="btn btn-md btn-success">Import</button>
                            </form>
                        </div>
                    </div>

                    <hr>
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                        <thead>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Opsi</th>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->uuid }}</td>
                                    <td>{{ $s->name }}</td>
                                    <td>
                                    {{-- Button Edit Buku --}}
                                        <a href="{{ route('detail.user', $s->id) }}" class="btn btn-info btn-md"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('edit.user', $s->id) }}" class="btn btn-warning btn-md"><i class="fas fa-edit"></i></a>
                                    {{-- End Button Edit --}}
                                    {{-- Modal Delete --}}
                                        <!-- Modal trigger button -->
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-md"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDelete-{{ $s->id }}"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div
                                            class="modal fade"
                                            id="modalDelete-{{ $s->id }}"
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
                                                        <p>Ingin Menghapus {{ $s->name }} Dari Siswa ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal"
                                                        >
                                                            Kembali
                                                        </button>
                                                        <form action="{{ route('delete.user', $s->id) }}" method="post">
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
@section('js')

@endsection
