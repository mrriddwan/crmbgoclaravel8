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
// , WithHeadingRow
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

        // $row['user_id'] = User::where("name", "like", "%" . $row['designation'] . "%");
        // $row['industry_id'] = ContactIndustry::where("first_name", "like", "%" . $row['line_manager'] . "%");
        // $row['status_id']   = ContactStatus::where("name", "like", "%" . $row['job_title'] . "%");

        $row[0] = User::where("id", "=", $row[0])->pluck('id');
        $row[3] = ContactIndustry::where("id", "=", $row[3])->pluck('id');
        $row[4] = ContactStatus::where("id", "=", $row[4])->pluck('id');
        $row[5] = ContactType::where("id", "=", $row[5])->pluck('id');
        $row[6] = ContactCategory::where("id", "=", $row[6])->pluck('id');

        return new Contact([
            'user_id' => $row[0],
            'name' => $row[1],
            'address'  => $row[2],
            'industry_id'  => $row[3],
            'status_id'  => $row[4],
            'type_id'  => $row[5],
            'category_id'  => $row[6],
            'remark'  => $row[7],
        ]);
    }

    // public function rules(): array
    // {
    //     return [
    //         // 'name' => '',

    //     ];
    // }


}
