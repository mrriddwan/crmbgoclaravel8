<?php

namespace App\Models\Contact;

use App\Models\Forecast\Forecast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function contact(){
        return $this->belongsTo(Contact::class);
    }

    public function forecast(){
        return $this->belongsTo(Forecast::class);
    }
}
