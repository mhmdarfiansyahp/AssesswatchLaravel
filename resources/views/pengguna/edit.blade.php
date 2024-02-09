@extends('layouts.layout')
@section('konten')
<title>Pengguna</title>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('pengguna.update',$pengguna->id_user) }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-header">Ubah Pengguna</h5>
                        <br>
                            @method('PUT')
                            <div class="col-12">
                                <label for="nama">
                                    Nama 
                                    <span style="color: red;">*</span>
                                </label>
                                
                                <input type="text" name="nama" class="form-control" value="{{ old('nama',$pengguna->nama) }}">
                            </div>
                            <br>
                            <div class="col-12">
                                <label for="username">
                                    Username 
                                    <span style="color: red;">*</span>
                                </label>
                                
                                <input type="text" name="username" class="form-control" value="{{ old('username',$pengguna->username) }}">
                            </div>
                            <br>
                            <div class="col-12">
                                <label for="password">
                                    Password 
                                    <span style="color: red;">*</span>
                                </label>
                                
                                <input type="text" name="password" class="form-control" value="{{ old('password',$pengguna->password) }}">
                            </div>
                            <br>
                            <div class="col-12">
                                <label for="status">
                                    Pilih Status
                                    <span style="color: red;">*</span>
                                </label>
                                <select name="status" class="form-control" id="status">
                                    <option value="" selected disabled>-- Pilih Status Prodi --</option>
                                    <option value="Aktif" {{ old('status', $pengguna->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status', $pengguna->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>                                
                                @error('status')
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
                            <i class="fa fa-floppy-o"></i> Ubah Data 
                        </button>
                    </div>
            </form>
        </div>
    </div>
</section>
@endsection