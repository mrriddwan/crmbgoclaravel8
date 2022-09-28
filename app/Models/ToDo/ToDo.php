<?php

namespace App\Models\ToDo;

use App\Models\Contact\Contact;
use App\Models\Contact\ContactStatus;
use App\Models\Contact\ContactType;
use App\Models\FollowUp\Action;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;

    protected $fillable = [
        'todo_date',
        'todo_deadline',
        'contact_id',
        'user_id',
        'task_id',
        'status_id',
        'type_id',
        'priority_id',
        'todo_remark',
        'color_id',
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

    public function color(){
        return $this -> belongsTo(TextColor::class);
    }

    public function action(){
        return $this -> belongsTo(Action::class);
    }

    public function source(){
        return $this -> belongsTo(ToDoSource::class);
    }

    public function summaryContact(){
        return $this -> belongsTo(Contact::class);
    }

    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('todo_date', 'like', $term)
                ->orWhere('todo_deadline', 'like', $term)
                ->orWhere('to_dos.todo_remark', 'like', $term)
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
                })
                ->orWhereHas('color', function ($query) use ($term) {
                    $query->where('text_colors.color_code', 'like', $term);
                });
        });
    }

    // public function scopeStatusSearch($query){
    //     $search_term = request('q','');


                    
    // }

}
