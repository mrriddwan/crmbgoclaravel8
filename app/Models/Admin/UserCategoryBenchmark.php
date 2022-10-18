<?php

namespace App\Models\Admin;

use App\Models\FollowUp\Action;
use App\Models\ToDo\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategoryBenchmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_cat_id',
        'action_id',
        'action_target'
    ];

    public function user_category(){
        return $this->belongsTo(UserCategory::class, 'user_cat_id');
    }

    public function action(){
        return $this->belongsTo(Action::class, 'action_id');
    }
}
