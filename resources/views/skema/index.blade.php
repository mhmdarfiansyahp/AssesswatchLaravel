@extends('layouts.layout')
@section('konten')
<center>
    <span style="font-size: Larger; font-weight: bold;">Daftar Skema</span>
</center><br>

<div class="row mb-3">
    <div class="col-12">
        <a href="" class="btn btn-success">
            <i class="fa fa-plus"></i>&nbsp;Tambah Skema
        </a>
    </div>
</div>

<div style="overflow-x: auto; width: 100%;">
    <table id="skemaTable" class="table table-hover grid scrollstyle text-center" width="100%">
        <thead>
            <tr>
                <th class="align-middle text-center">No.</th>
                <th class="align-middle text-center">Nama Skema</th>
                <th class="align-middle text-center">Tanggal Pelaksanaan</th>
                <th class="align-middle text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php if (empty($skema)): ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada data skema yang tersedia.</td>
            </tr>
        <?php else: ?>
        <?php $i=0; ?>
            <?php foreach ($skema as $skm) {?>
            <tr style="height: 45px;">
            <td class="text-center">
                    <?php $i++; ?>
                    <?php echo $i ?>
                </td>
                <td><?php echo $skm->Nama_Skema?></td>
                <td><?php 
                    $start_date = date('d F Y', strtotime($skm->start_date));
                    $end_date = date('d F Y', strtotime($skm->end_date));

                    // Pengecekan apakah bulan dan tahun sama
                    $start_month_year = date('mY', strtotime($skm->start_date));
                    $end_month_year = date('mY', strtotime($skm->end_date));


                    // Tambahkan logika untuk menampilkan satu atau dua tanggal
                    if($start_date === $end_date){
                        echo $start_date;
                    }else{
                        if ($start_month_year === $end_month_year) {
                            // Format jika bulan dan tahun sama
                            $start_day = date('d', strtotime($skm->start_date));
                            $end_day = date('d', strtotime($skm->end_date));
                            $month = date('F', strtotime($skm->start_date));
                            $year = date('Y', strtotime($skm->start_date));
                            echo "$start_day-$end_day $month $year";
                        } else {
                            // Format jika bulan dan tahun berbeda
                            echo "$start_date - $end_date";
                        }
                    }
                ?></td>
                <td class="text-center">
                    <?php echo anchor('Skema/getUpdate/' .$skm->id_skema, 
                    '<div class="btn btn-primary btn-sm mr-1 mdi mdi-pen"> 
                    </div>') ?>
                </td>

                <td class="text-center remove" data-id="<?php echo $skm->id_skema ?>">
                    <div class="btn btn-danger btn-sm ml--5 mdi mdi-delete"></div>
                </td>
            </tr>
            <?php } ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="row mb-3">
    <div class="col-12">
        <a href="" class="btn btn-warning">
            <i class="fa fa-upload"></i>&nbsp;Import dari Excel
        </a>
    </div>
</div>
<script type="text/javascript">
    $(".remove").click(function() {
        var id = $(this).data('id');
        console.log(id);

        Swal.fire({
            title: 'Apakah anda yakin menghapus  dengan ID ' + id,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5cxb85c',
            cancelButtonColor: '#d9534f',
            confirmButtonText: 'Ya Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/assesswatch/Skema/postDelete/' + id,
                    method: "POST"
                });

                Swal.fire({
                    title: 'Berhasil !',
                    text: ' dengan ID ' + id + '. Berhasil Dihapus.',
                    type: 'success',
                    icon: 'success'
                }).then(okay => {
                    if (okay) {
                        window.location.href = ""
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Batal !',
                    text: ' dengan ID ' + id + '. Batal Dihapus.',
                    type: 'error',
                    icon: 'error'
                });
            }
        });
    });
</script>

@endsection