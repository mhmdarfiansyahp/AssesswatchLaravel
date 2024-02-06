@extends('layouts.layout')
@section('konten')
<title>Sertifikasi</title>


<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action='{{ route('sertifikasi.update', $sertifikasi->id_sertifikasi) }}' enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-header">Ubah Sertifikasi</h5>
                        <br>
                        <div class="col-12">
                            <label for="id_prodi">
                                Pilih Prodi
                                <span style="color: red;">*</span>
                            </label>
                            
                            <select name="id_prodi" class="form-control @error('id_prodi') is-invalid @enderror" id="id_prodi">
                                <option value="" selected disabled> -- Pilih Program Studi --</option>
                                @foreach ($prodis as $item)
                                    <option value="{{ $item->id_prodi }}" {{ old('id_prodi', $sertifikasi->id_prodi ?? '') == $item->id_prodi ? 'selected' : '' }}>
                                        {{ $item->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_prodi')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>                                                
                        <br>
                        <div class="col-12">
                            <label for="nama_sertifikasi">
                                Nama Sertifikasi
                                <span style="color: red;">*</span>
                            </label>
                            
                            <input type="text" name="nama_sertifikasi" class="form-control" id="nama_sertifikasi" value="{{ old('nama_sertifikasi', $sertifikasi->nama_sertifikasi) }}" >
                            @error('nama_sertifikasi')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="tanggal_sertifikasi">
                                Tanggal Sertifikasi
                                <span style="color: red;">*</span>
                            </label>
                            
                            <input type="date" name="tanggal_sertifikasi" class="form-control" id="tanggal_sertifikasi" value="{{ old('tanggal_sertifikasi',$sertifikasi->tanggal_sertifikasi) }}" >
                            
                            @error('tanggal_sertifikasi')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="lembaga">
                                Lembaga
                                <span style="color: red;">*</span>
                            </label>
                            
                            <input type="text" name="lembaga" class="form-control" id="lembaga" value="{{ old('lembaga', $sertifikasi->lembaga) }}" >
                            @error('lembaga')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="level">
                                Level Sertifikasi
                                <span style="color: red;">*</span>
                            </label>
                            
                            <select name="level" class="form-control @error('level') is-invalid @enderror" id="level">
                                <option selected disabled> -- Pilih Level Sertifikasi --</option>
                                <option value="Nasional" {{ old('level', $sertifikasi->level ?? '') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="Internasional" {{ old('level', $sertifikasi->level ?? '') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('level')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>                                                
                        <br>
                        <div class="col-12">
                            <label for="buktipendukung">
                                Bukti Pendukung
                                <span style="color: red;">*</span>
                            </label>
                    
                            <input type="file" name="buktipendukung" class="form-control" id="buktipendukung"value="{{ old('buktipendukung')}}">
                            @error('buktipendukung')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="kompeten">Peserta Kompeten <span style="color: red;">*</span></label>
                            <input type="number" name="kompeten" class="form-control" id="kompeten" value="{{ old('kompeten', $sertifikasi->kompeten) }}" onchange="hitungJumlahPeserta()">
                            @error('kompeten')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="tidakkompeten">Peserta Tidak Kompeten <span style="color: red;">*</span></label>
                            <input type="number" name="tidakkompeten" class="form-control" id="tidakkompeten" value="{{ old('tidakkompeten', $sertifikasi->tidakkompeten) }}" onchange="hitungJumlahPeserta()">
                            @error('tidakkompeten')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="tidakhadir">Peserta Tidak Hadir <span style="color: red;">*</span></label>
                            <input type="number" name="tidakhadir" class="form-control" id="tidakhadir" value="{{ old('tidakhadir', $sertifikasi->tidakhadir) }}" onchange="hitungJumlahPeserta()">
                            @error('tidakhadir')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                        </div>
                        <br>
                        <div class="col-12">
                            <label for="jumlah">Total Peserta <span style="color: red;">*</span></label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" value="{{ old('jumlah', $sertifikasi->jumlah) }}" readonly>
                            <!-- readonly agar nilai tidak dapat diubah manual oleh pengguna -->
                        </div>
                    </div>
                    <br>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('sertifikasi.index') }}" class="btn btn-secondary mb-1">
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

<script>
    // Fungsi untuk menghitung jumlah peserta
    function hitungJumlahPeserta() {
        // Ambil nilai dari ketiga kolom
        var pesertaKompeten = parseInt(document.getElementById('kompeten').value) || 0;
        var pesertaTidakKompeten = parseInt(document.getElementById('tidakkompeten').value) || 0;
        var pesertaTidakHadir = parseInt(document.getElementById('tidakhadir').value) || 0;

        // Hitung jumlah total
        var totalPeserta = pesertaKompeten + pesertaTidakKompeten + pesertaTidakHadir;

        // Tampilkan hasil di kolom keempat
        document.getElementById('jumlah').value = totalPeserta;
    }
</script>

@endsection