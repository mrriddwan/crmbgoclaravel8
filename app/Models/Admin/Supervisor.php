<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sv_name',
    ];

    public function users(){
        return $this->hasMany(SvSbPivot::class, 'supervisor_id')->with('subordinate');
    }

}