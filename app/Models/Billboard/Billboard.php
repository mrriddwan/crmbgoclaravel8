<?php

namespace App\Models\Billboard;

use App\Models\Contact\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'bboard_location',
        'bboard_size',
    ];

    public function tenure()
    {
        return $this -> hasMany(BillboardTenure::class, 'bboard_id')->select('id', 'tenure_startdate', 'contact_id')->with('contact');
    }

    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('billboards.site_id', 'like', $term)
                ->orWhere('billboards.bboard_location', 'like', $term)
                ->orWhere('billboards.bboard_size', 'like', $term)
                // ->orWhereHas('tenure', function ($query) use ($term) {
                //     $query->where('billboard_tenures.name', 'like', $term);
                // })
                ;

        });
    }
}
