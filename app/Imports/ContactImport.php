<?php

namespace App\Imports;

use App\Models\Contact\Contact;
use App\Models\Contact\ContactCategory;
use App\Models\Contact\ContactIndustry;
use App\Models\Contact\ContactStatus;
use App\Models\Contact\ContactType;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContactImport implements ToModel
, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // return new Contact([
        //     'user_id' => $row['user_id'],
        //     'name' => $row['name'],
        //     'address'  => $row['address'],
        //     'industry_id'  => $row['industry_id'],
        //     'status_id'  => $row['status_id'], 
        //     'type_id'  => $row['type_id'],
        //     'category_id'  => $row['category_id'],
        //     'remark'  => $row['remark'],
        // ]);

        // $row['user_id'] = 1;
        // $row['industry_id'] = 5;
        // $row['status_id']   = 5;
        // $row['type_id']   = 2;
        // $row['category_id']   = 10;

        // $row['name'] = 'New Company Ltd';
        // $row['address'] = 'Klang';
        // $row['remark'] = 'Please work for the company';


        
        $row['industry_id'] = ContactIndustry::whereIn("id", "=", $row['industry'])->pluck('id')->get();
        $row['status_id'] = ContactStatus::whereIn("id", "=", $row['status'])->pluck('id')->get();
        $row['type_id'] = ContactType::whereIn("id", "=", $row['type'])->pluck('id')->get();
        $row['category_id']  = ContactCategory::whereIn("id", "=", $row['category'])->pluck('id')->get();
        $row['user_id'] = User::whereIn("id", "=", $row['user'])->pluck('id')->get();

        return new Contact([
            'user_id' => intval($row['user_id']),
            'name' => $row['name'],
            'address'  => $row['address'],
            'industry_id'  => intval($row['industry_id']),
            'status_id'  => intval($row['status_id']),
            'type_id'  => intval($row['type_id']),
            'category_id'  => intval($row['category_id']),
            'remark'  => intval($row['remark']),
        ]);
    }

    // public function rules(): array
    // {
    //     return [
    //         // 'name' => '',

    //     ];
    // }


}
