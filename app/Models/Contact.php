<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'industry_id',
        'status_id',
        'type_id',
        'category_id',
        'remark',
        'user_id'
    ];

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function category(){
        return $this -> belongsTo(ContactCategory::class);
    }

    public function type(){
        return $this -> belongsTo(ContactType::class);
    }

    public function industry(){
        return $this -> belongsTo(ContactIndustry::class);
    }

    public function status(){
        return $this -> belongsTo(ContactStatus::class);
    }

    public function todo(){
        return $this -> hasMany(ToDo::class)->with('task', 'user');
    }

    public function incharge(){
        return $this -> hasMany(ContactIncharge::class);
    }
    
    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('contacts.created_at', 'like', $term)
                ->orWhere('contacts.name', 'like', $term)
                ->orWhere('contacts.address', 'like', $term)
                ->orWhere('contacts.remark', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('type', function ($query) use ($term) {
                    $query->where('contact_types.name', 'like', $term);
                })
                ->orWhereHas('status', function ($query) use ($term) {
                    $query->where('contact_statuses.name', 'like', $term);
                })
                ->orWhereHas('category', function ($query) use ($term) {
                    $query->where('contact_categories.name', 'like', $term);
                });
        });
    }
}
