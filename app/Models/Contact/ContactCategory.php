<?php

namespace App\Models\Contact;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function contact(){
        return $this->belongsTo(Contact::class);
    }
}
