<?php

namespace App\Exports;

use App\Models\Contact\ContactStatus;
use App\Models\Contact\ContactType;
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
        $status_id = ContactStatus::where('id', '=', $todos->contact->status_id)->value('name');
        $type_id = ContactType::where('id', '=', $todos->contact->type_id)->value('name') ;

        return [
            $todos->source->name,
            $todos->todo_date,
            $todos->todo_deadline,
            $status_id,
            $type_id,
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
