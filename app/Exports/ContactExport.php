<?php

namespace App\Exports;

use App\Models\Contact\Contact;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactExport implements FromQuery, WithHeadings, WithMapping

{
    use Exportable;
    protected $contacts;

    public function __construct($contacts)
    {
        $this->contact = $contacts;
    }

    public function query()
    {
        // return Contact::query()->whereKey($this->contact->exportContact())
        return Contact::query()
        ->whereKey($this->contact)
        ;
    }

    public function map($contacts): array
    {
        return [
            // $contacts->created_at
            Carbon::createFromFormat('Y-m-d H:i:s', $contacts->created_at)->format('d-m-Y'),
            // Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
            // $contacts->$contacts,
            $contacts->user->name,
            $contacts->status->name,
            $contacts->type->name,
            $contacts->industry->name,
            $contacts->name,
            $contacts->category->name,
            // $contacts->incharge[0]->name,
            // $contacts->incharge[0]->mobile_no,
            // $contacts->incharge[0]->office_no,
            // $contacts->incharge[0]->email,

            $contacts->address,
            $contacts->remark,
        ];
    }

    public function headings(): array
    {
        return [
            'Date Created',
            'User',
            'Status',
            'Type',
            'Industry',
            'Company Name', 
            'Product',            
            // 'PIC Name',
            // 'PIC No. Mobile',
            // 'PIC No. Office',
            // 'PIC Email',
            'Address',
            'Remark',
            
            
        ];
    }
}
