<?php

namespace App\Models\Tracking;

use App\Models\Contact\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingTravelGuide extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'edition',
        'tguide_size',
        'tguide_remark',
        'art_reminder_date',
        'art_reminder_remark',
        'art_reminder_done',
        'art_reminder_user_id',
        'art_record_date',
        'art_record_remark',
        'art_record_done',
        'art_record_user_id',
    ];

    public function art_reminder_user()
    {
        return $this->belongsTo(User::class, 'art_reminder_user_id');
    }

    public function art_record_user()
    {
        return $this->belongsTo(User::class, 'art_record_user_id');
    }

    public function wip_travel_guide()
    {
        return $this->hasMany(WipTravelGuide::class, 'tracking_tguide_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Contact::class, 'company_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('tracking_travel_guides.created_at', 'like', $term)
                ->orWhere('tracking_travel_guides.edition', 'like', $term)
                ->orWhere('tracking_travel_guides.tguide_size', 'like', $term)
                ->orWhere('tracking_travel_guides.tguide_remark', 'like', $term)
                ->orWhere('tracking_travel_guides.art_reminder_date', 'like', $term)
                ->orWhere('tracking_travel_guides.art_reminder_remark', 'like', $term)
                ->orWhere('tracking_travel_guides.art_record_date', 'like', $term)
                ->orWhere('tracking_travel_guides.art_record_remark', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('company', function ($query) use ($term) {
                    $query->where('contacts.name', 'like', $term);
                })
                ->orWhereHas('wip_travel_guide', function ($query) use ($term) {
                    $query->where('wip_travel_guides.wip_package_date', 'like', $term)
                        ->orWhere('wip_travel_guides.wip_package_remark', 'like', $term);
                })
                // ->orWhereHas('wip', function ($query) use ($term) {
                //     $query->where('contact_types.name', 'like', $term);
                // })
            ;
        });
    }
}
