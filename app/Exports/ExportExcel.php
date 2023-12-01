<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportExcel implements FromCollection, WithHeadings
{
    private $collected_data;
    private $headers;

    public function __construct($data, $headers)
    {
        $this->collected_data = $data;
        $this->headers = $headers;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function collection()
    {
        return new Collection($this->collected_data);
    }
}
