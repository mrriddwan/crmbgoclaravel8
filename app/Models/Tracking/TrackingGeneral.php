<?php

namespace App\Models\Tracking;

use App\Models\Contact\Contact;
use App\Models\Contact\ContactCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
        'progress',
        'general_startdate',
        'general_enddate',
        'user_id',
        'company_id',
        'contact_category_id',
        'category_description',
        'art_frequency',
        'general_type',
        'general_reach',
        'general_tenure',
        'general_amount',
        'art_format',
        'general_remark',
    ];


    public function wip()
    {
        return $this->hasMany(WipGeneral::class, 'tracking_general_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Contact::class, 'company_id');
    }

    public function category()
    {
        return $this->belongsTo(ContactCategory::class, 'contact_category_id');
    }

    public function division()
    {
        return $this->belongsTo(BluedaleDivision::class, 'division_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('tracking_generals.created_at', 'like', $term)
                ->orWhere('tracking_generals.general_startdate', 'like', $term)
                ->orWhere('tracking_generals.general_enddate', 'like', $term)
                ->orWhere('tracking_generals.category_description', 'like', $term)
                ->orWhere('tracking_generals.art_frequency', 'like', $term)
                ->orWhere('tracking_generals.general_type', 'like', $term)
                ->orWhere('tracking_generals.general_reach', 'like', $term)
                ->orWhere('tracking_generals.general_tenure', 'like', $term)
                ->orWhere('tracking_generals.art_format', 'like', $term)
                ->orWhere('tracking_generals.general_remark', 'like', $term)
                ->orWhere('tracking_generals.progress', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('company', function ($query) use ($term) {
                    $query->where('contacts.name', 'like', $term);
                })
                ->orWhereHas('category', function ($query) use ($term) {
                    $query->where('contact_categories.name', 'like', $term);
                })
                ->orWhereHas('division', function ($query) use ($term) {
                    $query->where('bluedale_divisions.name', 'like', $term);
                })
                // ->orWhereHas('wip', function ($query) use ($term) {
                //     $query->where('contact_types.name', 'like', $term);
                // })
                ;
        });
    }
}


