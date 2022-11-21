<?php

namespace App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WipGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'art_format',
        'c&s_sent_date',
        'c&s_sent_remark',
        'c&s_sent_user_id',
        'c&s_record_date',
        'c&s_record_remark',
        'c&s_record_user_id',
        'schedule_date',
        'schedule_remark',
        'schedule_user_id',
        'live_date',
        'live_remark',
        'live_user_id',
        'client_posting_date',
        'client_posting_user_id',
        'client_posting_remark',
        'report_date',
        'report_remark',
        'report_user_id',
    ];
}