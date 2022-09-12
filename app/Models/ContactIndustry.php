<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactIndustry extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name'
    ];

    public function contact(){
        return $this->belongsTo(Contact::class);
    }
}
