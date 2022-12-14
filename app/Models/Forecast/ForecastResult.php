<?php

namespace App\Models\Forecast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function forecast(){
        return $this->belongsTo(Forecast::class);
    }
}
