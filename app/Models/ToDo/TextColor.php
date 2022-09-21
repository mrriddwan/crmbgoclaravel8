<?php

namespace App\Models\ToDo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextColor extends Model
{
    use HasFactory;

    public function todo(){
        return $this->belongsTo(ToDo::class);
    }
}
