@extends('layouts.layout')
@section('konten')

    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('prodi.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i>&nbsp;Tambah Program Studi
            </a>
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
                    <th class="align-middle text-center">Nama Program Studi</th>
                    <th class="align-middle text-center">Status</th>
                    <th class="align-middle text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>    
                @php
                    $nomor = 1; // Inisialisasi nomor
                @endphp
                @forelse ($prodi as $item)
                    <tr>
                        <td>{{$nomor++}}</td>
                        <td>{{$item['nama_prodi']}}</td>                        
                        <td>{{$item['status']}}</td>
                        <td>
                            <a href="{{ route('prodi.edit', ['id' => $item->id_prodi]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="deleteForm{{$item->id_prodi}}" action="{{ route('prodi.destroy', ['id' => $item->id_prodi]) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            
                            <button class="btn btn-sm btn-danger delete-button" data-id="{{$item->id_prodi}}" data-status="{{$item->status}}">
                                <i class="fas fa-trash"></i>
                            </button>
                            
                        </td>   
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data Program Studi yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Script untuk meng-handle SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menggunakan SweetAlert untuk konfirmasi penghapusan
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
                    const skemaId = this.getAttribute('data-id');
                    // Mengambil status pengguna dari data-status atribut pada button
                    const status = this.getAttribute('data-status');
    
                    if (status === 'Tidak Aktif') {
                        // Jika status sudah tidak aktif, tampilkan pesan validasi langsung
                        Swal.fire({
                            title: 'Gagal Menghapus',
                            text: 'Status Program Studi sudah tidak aktif.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: 'Apakah Anda yakin ingin mengubah Status Program Studi ini?',
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
    
    
    
@endsection
