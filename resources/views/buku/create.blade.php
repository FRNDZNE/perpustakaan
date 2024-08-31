@extends('layouts.app')
@section('title','Tambah Buku')
@section('page-title','Tambah Buku')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('store.buku') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}" >{{ $k->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="code" class="form-label">Kode Buku</label>
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" placeholder="Masukan Kode Buku" value="{{ old('code') }}">
                                    @error('code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="name" class="form-label">Judul Buku</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukan Judul Buku" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="stock" class="form-label">Stock Buku</label>
                                    <input type="number" min="0" name="stock" id="stock" class="form-control @error('name') is-invalid @enderror" placeholder="Stok Buku" value="{{ old('stock') }}">
                                    @error('stock')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="authors" class="form-label">Penulis</label>
                                    <input type="text" name="authors" id="" class="form-control @error('authors') is-invalid @enderror" placeholder="Masukan Nama Penulis" value="{{ old('authors') }}">
                                    @error('authors')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="publisher" class="form-label">Penerbit</label>
                                    <input type="text" name="publisher" id="publisher" class="form-control @error('publisher') is-invalid @enderror" placeholder="Masukan Penerbit Buku" value="{{ old('publisher') }}">
                                    @error('publisher')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="release" class="form-label">Tanggal Rilis</label>
                                    <input type="date" name="release" id="release" class="form-control @error('release') is-invalid @enderror" value="{{ old('release') }}">
                                    @error('release')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                    @error('foto')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('index.buku') }}" class="btn btn-md btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
