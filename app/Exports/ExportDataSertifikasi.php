<?php

namespace App\Exports;

use App\Models\Detailserti;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportDataSertifikasi implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Detailserti::orderBy('name', 'asc')->get();
        return $data;
    }
}
