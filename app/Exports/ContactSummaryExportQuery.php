<?php

namespace App\Exports;

use App\Models\Contact\Contact;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactSummaryExport implements FromCollection, FromQuery
// , WithMapping, WithHeadings, 
{
    use Exportable;
    // protected $contacts;

    // public function __construct($contacts)
    // {
    //     $this->contact = $contacts;
    // }

    public function query()
    {
        $contacts = Contact::where('id', 1);

        foreach($contacts as $contact){
            $todo = $contact->todo();
        }
    
        return $todo;

    }

    public function collection()
    {
        // return Contact::query()->whereKey($this->contact->exportContact())
        // return Contact::query()
        // ->whereKey($this->contact)
        // ;

        // return Contact::with([
        //     'todo.action' => function ($q) {
        //         $q->select('id', 'name');
        //     }, 
        //     'todo'=> function ($q) {
        //         $q->select('id', 'action_id', 'todo_date', 'contact_id');
        //     },
        // ])
        //     ->select('id', 'name',)
        //     ->where('id', '=', 1)
        //     ->get();

        // return Contact::with('todo')->get();
    }

    // public function map($contacts): array
    // {
    //     return [
    //         $contacts->id,
    //         $contacts->name,
    //         // $contacts->todo->pluck('id')->implode(', '),           
    //         // $contacts->todo->todo_date
    //         // $contacts->remark,
    //         // $contacts->status->name,
    //         // $contacts->category->name,
    //         // $contacts->type->name,
    //         // $contacts->user->name,
    //         // $contacts->summary,
    //     ];
    // }

    // public function headings(): array
    // {
    //     return [
    //         'ID',
    //         'Company Name',
    //         // 'Address',
    //         // 'Remark',
    //         // 'Status',
    //         // 'Category',
    //         // 'Type',
    //         // 'User',
    //         // 'Summary'
    //     ];
    // }
}
