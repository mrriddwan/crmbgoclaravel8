<?php

namespace App\Models\FollowUp;

use App\Models\Contact\Contact;
use App\Models\Contact\ContactStatus;
use App\Models\Contact\ContactType;
use App\Models\ToDo\Priority;
use App\Models\ToDo\Task;
use App\Models\ToDo\ToDo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'followup_date',
        'followup_deadline',
        'followup_time',
        'todo_id',
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
            $query->where('followup_date', 'like', $term)
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
                });

        });
    }
}
