<?php

namespace App\Models\Billboard;

use App\Models\Contact\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'bboard_location',
        'bboard_size',
    ];

    public function tenure()
    {
        return $this->hasMany(BillboardTenure::class, 'bboard_id')->select(
            "id",
            "tenure_startdate",
            "tenure_enddate",
            "bboard_id",
            "contact_id",
            "user_id"
        )->with('contact', 'user');
    }

    public function tenure2()
    {
        return $this->hasMany(BillboardTenure::class, 'bboard_id')->select('id', 'tenure_startdate', 'contact_id', 'bboard_id')->with('contact');
    }

    public function summary()
    {
        return $this->hasMany(BillboardTenure::class, 'bboard_id')->select(
            "billboard_tenures.id",
            "tenure_startdate",
            "tenure_enddate",
            "bboard_id",
            "billboard_tenures.contact_id as company_id",
            "billboard_tenures.user_id as user_id",
            "contacts.name as company_name",
            "users.name as user_name",
            "users.id as user_id",
        )
        // ->with('contact', 'user')
        ->join('contacts', 'billboard_tenures.contact_id', '=', 'contacts.id')
        ->join('users', 'billboard_tenures.user_id', '=', 'users.id');
    }
}
