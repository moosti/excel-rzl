<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultExport implements FromArray, WithHeadings
{
    public function __construct(public array $c)
    {
    }

    public function array(): array
    {
        return $this->c;
    }

    public function headings(): array
    {
        return array_keys($this->c[0]);
    }
}
