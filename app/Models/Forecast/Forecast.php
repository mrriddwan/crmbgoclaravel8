<?php

namespace App\Models\Forecast;

use App\Models\ContactType;
use App\Models\Forecast\ForecastProduct;
use App\Models\Forecast\ForecastResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'forecast_updatedate',
        'amount',
        'forecast_date',
        'forecast_result_id', 
        'user_id',
        'contact_id',
        'product_id',
        'type_id'
    ];

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function contact(){
        return $this -> belongsTo(Contact::class);
    }

    public function type(){
        return $this -> belongsTo(ContactType::class);
    }

    public function product(){
        return $this -> belongsTo(ForecastProduct::class);
    }

    public function result(){
        return $this -> belongsTo(ForecastResult::class);
    }

}
