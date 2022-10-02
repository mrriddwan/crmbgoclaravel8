<?php

namespace App\Exports;

use App\Models\Todo\Todo;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TodoExport implements FromQuery, WithMapping, WithHeadings
{

    use Exportable;
    protected $todos;

    public function __construct($todos)
    {
        $this->todos = $todos;
    }

    public function query()
    {
        // return Contact::query()->whereKey($this->contact->exportContact())
        return Todo::query()
        ->whereKey($this->todos)
        ->orderBy('todo_date', 'desc')
        ;
    }

    public function map($todos): array
    {
        return [
            $todos->source->name,
            $todos->todo_date,
            $todos->todo_deadline ===  "2000-01-01" ? "No deadline set" : $todos->todo_deadline ,
            $todos->status->name,
            $todos->type->name,
            $todos->contact->name,
            $todos->user->name,
            $todos->task->name,
            $todos->todo_remark,
            $todos->action->name ?? 'No action yet',
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
            'Action'
        ];
    }
}
