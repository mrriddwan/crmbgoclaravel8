<?php

namespace App\Models\Billboard;

use App\Models\Contact\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillboardTenure extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'user_id',
        'tenure_startdate',
        'tenure_enddate',
    ];

    public function billboard()
    {
        return $this->belongsTo(Billboard::class, 'bboard_id');
    }

    public function contact(){
        return $this->belongsTo(Contact::class)->select('id', 'name');
    }
}
