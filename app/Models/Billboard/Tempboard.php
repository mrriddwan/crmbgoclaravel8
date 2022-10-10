<?php

namespace App\Models\Billboard;

use App\Models\Contact\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'tpboard_entrydate',
        'contact_id',
        'user_id',
        'tpboard_startdate',
        'tpboard_enddate',
        'tpboard_size',
        'tpboard_location',
        'tpboard_unit',
        'tpboard_collection',
        'tpboard_material',
        'tpboard_printing',
        'tpboard_installation',
        'tpboard_remark',
    ];

    public function user()
    {
        return $this -> belongsTo(User::class)->select('id', 'name');
    }

    public function contact(){
        return $this->belongsTo(Contact::class)->select('id', 'name');
    }

    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('tempboards.tpboard_entrydate', 'like', $term)
                ->orWhere('tempboards.tpboard_startdate', 'like', $term)
                ->orWhere('tempboards.tpboard_enddate', 'like', $term)
                ->orWhere('tempboards.tpboard_size', 'like', $term)
                ->orWhere('tempboards.tpboard_location', 'like', $term)
                ->orWhere('tempboards.tpboard_collection', 'like', $term)
                ->orWhere('tempboards.tpboard_material', 'like', $term)
                ->orWhere('tempboards.tpboard_printing', 'like', $term)
                ->orWhere('tempboards.tpboard_installation', 'like', $term)
                ->orWhere('tempboards.tpboard_remark', 'like', $term)      
                ->orWhereHas('contacts', function ($query) use ($term) {
                    $query->where('contacts.name', 'like', $term);
                })
                ->orWhereHas('users', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ;
        });
    }
}
