<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionHistoryExport implements FromCollection, WithHeadings, WithMapping
{
    protected $year;
    protected $month;

    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        $query = Appointment::where('status', 'Completed');

        if (!empty($this->year)) {
            $query->whereYear('date', $this->year);
        }

        if (!empty($this->month)) {
            $query->whereMonth('date', $this->month);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Gender',
            'Appointment Date',
            'Services',
            'Therapist',
            'Total Amount',
        ];
    }

    public function map($appointment): array
    {
        return [
            $appointment->id,
            $appointment->name,
            $appointment->gender ?? 'N/A',
            \Carbon\Carbon::parse($appointment->date)->format('F d, Y'),
            is_array(json_decode($appointment->services, true)) 
                ? implode(', ', json_decode($appointment->services, true)) 
                : $appointment->services,
            $appointment->therapist ?? 'N/A',
            '₱' . number_format($appointment->amount, 2),
        ];
    }
}

