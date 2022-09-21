<?php

namespace App\Models\Project;

use App\Models\Contact\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_startdate',
        'project_enddate',
        'project_name',
        'project_remark',
        'contact_id',
        'user_id',
    ];

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function contact(){
        return $this -> belongsTo(Contact::class);
    }

    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('projects.project_startdate', 'like', $term)
                ->orWhere('projects.project_enddate', 'like', $term)
                ->orWhere('projects.project_name', 'like', $term)
                ->orWhere('projects.project_remark', 'like', $term)
                ->orWhereHas('contact', function ($query) use ($term) {
                    $query->where('contacts.name', 'like', $term);
                }); 
        });
    }
}
