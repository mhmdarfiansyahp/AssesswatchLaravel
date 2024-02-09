@extends('layouts.layout')
@section('konten')
<title>Program Studi</title>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action='{{ route('prodi.store') }}'>
                {{-- <input type="hidden" class="form-control" name="id_skema" value="">  --}}
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-header">Tambah Program Studi</h5>
                        <br>
                        <div class="col-12">
                            <label for="nama_prodi">
                                Nama Program Studi
                                <span style="color: red;">*</span>
                            </label>
                            
                            <input type="text" name="nama_prodi" class="form-control" id="nama_prodi" value="{{ old('nama_prodi') }}" >
                            @error('nama_prodi')
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
                        <i class="fa fa-floppy-o"></i> Tambah Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection