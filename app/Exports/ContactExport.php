<?php

namespace App\Exports;

use App\Models\Contact\Contact;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactExport implements FromQuery
// , WithHeadings
{
    use Exportable;
    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function query()
    {
        // return Contact::query()->whereKey($this->contact->exportContact())
        return Contact::query()->whereKey($this->contact)
        ->select('name', 'address', 'remark',
         'category_id', 'status_id', 'type_id', 'user_id',  
        //  'status', 'category', 'type', 'user'
        )
        ;
    }

    // public function map($contact): array
    // {
    //     return [
    //         $contact->name,
    //         $contact->address,
    //         $contact->remark,
    //     ];
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Name',
    //         'Address',
    //         'Remark',
    //         // 'Category',
    //         // 'Status',
    //         // 'Type',
    //         // 'User'
    //     ];
    // }
}
