<?php

namespace App\Exports;

use App\Models\FollowUp\FollowUp;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FollowUpExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $followups;

    public function __construct($followups)
    {
        $this->followups = $followups;
    }

    public function query()
    {
        // return Contact::query()->whereKey($this->contact->exportContact())
        return FollowUp::query()
        ->whereKey($this->followups)
        ->orderBy('followup_date')
        ;
    }

    public function map($followups): array
    {
        return [
            $followups->followup_date,
            $followups->followup_time ?? "No time set",
            $followups->contact->name,
            $followups->user->name,
            $followups->task->name,
            $followups->followup_remark,
        ];
    }

    public function headings(): array
    {
        return [
            'Date of Follow Up',
            'Time of Follow Up',
            'Company',
            'User',
            'Task',
            'Remark',
        ];
    }
}
