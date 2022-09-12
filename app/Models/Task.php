<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function contact(){
        return $this->belongsTo(Contact::class);
    }

    public function todo(){
        return $this->belongsTo(ToDo::class);
    }
}
