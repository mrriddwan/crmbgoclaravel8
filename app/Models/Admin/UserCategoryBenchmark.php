<?php

namespace App\Models\Admin;

use App\Models\ToDo\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCategoryBenchmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_cat_id',
        'task_id',
        'task_target'
    ];

    public function user_category(){
        return $this->belongsTo(UserCategory::class, 'user_cat_id');
    }

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }
}
