<?php

namespace App\Exports;

use App\Models\Trainer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TrainersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection(): Collection
    {
        return Trainer::orderBy('id')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Apellido', 'Avatar (archivo)', 'Slug', 'Creado', 'Actualizado'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->apellido,
            $row->avatar ?? 'Sin avatar',
            $row->slug,
            optional($row->created_at)->format('d/m/Y H:i'),
            optional($row->updated_at)->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}