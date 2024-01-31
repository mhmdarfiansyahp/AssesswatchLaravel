@extends('layouts.layout')
@section('konten')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action='{{ route('pengguna.store') }}'>
                {{-- <input type="hidden" class="form-control" name="id_skema" value="">  --}}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-header">Tambah Pengguna</h5>
                        <br>
                        <div class="col-12">
                            <label for="nama">
                                Nama
                                <span style="color: red;">*</span>
                            </label>
                            
                            <input type="text" name="nama" class="form-control" id="nama" value="{{ old('nama') }}" >
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="username">
                                Username
                                <span style="color: red;">*</span>
                            </label>
                            
                            <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}" >
                            @error('username')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="password">
                                Password
                                <span style="color: red;">*</span>
                            </label>
                            
                            <input type="text" name="password" class="form-control" id="password" value="{{ old('password') }}" >
                            @error('password')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                    </div>
                    <br>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('pengguna.index') }}" class="btn btn-secondary mb-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary mb-1">
                        <i class="fa fa-floppy-o"></i> Tambah Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection