<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SvSbPivot extends Model
{
    use HasFactory;

    protected $fillable = [
        'supervisor_id',
        'subordinate_id',
    ];

    public function supervisor(){
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function subordinate(){
        return $this->belongsTo(User::class, 'subordinate_id');
    }
}
