<?php

namespace App\Exports;

use App\Models\ToDo\ToDo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TodoExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $todos;

    public function __construct($todos)
    {
        $this->todo = $todos;
    }

    public function query()
    {
        return ToDo::query()
        ->whereKey($this->todo)
        ;
    }

    public function map($todos): array
    {
        return [
            $todos->source->name,
            $todos->todo_date,
            $todos->todo_deadline,
            $todos->status->name,
            $todos->type->name,
            $todos->contact->name,
            $todos->user->name,
            $todos->task->name,
            $todos->todo_remark,
            $todos->action->name ?? 'No action',
        ];
    }

    public function headings(): array
    {
        return [
            'Source',
            'Date of Todo',
            'Date of Deadline',
            'Status',
            'Type',
            'Company',
            'User',
            'Task',
            'Remark',
            'Action',
        ];
    }
}
