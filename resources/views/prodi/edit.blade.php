@extends('layouts.layout')
@section('konten')
<title>Program Studi</title>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('prodi.update',$prodi->id_prodi) }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-header">Ubah Program Studi</h5>
                        <br>
                            @method('PUT')
                            <div class="col-12">
                                <label for="nama_prodi">
                                    Nama Program Studi
                                    <span style="color: red;">*</span>
                                </label>
                                
                                <input type="text" name="nama_prodi" class="form-control" value="{{ old('nama_prodi',$prodi->nama_prodi) }}">
                                @error('nama_prodi')
                                    <span class="text-danger">{{ $message }}</span><br>
                                @enderror
                            </div>
                            <br>
                            <div class="col-12">
                                <label for="status">
                                    Pilih Status
                                    <span style="color: red;">*</span>
                                </label>
                                <select name="status" class="form-control" id="status">
                                    <option value="" selected disabled>-- Pilih Status Prodi --</option>
                                    <option value="Aktif" {{ old('status', $prodi->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status', $prodi->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
                        <a href="{{ route('prodi.index') }}" class="btn btn-secondary mb-1">
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