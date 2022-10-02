<?php

namespace App\Exports;

use App\Models\Contact\Contact;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContactSummaryExport implements FromQuery, WithHeadings, WithMapping
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
            $contacts->name,
            $contacts->address,
            $contacts->remark,
            $contacts->status->name,
            $contacts->category->name,
            $contacts->type->name,
            $contacts->user->name,
            $contacts->summary,
        ];
    }

    public function headings(): array
    {
        return [
            'Company Name',
            'Address',
            'Remark',
            'Status',
            'Category',
            'Type',
            'User'
        ];
    }
}
