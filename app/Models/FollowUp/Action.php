<?php

namespace App\Models\FollowUp;

use App\Models\ToDo\ToDo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function todo(){
        return $this->belongsTo(ToDo::class);
    }
}
