<?php

namespace App\Models\Tracking;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
        'wip_remark',
        'wip_progress',
        'tracking_general_id',
        'frequency_no',
        'art_chase_date',
        'art_chase_remark',
        'art_chase_user_id',
        'art_received_date',
        'art_received_remark',
        'art_received_user_id',
        'art_todo_date',
        'art_todo_remark',
        'art_todo_user_id',
        'cns_sent_date',
        'cns_sent_remark',
        'cns_sent_user_id',
        'cns_record_date',
        'cns_record_remark',
        'cns_record_user_id',
        'schedule_date',
        'schedule_remark',
        'schedule_user_id',
        'actual_live_date',
        'actual_live_remark',
        'actual_live_user_id',
        'client_posting_date',
        'client_posting_user_id',
        'client_posting_remark',
        'report_date',
        'report_remark',
        'report_user_id',
    ];

    public function tracking_general()
    {
        return $this->belongsTo(TrackingGeneral::class, 'tracking_general_id')
        ;
    }

    public function art_chase_user()
    {
        return $this->belongsTo(User::class, 'art_chase_user_id')
            // ->join('users', 'wip_generals.art_chase_user_id', '=', 'users.id')
            // ->select('tracking_generals.id', 'users.name as art_chase_username', 'users.id as art_chase_user_id')
        ;
    }

    public function art_received_user()
    {
        return $this->belongsTo(User::class, 'art_received_user_id');
    }

    public function art_todo_user()
    {
        return $this->belongsTo(User::class, 'art_todo_user_id');
    }

    public function cns_sent_user()
    {
        return $this->belongsTo(User::class, 'cns_sent_user_id');
    }

    public function cns_record_user()
    {
        return $this->belongsTo(User::class, 'cns_record_user_id');
    }

    public function schedule_user()
    {
        return $this->belongsTo(User::class, 'schedule_user_id');
    }

    public function actual_live_user()
    {
        return $this->belongsTo(User::class, 'actual_live_user_id');
    }

    public function client_posting_user()
    {
        return $this->belongsTo(User::class, 'client_posting_user_id');
    }

    public function report_user()
    {
        return $this->belongsTo(User::class, 'report_user_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('wip_generals.created_at', 'like', $term)
                ->orWhere('wip_generals.frequency_no', 'like', $term)
                ->orWhere('wip_generals.art_chase_date', 'like', $term)
                ->orWhere('wip_generals.art_chase_remark', 'like', $term)
                ->orWhere('wip_generals.art_todo_date', 'like', $term)
                ->orWhere('wip_generals.art_todo_remark', 'like', $term)
                ->orWhere('wip_generals.cns_sent_date', 'like', $term)
                ->orWhere('wip_generals.cns_sent_remark', 'like', $term)
                ->orWhere('wip_generals.cns_record_date', 'like', $term)
                ->orWhere('wip_generals.cns_record_remark', 'like', $term)
                ->orWhere('wip_generals.cns_record_user_id', 'like', $term)
                ->orWhere('wip_generals.schedule_date', 'like', $term)
                ->orWhere('wip_generals.schedule_remark', 'like', $term)
                ->orWhere('wip_generals.schedule_user_id', 'like', $term)
                ->orWhere('wip_generals.actual_live_date', 'like', $term)
                ->orWhere('wip_generals.actual_live_remark', 'like', $term)
                ->orWhere('wip_generals.actual_live_user_id', 'like', $term)
                ->orWhere('wip_generals.client_posting_date', 'like', $term)
                ->orWhere('wip_generals.client_posting_user_id', 'like', $term)
                ->orWhere('wip_generals.client_posting_remark', 'like', $term)
                ->orWhere('wip_generals.report_date', 'like', $term)
                ->orWhere('wip_generals.report_remark', 'like', $term)
                ->orWhere('wip_generals.report_user_id', 'like', $term)
                ->orWhereHas('art_chase_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('art_received_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('art_todo_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('cns_sent_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('cns_record_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('schedule_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('actual_live_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('client_posting_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('report_user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                // ->orWhereHas('tracking_general', function ($query) use ($term) {
                //     $query->where('contacts.name', 'like', $term)
                //     ->orWhere('contact_categories.name', 'like', $term)
                //     ->orWhere('users.name', 'like', $term)
                //     ;
                // })
            ;
        });
    }
}
