<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForecastProduct extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name'
    ];

    public function forecast(){
        return $this->belongsTo(Forecast::class);
    }
}
