@extends('layouts.app')
@section('title','Detail Siswa')
@section('page-title','Detail Siswa')
@section('content')
<div class="container">
    <a href="{{ route('index.user') }}" class="btn btn-secondary btn-md">Kembali</a>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Informasi Siswa</h4>
                    <p><b>NISN :</b> {{ $siswa->uuid }}</p>
                    <p><b>Nama :</b> {{ $siswa->name }}</p>
                    <p><b>Kontak :</b> <a href="https://wa.me/{{ $siswa->siswa->phone }}" target="_blank">{{ $siswa->siswa->phone }}</a></p>
                    <p><b>Alamat :</b> {{ $siswa->siswa->address }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset($siswa->siswa->foto) }}" alt="" class="container-fluid">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
