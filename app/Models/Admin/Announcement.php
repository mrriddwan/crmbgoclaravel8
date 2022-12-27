<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'from_user_id',
        'to_user_id',
        'message_type_id'
    ];

    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_user_id')->select('id', 'name',);
    }

    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_id')->select('id', 'name',);
    }
}
