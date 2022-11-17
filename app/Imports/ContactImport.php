<?php

namespace App\Imports;

use App\Models\Contact\Contact;
use App\Models\Contact\ContactCategory;
use App\Models\Contact\ContactIndustry;
use App\Models\Contact\ContactStatus;
use App\Models\Contact\ContactType;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContactImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{

    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        //using heading row with string

        $industry_id = ContactIndustry::where("name", "like", "%" . $row['industry'] . "%")->first();
        $status_id = ContactStatus::where("name", "like", "%" . $row['status'] . "%")->first();
        $type_id = ContactType::where("name", "like", "%" . $row['type'] . "%")->first();
        $category_id  = ContactCategory::where("name", "like", "%" . $row['category'] . "%")->first();
        $user_id = User::where("name", "like", "%" . $row['user'] . "%")->first();

        $row['industry_id'] = $industry_id->id;
        $row['status_id'] = $status_id->id;
        $row['type_id'] = $type_id->id;
        $row['category_id']  = $category_id->id;
        $row['user_id'] = $user_id->id;


        return new Contact([
            'user_id' => $row['user_id'],
            'name' => $row['name'],
            'address'  => $row['address'],
            'industry_id'  => $row['industry_id'],
            'status_id'  => $row['status_id'],
            'type_id'  => $row['type_id'],
            'category_id'  => $row['category_id'],
            'remark'  => $row['remark'],
        ]);

        //using heading row && id

        // $industry_id = ContactIndustry::where("id", "=", $row['industry'])->first();
        // $status_id = ContactStatus::where("id", "=", $row['status'])->first();
        // $type_id = ContactType::where("id", "=", $row['type'])->first();
        // $category_id  = ContactCategory::where("id", "=", $row['category'])->first();
        // $user_id = User::where("id", "=", $row['user'])->first();

        // // $industry_id->id;
        // // $industry = $industry_id->id;
        // // $status = $status_id->id;
        // // $type = $type_id->id;
        // // $category  = $category_id->id;
        // // $user = $user_id->id;

        // // dd($industry_id->id);
        // // dd($row['status_id']);
        // // dd($row['type_id']);
        // // dd($row['category_id']);
        // // dd($row['user_id']);

        // return new Contact([
        //     'name' => $row['name'],
        //     'address'  => $row['address'],
        //     'industry_id'  => $industry_id->id,
        //     'status_id'  => $status_id->id,
        //     'type_id'  => $type_id->id,
        //     'category_id'  => $category_id->id,
        //     'remark'  => $row['remark'],
        //     'user_id' => $user_id->id,
        // ]);
      
    }

    // public function rules(): array
    // {
    //     return [
    //         // 'name' => '',

    //     ];
    // }


}
