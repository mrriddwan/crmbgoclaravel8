<?php

namespace App\Models\ToDo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoSource extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name'
    // ];

    public function todo(){
        return $this->belongsTo(ToDo::class);
    }
}
