<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'followup_created',
        'followup_deadline',
        'contact_id',
        'user_id',
        'task_id',
        'status_id',
        'type_id',
        'priority_id',
        'followup_remark',
        'action_id',
        'source_id',
    ];

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function contact(){
        return $this -> belongsTo(Contact::class);
    }

    public function task(){
        return $this -> belongsTo(Task::class);
    }

    public function type(){
        return $this -> belongsTo(ContactType::class);
    }

    public function status(){
        return $this -> belongsTo(ContactStatus::class);
    }

    public function priority(){
        return $this -> belongsTo(Priority::class);
    }

    public function todo(){
        return $this -> belongsTo(ToDo::class);
    }

    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('followup_created', 'like', $term)
                ->orWhere('followup_time', 'like', $term)
                ->orWhere('follow_ups.followup_remark', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('name', 'like', $term);
                })
                ->orWhereHas('contact', function ($query) use ($term) {
                    $query->where('contacts.name', 'like', $term);
                })
                ->orWhereHas('task', function ($query) use ($term) {
                    $query->where('tasks.name', 'like', $term);
                })
                ->orWhereHas('type', function ($query) use ($term) {
                    $query->where('contact_types.name', 'like', $term);
                })
                ->orWhereHas('status', function ($query) use ($term) {
                    $query->where('contact_statuses.name', 'like', $term);
                })
                ->orWhereHas('priority', function ($query) use ($term) {
                    $query->where('priorities.name', 'like', $term);
                });
        });
    }
}
