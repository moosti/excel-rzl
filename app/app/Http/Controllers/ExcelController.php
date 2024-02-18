<?php

namespace App\Http\Controllers;

use App\Exports\ResultExport;
use App\Imports\DetailsImport;
use App\Imports\PointsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function import(Request $request)
    {
        Storage::delete('public/result');
        $a = Excel::toArray(
            new PointsImport(2),
            $request->file('a'),
            'public'
        );
        dd(array_values($a[0][9]));
        $b = Excel::toArray(
            new DetailsImport(2),
            $request->file('b'),
            'public'
        );
        $c = [];
        foreach ($a[0] as $row) {
            if (isset($row['wrc_pipe_code'])) {
                $this->singleRow($row['wrc_pipe_code']);
                $c = array_merge($c, $this->cloneRow($row['wrc_pipe_code'], $b[0]));
            }
        }

        return $c ? Excel::download(new ResultExport($c), 'result-' . now()->format('Y-m-d_H-i-s') . '.xlsx') : back();
    }

    private function singleRow($title): void
    {
        if (empty($title)) {
            return;
        }
        $this->cloneX($title);
    }

    private function cloneX($title): void
    {
        $subDirectories = [
            'Picture',
            'Report',
            'Video'
        ];
        foreach ($subDirectories as $directory) {
            $this->cloneDirectory($directory, $title);
        }
    }

    private function cloneDirectory($dir, $title): void
    {
        $files = Storage::files("public/x/$dir");
        foreach ($files as $file) {
            Storage::copy($file, str_replace(['/x/', 'x_'], ["/result/$title/", $title . '_'], $file));
        }
    }

    private function cloneRow(string $title, array $rows): array
    {
        $result = [];
        foreach ($rows as $row) {
            $row['wc_pipe_code'] = $title;
            $result[] = $row;
        }
        return $result;
    }
}
