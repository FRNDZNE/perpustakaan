@extends('layouts.app')
@section('title','Detail Buku')
@section('page-title','Detail Buku')
@section('content')
<div class="container">
    <a href="{{ route('index.buku') }}" class="btn btn-secondary btn-md">Kembali</a>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Informasi Buku</h4>
                    <p><b>Kode Buku :</b> {{ $buku->code }}</p>
                    <p><b>Judul :</b> {{ $buku->name }}</p>
                    <p><b>Penulis :</b> {{ $buku->authors }}</p>
                    <p><b>Penerbit :</b> {{ $buku->publisher }}</p>
                    <p><b>Tanggal Rilis :</b> {{ $buku->release }}</p>
                    <p><b>Stok Buku :</b> {{ $buku->stock }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset($buku->foto) }}" alt="" class="container-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
