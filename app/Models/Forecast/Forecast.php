<?php

namespace App\Models\Forecast;

use App\Models\Contact;
use App\Models\ContactType;
use App\Models\ForecastProduct;
use App\Models\Forecast\ForecastResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'forecast_updatedate',
        'amount',
        'forecast_date',
        'result_id', 
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

    public function scopeSearch($query, $term)
    {   
        $term = "%$term%";

        $query->where(function($query) use ($term){
            $query->where('forecasts.forecast_date', 'like', $term)
                ->orWhere('forecasts.forecast_updatedate', 'like', $term)
                ->orWhere('forecasts.amount', 'like', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->where('users.name', 'like', $term);
                })
                ->orWhereHas('type', function ($query) use ($term) {
                    $query->where('contact_types.name', 'like', $term);
                })
                ->orWhereHas('contact', function ($query) use ($term) {
                    $query->where('contacts.name', 'like', $term);
                })
                ->orWhereHas('product', function ($query) use ($term) {
                    $query->where('forecast_products.name', 'like', $term);
                })
                ->orWhereHas('result', function ($query) use ($term) {
                    $query->where('forecast_results.name', 'like', $term);
                });
        });
    }
}
