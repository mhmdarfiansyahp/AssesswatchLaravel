@extends('layouts.layout')
@section('konten')
<title>Sertifikasi</title>


    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('sertifikasi.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i>&nbsp;Tambah Sertifikasi
            </a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <select class="form-control btn-block" id="filter-year">
                <option value="">Pilih Tahun</option>
                @for ($i = 0; $i < 5; $i++) 
                    <option value="{{ now()->year - $i }}">{{ now()->year - $i }}</option>
                @endfor
            </select>
        </div>
    </div>


    <div style="overflow-x: auto; width: 100%;">
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
        <table id="skemaTable" class="table table-hover table-bordered table-condensed table-striped grid scrollstyle text-center" width="100%">
            <thead>
                <tr>
                    <th class="align-middle text-center">No.</th>
                    <th class="align-middle text-center">Nama Prodi</th>
                    <th class="align-middle text-center">Nama Sertifikasi</th>
                    <th class="align-middle text-center">Tanggal Sertifikasi</th>
                    <th class="align-middle text-center">Lembaga</th>
                    <th class="align-middle text-center">Level Sertifikasi</th>
                    <th class="align-middle text-center">Bukti Pendukung</th>
                    <th class="align-middle text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>    
                @php
                    $nomor = 1; // Inisialisasi nomor
                @endphp
                @forelse ($sertifikasi as $item)
                    @if ($item->prodi->status == 'Aktif') <!-- Tambahkan pengecekan status prodi -->
                        @if ($item->status == 'Tersedia')
                            <tr>
                        @else
                            <tr class="table-danger"> <!-- Tambahkan kelas 'table-danger' jika status sertifikasi tidak aktif -->
                        @endif
                            <td>{{$nomor++}}</td>
                            <td>{{$item->prodi->nama_prodi}}</td>
                            <td>{{$item['nama_sertifikasi']}}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_sertifikasi)->format('d-F-Y') }}</td>
                            <td>{{$item['lembaga']}}</td>
                            <td>{{$item['level']}}</td>
                            <td>
                                <a href="{{ route('sertifikasi.showPdf', ['id' => $item->id_sertifikasi]) }}" class="btn btn-primary btn-download" target="_blank">
                                    <i class="fa fa-eye"></i> &nbsp;Lihat Bukti Pendukung
                                </a>
                            </td>
                                                        
                            <td>
                                <a href="" id="detail-{{ $item->id_detail_sertifikasi }}" class="btn btn-sm detail-button"
                                    data-toggle="modal" data-target="#modal-detail"
                                    data-kom="{{ $item->kompeten }}"
                                    data-tkom="{{ $item->tidakkompeten }}"
                                    data-tdkh="{{ $item->tidakhadir }}"
                                    data-jmlh="{{ $item->jumlah }}">
                                    <i class="fas fa-list" aria-hidden="true"></i>
                                </a>
                                
                                <a href="{{ route('sertifikasi.edit', ['id' => $item->id_sertifikasi]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
            
                                <form id="deleteForm{{$item->id_sertifikasi}}" action="{{ route('sertifikasi.destroy', ['id' => $item->id_sertifikasi]) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                
                                <button class="btn btn-sm btn-danger delete-button" data-id="{{$item->id_sertifikasi}}" data-status="{{$item->status}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="13" class="text-center">Tidak ada data sertifikasi yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>            
        </table>
    </div>

    <div class="modal fade" id="modal-detail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Sertifikasi </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body table-responsive">
                    <table class="table table-bordered no-margin">
                        <tbody>

                            <tr>
                                <th>Peserta Kompeten</th>
                                <td><span id="modal-detail-kom"></span></td>
                            </tr>
                            <tr>
                                <th>Peserta Tidak Kompeten</th>
                                <td><span id="modal-detail-tkom"></span></td>
                            </tr>
                            <tr>
                                <th>Peserta Tidak Hadir</th>
                                <td><span id="modal-detail-tdkh"></span></td>
                            </tr>                         
                            <tr>
                                <th>Total Peserta</th>
                                <td><span id="modal-detail-jmlh"></span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk meng-handle SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menggunakan SweetAlert untuk konfirmasi penghapusan
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
                    const skemaId = this.getAttribute('data-id');
                    const status = this.getAttribute('data-status');

                    if (status === 'Tidak Tersedia') {
                        Swal.fire({
                            title: 'Gagal Menghapus',
                            text: 'Status Sertifikasi sudah Tidak tersedia.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }else{
                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: 'Apakah Anda yakin ingin menghapus Sertifikasi ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Menampilkan formulir sebelum mengirimkan permintaan DELETE
                                const deleteForm = document.getElementById('deleteForm' + skemaId);
                                deleteForm.submit();
                            }
                        });
                    }
                });
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menggunakan SweetAlert untuk konfirmasi penghapusan
            document.querySelectorAll('.detail-button').forEach(button => {
                button.addEventListener('click', function () {
                    const kompeten = this.getAttribute('data-kom');
                    const tkompten = this.getAttribute('data-tkom');
                    const tidakhadir = this.getAttribute('data-tdkh');
                    const jumlah = this.getAttribute('data-jmlh');
    
                    // Mengisi data modal dengan detail yang sesuai
                    document.getElementById('modal-detail-kom').innerText = kompeten;
                    document.getElementById('modal-detail-tkom').innerText = tkompten;
                    document.getElementById('modal-detail-tdkh').innerText = tidakhadir;
                    document.getElementById('modal-detail-jmlh').innerText = jumlah;

                    // Menampilkan modal
                    $('#modal-detail-').modal('show');
                });
            });
        });

        $(document).ready(function () {
            // Attach event listeners to the dropdowns
            $('#filter-year').change(function () {
                // Get the selected values
                const selectedYear = $('#filter-year').val();

                // Loop through each table row
                $('#skemaTable tbody tr').each(function () {
                    
                    const rowDate = $(this).find('td:eq(3)').text();
                    const rowYear = new Date(rowDate).getFullYear();

                    // Log the values for debugging
                    console.log("Row Year:", rowYear);

                    // Check if the row matches the selected filters
                    const yearMatch = selectedYear === "" || rowYear == selectedYear;

                    // Log the matching results for debugging
                    console.log("Year Match:", yearMatch);

                    // Show or hide the row based on the filter results
                    $(this).toggle(yearMatch);
                });
            });
        });
    </script>

@endsection
