<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class DetailsImport implements  OnEachRow, WithHeadingRow
{
    public function __construct(private readonly int $headerIndex = 0)
    {
    }

    public function onRow(Row $row): void
    {
        $row = $row->toArray();
    }

    public function headingRow(): int
    {
        return max(0, $this->headerIndex - 1);
    }
}
