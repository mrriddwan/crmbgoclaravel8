<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function user(){
        return $this->hasMany(User::class, 'user_cat_id');
    }

    public function benchmark(){
        return $this->hasMany(UserCategoryBenchmark::class, 'user_cat_id')->with('action');
    }
}
