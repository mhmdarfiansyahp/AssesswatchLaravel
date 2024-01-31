@extends('layoutsDashboard.layout')
@section('konten')


@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


<style>

    body {
        padding-top: 60px; /* Atur spasi sesuai kebutuhan */
    }

    .row {
        padding-left: 20px; /* Sesuaikan dengan jumlah padding yang diinginkan */
        padding-right: 20px; /* Sesuaikan dengan jumlah padding yang diinginkan */
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td {
        border: 3px solid #ddd;
        padding: 8px;
        text-align: left;
    }
</style>

<style>
    .card {
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan pada card */
        transition: box-shadow 0.3s ease-in-out; /* Efek transisi saat hover */

        /* Menambahkan padding agar card tidak menyentuh tepi layar */
        padding: 10px; 
        margin: 10px;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .scrollstyle {
        overflow-y: auto; /* Tambahkan pengguliran vertikal jika kontennya melebihi tinggi maksimal */
    }
</style>

<div class="container-fluid">
    {{-- <div class="card-logo">
        <img class="card-img-top" src="{{ asset('assets/image/gambar_banner.jpg') }}" alt="Banner Image">
    
        <div class="row">
            <div class="col-lg-4" style="text-align: center; padding: 40px 0px;">
                <img src="{{ asset('assets/image/IMG_LogoTransformationInHarmony.png') }}" class="wow fadeInUp fast" style="width: 60%; visibility: visible; animation-name: fadeInUp; animation-iteration-count: 1;">
            </div>
            <div class="col-lg-4" style="text-align: center; padding: 40px 0px;">
                <img src="{{ asset('assets/image/IMG_LogoKampusMerdeka.png') }}" class="wow fadeInUp fast" style="width: 30%; visibility: visible; animation-name: fadeInUp; animation-iteration-count: 1;">
            </div>
            <div class="col-lg-4" style="text-align: center; padding: 40px 0px;">
                <img src="{{ asset('assets/image/IMG_LogoSatuIndonesia.png') }}" class="wow fadeInUp fast" style="width: 40%; visibility: visible; animation-name: fadeInUp; animation-iteration-count: 1;">
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"> 
                    <h2>Laporan Sertifikasi Mahasiswa Politeknik Astra</h2>
                </div>                
                <br>
                <br>
                <div class="card-body">
                    <div class="col-md-5 col-sm-12">
                    <h4>Grafik Keseluruhan Sertifikasi</h4>
                    </div>
                </div>
                <div class="card-body scrollstyle">
                    <div class="col-md-5 col-sm-12">
                        <div class="row">
                            <div class="col">
                                <select class="form-control" id="filter-year" style="border-radius: 10px;">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = 0; $i < 5; $i++) 
                                        <option value="{{ now()->year - $i }}">{{ now()->year - $i }}</option>
                                    @endfor
                                </select>
                            </div>
    
                            <div class="col">
                                <select class="form-control" id="filter-prodi" style="border-radius: 10px;">
                                    <option value="">Pilih Prodi</option>
                                    @foreach($prodiList as $prodi)
                                        @if($prodi->status === 'Aktif')
                                            <option value="{{ $prodi->id_prodi }}">{{ $prodi->nama_prodi }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>                            
                        
                            <div class="col">
                                <select class="form-control" id="filter-sertifikasi" style="border-radius: 10px;">
                                    <option value="">Pilih Sertifikasi</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="chart-container">
                            <canvas id="myChart" width="180" height="50"></canvas>
                        </div>                
                    </div>
                    <br>
                    <br>
                    <div class="col-12">
                        <table id="skemaTable" class="table table-hover table-bordered table-condensed table-striped grid text-center" width="100%">
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
                                @forelse ($sertifikasi->where('prodi.status', 'Aktif')->sortBy('tanggal_sertifikasi') as $item)
                                <tr data-prodi-id="{{ $item->prodi->id_prodi }}" data-sertifikasi-id="{{ $item->id_sertifikasi }}">
                                    <td class="align-middle text-center">{{$nomor++}}</td>
                                    <td class="align-middle text-center">{{$item->prodi->nama_prodi}}</td>
                                    <td class="align-middle text-center">{{$item['nama_sertifikasi']}}</td>
                                    <td class="align-middle text-center">{{ \Carbon\Carbon::parse($item->tanggal_sertifikasi)->format('d-F-Y') }}</td>
                                    <td class="align-middle text-center">{{$item['lembaga']}}</td>
                                    <td class="align-middle text-center">{{$item['level']}}</td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('sertifikasi.download', ['id' => $item->id_sertifikasi]) }}" class="btn btn-primary btn-download" download>
                                            <i class="fa fa-download"></i> &nbsp;Download Bukti Pendukung
                                        </a>
                                    </td> 
                                    <td class="align-middle text-center">
                                        <a href="" id="detail-{{ $item->id_detail_sertifikasi }}" class="btn btn-sm detail-button"
                                            data-toggle="modal" data-target="#modal-detail"
                                            data-kom="{{ $item->kompeten }}"
                                            data-tkom="{{ $item->tidakkompeten }}"
                                            data-tdkh="{{ $item->tidakhadir }}"
                                            data-jmlh="{{ $item->jumlah }}">
                                            <i class="fas fa-list" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CSS DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<!-- JS DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>





<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
</script>

<script>

loadGrafikkeseluruhan()
$(document).ready(function () {
    // Attach event listeners to the dropdowns
    $('#filter-year, #filter-prodi, #filter-sertifikasi').change(function () {
        // Get the selected values
        const selectedYear = $('#filter-year').val();
        const selectedProdi = $('#filter-prodi').val();
        const selectedSertifikasi = $('#filter-sertifikasi').val();

        // Loop through each table row
        $('#skemaTable tbody tr').each(function () {
            // Get the values from data attributes
            const rowProdiId = $(this).data('prodi-id');
            const rowSertifikasi = $(this).data('sertifikasi-id');

            // Get the value of the date from the fourth column
            const rowDate = $(this).find('td:eq(3)').text();
            const rowYear = new Date(rowDate).getFullYear();

            // Log the values for debugging
            console.log("Row Prodi ID:", rowProdiId, "Row Sertifikasi:", rowSertifikasi, "Row Year:", rowYear);

            // Check if the row matches the selected filters
            const yearMatch = selectedYear === "" || rowYear == selectedYear;
            const prodiMatch = selectedProdi === "" || rowProdiId == selectedProdi;
            const sertifikasiMatch = !selectedSertifikasi || rowSertifikasi == selectedSertifikasi;

            // Log the matching results for debugging
            console.log("Year Match:", yearMatch, "Prodi Match:", prodiMatch, "Sertifikasi Match:", sertifikasiMatch);

            // Show or hide the row based on the filter results
            $(this).toggle(yearMatch && prodiMatch && sertifikasiMatch);
        });
    });
});

$(document).ready(function () {
    // Attach an event listener to the dropdown
    $('#filter-year').change(function () {
        // Get the selected year
        const selectedYear = $(this).val();
        var idProdi = document.getElementById('filter-prodi').value;

        // Call the function to load data based on the selected year
        if (selectedYear === "" && idProdi === "") {
            // Call the function to load data for all years
            loadFilterSertifikasi(null, null);
            loadGrafikkeseluruhan();
        } else if(selectedYear === "" && idProdi !== ""){
            // Call the function to load data based on the selected year
            loadGrafikByProdi(idProdi);
            loadFilterSertifikasi(null, null);
        } else if (selectedYear !== "" && idProdi === ""){
            loadGrafikBytahun(selectedYear);
            loadFilterSertifikasi(null, null);
        } else if(selectedYear !== "" && idProdi !== ""){
            loadFilterSertifikasi(idProdi,selectedYear);
            loadGrafikProdibytahun(idProdi,selectedYear);
        }else {
            loadFilterSertifikasi(null, null);
            loadGrafikBytahun(selectedYear);
        }
    });
});

$(document).ready(function () {
    // Attach an event listener to the dropdown
    $('#filter-prodi').change(function () {
        // Get the selected year
        const idProdi = $(this).val();
        var years = document.getElementById('filter-year').value;
        // Call the function to load data based on the selected year
        if(years === "" && idProdi === ""){
            loadFilterSertifikasi(null, null);
            loadGrafikkeseluruhan();
        } else if(years === "" && idProdi !== ""){
            loadGrafikByProdi(idProdi);
            loadFilterSertifikasi(null, null);
        }else if(years !== "" && idProdi === ""){
            loadGrafikBytahun(years);
            loadFilterSertifikasi(null, null);
        } else if(years !== "" && idProdi !== ""){
            loadFilterSertifikasi(idProdi,years);
            loadGrafikProdibytahun(idProdi,years);
        }else {
            loadFilterSertifikasi(null, null);
            loadGrafikByProdi(idProdi);
        }
        
    });
});

$(document).ready(function () {
    // Attach an event listener to the dropdown
    $('#filter-sertifikasi').change(function () {
        // Get the selected year
        const id_sertifikasi = $(this).val();
        var years = document.getElementById('filter-year').value;
        var idProdi = document.getElementById('filter-prodi').value;

        if(id_sertifikasi === ""){
            loadGrafikProdibytahun(idProdi,years);
        } else {
            loadGrafiksertifikasi(id_sertifikasi);
        }
        
    });
});


    const ctx = document.getElementById('myChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: 50,
                    title: {
                        display: true,
                        text: "Jumlah Sertifikasi",
                        font: {
                            size: 18,
                        },
                        position: 'center'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                datalabels: {
                    align: 'center',
                    anchor: 'start',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    borderRadius: 4,
                    color: 'black',
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value) {
                        return value; // Menambahkan tanda persen pada nilai
                    },                    offset: -12,
                    padding: 4,
                    textAlign: 'center',
                }
            }
        },
        // Tambahkan plugin Chart.js Label
        plugins: [ChartDataLabels]
    });



// Your existing event listener for window resize
window.addEventListener('resize', function () {
    updateChartSize();
});
// Function to update chart size
function updateChartSize() {
    chart.resize();
}
// Initial call to set up the chart size
updateChartSize();

function loadGrafikBytahun(selectedYear) {

    selectedYear = selectedYear || new Date().getFullYear();

    $.ajax({
        url: "/Dashboard/detaildata/"+ selectedYear,
        type: "GET",
        dataType: 'json',
        // data: { year: selectedYear },
        success: function (data) {
            console.log(selectedYear);

            // Map the data into an array
            var newDataArray = data.map(function (item) {
                return {
                    label: item.nama_prodi,
                    kompeten: item.total_kompeten,
                    tidakKompeten: item.total_tidakkompeten,
                    tidakHadir: item.total_tidakhadir,
                };
            });

            // Separate arrays for each dataset
            var kompetenData = newDataArray.map(function (item) {
                return item.kompeten;
            });

            var tidakKompetenData = newDataArray.map(function (item) {
                return item.tidakKompeten;
            });

            var tidakHadirData = newDataArray.map(function (item) {
                return item.tidakHadir;
            });

            // Clear existing datasets
            chart.data.datasets = [];

            // Add bar datasets
            chart.data.datasets.push({
                label: 'Kompeten (Bar)',
                type: 'bar',
                data: kompetenData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Latar belakang biru dengan transparansi
                borderColor: 'rgb(54, 162, 235)',           // Warna batas biru
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakKompeten',
                type: 'bar',
                data: tidakKompetenData,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakHadir',
                type: 'bar',
                data: tidakHadirData,
                backgroundColor: 'rgba(255, 205, 86, 0.2)',
                borderColor: 'rgb(255, 205, 86)',
                borderWidth: 1
            });



            // Update x-axis categories
            chart.data.labels = newDataArray.map(function (item) {
                return item.label;
            });

            // Update the chart
            chart.update();
        },

        // Handle errors in the AJAX request
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            swal.fire("Error!", "Terjadi kesalahan saat mengambil data pemakaian!", "error");
        }
    });

}

function loadGrafikkeseluruhan() {
    $.ajax({
    url: "/Dashboard/alldata",
    type: "GET",
    dataType: 'json',
    // data: { year: selectedYear },
    success: function (data) {

        // Map the data into an array
        var newDataArray = data.map(function (item) {
            return {
                label: item.nama_prodi,
                kompeten: item.total_kompeten,
                tidakKompeten: item.total_tidakkompeten,
                tidakHadir: item.total_tidakhadir,
            };
        });

        // Separate arrays for each dataset
        var kompetenData = newDataArray.map(function (item) {
            return item.kompeten;
        });

        var tidakKompetenData = newDataArray.map(function (item) {
            return item.tidakKompeten;
        });

        var tidakHadirData = newDataArray.map(function (item) {
            return item.tidakHadir;
        });

        // Clear existing datasets
        chart.data.datasets = [];

        // Add bar datasets
        chart.data.datasets.push({
            label: 'Kompeten (Bar)',
            type: 'bar',
            data: kompetenData,
            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Latar belakang biru dengan transparansi
            borderColor: 'rgb(54, 162, 235)',           // Warna batas biru
            borderWidth: 1
        });

        chart.data.datasets.push({
            label: 'TidakKompeten',
            type: 'bar',
            data: tidakKompetenData,
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgb(255, 159, 64)',
            borderWidth: 1
        });

        chart.data.datasets.push({
            label: 'TidakHadir',
            type: 'bar',
            data: tidakHadirData,
            backgroundColor: 'rgba(255, 205, 86, 0.2)',
            borderColor: 'rgb(255, 205, 86)',
            borderWidth: 1
        });

        // Update x-axis categories
        chart.data.labels = newDataArray.map(function (item) {
            return item.label;
        });

        // Update the chart
        chart.update();
    },

    // Handle errors in the AJAX request
    error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        swal.fire("Error!", "Terjadi kesalahan saat mengambil data pemakaian!", "error");
    }
    });

}

function loadGrafikByProdi(sertifikasi) {
    $.ajax({
        url: "/Dashboard/sertifilter/" + sertifikasi,
        type: "GET",
        dataType: 'json',
        // data: { year: selectedYear },
        success: function (data) {
            console.log(sertifikasi);

            // Map the data into an array
            var newDataArray = data.map(function (item) {
                return {
                    label: item.nama_sertifikasi,
                    kompeten: item.total_kompeten,
                    tidakKompeten: item.total_tidakkompeten,
                    tidakHadir: item.total_tidakhadir,
                };
            });

            // Separate arrays for each dataset
            var kompetenData = newDataArray.map(function (item) {
                return item.kompeten;
            });

            var tidakKompetenData = newDataArray.map(function (item) {
                return item.tidakKompeten;
            });

            var tidakHadirData = newDataArray.map(function (item) {
                return item.tidakHadir;
            });

            // Clear existing datasets
            chart.data.datasets = [];

            // Add bar datasets
            chart.data.datasets.push({
                label: 'Kompeten (Bar)',
                type: 'bar',
                data: kompetenData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Latar belakang biru dengan transparansi
                borderColor: 'rgb(54, 162, 235)',           // Warna batas biru
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakKompeten',
                type: 'bar',
                data: tidakKompetenData,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakHadir',
                type: 'bar',
                data: tidakHadirData,
                backgroundColor: 'rgba(255, 205, 86, 0.2)',
                borderColor: 'rgb(255, 205, 86)',
                borderWidth: 1
            });


            // Update x-axis categories
            chart.data.labels = newDataArray.map(function (item) {
                return item.label;
            });

            // Update the chart
            chart.update();
        },

        // Handle errors in the AJAX request
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            swal.fire("Error!", "Terjadi kesalahan saat mengambil data pemakaian!", "error");
        }
    });
}

function loadFilterSertifikasi(id_prodi,years) {
    console.log(id_prodi, years);

    $.ajax({
        url: "/Dashboard/pilihSerti/" + id_prodi + "/" + years,
        type: "GET",
        dataType: 'json',
        // data: { year: selectedYear },
        success: function (data) {
            console.log(id_prodi, years);

            // Map the data into an array
            var newDataArray = data.map(function (item) {
                return {
                    id_serti: item.id_sertifikasi,
                    nama_serti: item.nama_sertifikasi
                };
            });

            console.log(newDataArray);
            $('#filter-sertifikasi').empty();
            $('#filter-sertifikasi').append("<option value=''>Pilih Sertifikasi</option>");

            newDataArray.forEach(function (item) {
                var id_sertifikasi = item.id_serti;
                var nama_sertifikasi = item.nama_serti;

                var newOption = "<option value='" + id_sertifikasi + "'>" + nama_sertifikasi + "</option>";
                $('#filter-sertifikasi').append(newOption);
            });
        },

        // Handle errors in the AJAX request
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            swal.fire("Error!", "Terjadi kesalahan saat mengambil data pemakaian!", "error");
        }
    });
}

function loadGrafiksertifikasi(id_sertifikasi) {
    $.ajax({
        url : "/Dashboard/sertifikasi/" + id_sertifikasi,
        type: "GET",
        dataType: 'json',
        // data: { year: selectedYear },
        success: function (data) {
            console.log(id_sertifikasi,);

            var newDataArray = data.map(function (item) {
                return {
                    label: item.nama_sertifikasi,
                    kompeten: item.kompeten,
                    tidakKompeten: item.tidakkompeten,
                    tidakHadir: item.tidakhadir,
                };
            });

            // Separate arrays for each dataset
            var kompetenData = newDataArray.map(function (item) {
                return item.kompeten;
            });

            var tidakKompetenData = newDataArray.map(function (item) {
                return item.tidakKompeten;
            });

            var tidakHadirData = newDataArray.map(function (item) {
                return item.tidakHadir;
            });

            // Clear existing datasets
            chart.data.datasets = [];

            // Add bar datasets
            chart.data.datasets.push({
                label: 'Kompeten (Bar)',
                type: 'bar',
                data: kompetenData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Latar belakang biru dengan transparansi
                borderColor: 'rgb(54, 162, 235)',           // Warna batas biru
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakKompeten',
                type: 'bar',
                data: tidakKompetenData,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakHadir',
                type: 'bar',
                data: tidakHadirData,
                backgroundColor: 'rgba(255, 205, 86, 0.2)',
                borderColor: 'rgb(255, 205, 86)',
                borderWidth: 1
            });


            // Update x-axis categories
            chart.data.labels = newDataArray.map(function (item) {
                return item.label;
            });

            // Update the chart
            chart.update();
        },

        // Handle errors in the AJAX request
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            swal.fire("Error!", "Terjadi kesalahan saat mengambil data pemakaian!", "error");
        }
    });
}

function loadGrafikProdibytahun(prodi,tahun) {
    $.ajax({
        url: "/Dashboard/prodibytahun/" + prodi + "/" + tahun,
        type: "GET",
        dataType: 'json',
        // data: { year: selectedYear },
        success: function (data) {
            console.log(prodi,tahun);

            // Map the data into an array
            var newDataArray = data.map(function (item) {
                return {
                    label: item.nama_sertifikasi,
                    kompeten: item.kompeten,
                    tidakKompeten: item.tidakkompeten,
                    tidakHadir: item.tidakhadir,
                };
            });

            // Separate arrays for each dataset
            var kompetenData = newDataArray.map(function (item) {
                return item.kompeten;
            });

            var tidakKompetenData = newDataArray.map(function (item) {
                return item.tidakKompeten;
            });

            var tidakHadirData = newDataArray.map(function (item) {
                return item.tidakHadir;
            });

            // Clear existing datasets
            chart.data.datasets = [];

            // Add bar datasets
            chart.data.datasets.push({
                label: 'Kompeten (Bar)',
                type: 'bar',
                data: kompetenData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Latar belakang biru dengan transparansi
                borderColor: 'rgb(54, 162, 235)',           // Warna batas biru
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakKompeten',
                type: 'bar',
                data: tidakKompetenData,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgb(255, 159, 64)',
                borderWidth: 1
            });

            chart.data.datasets.push({
                label: 'TidakHadir',
                type: 'bar',
                data: tidakHadirData,
                backgroundColor: 'rgba(255, 205, 86, 0.2)',
                borderColor: 'rgb(255, 205, 86)',
                borderWidth: 1
            });


            // Update x-axis categories
            chart.data.labels = newDataArray.map(function (item) {
                return item.label;
            });

            // Update the chart
            chart.update();
        },

        // Handle errors in the AJAX request
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            swal.fire("Error!", "Terjadi kesalahan saat mengambil data pemakaian!", "error");
        }
    });
}

</script>

@endsection
