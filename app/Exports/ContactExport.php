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
        return Contact::query()
        ->whereKey($this->contact)
        ;
    }

    public function map($contacts): array
    {
        return [
            $contacts->created_at->format('d-m-Y'),
            $contacts->user->name,
            $contacts->status->name,
            $contacts->type->name,
            $contacts->industry->name,
            $contacts->name,
            $contacts->category->name,
            $contacts->incharge->pluck('name')->implode(', '),
            $contacts->incharge->pluck('phone_mobile')->implode(', '),
            $contacts->incharge->pluck('phone_office')->implode(', '),
            $contacts->incharge->pluck('email')->implode(', '),
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
            'PIC Name',
            'PIC Phone No. 1',
            'PIC Phone No. 2',
            'PIC Email',
            'Address',
            'Remark',
        ];
    }
}
