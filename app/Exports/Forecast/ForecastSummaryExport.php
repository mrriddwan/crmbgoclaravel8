<?php

namespace App\Exports\Forecast;

use App\Models\Contact\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;

class ForecastSummaryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contact::all();
    }
}
