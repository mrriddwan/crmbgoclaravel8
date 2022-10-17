<?php

namespace App\Exports;

use App\Models\Forecast\Forecast;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ForecastExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;
    protected $forecasts;

    public function __construct($forecasts)
    {
        $this->forecast = $forecasts;
    }

    public function query()
    {
        // return Contact::query()->whereKey($this->contact->exportContact())
        return Forecast::query()
        ->whereKey($this->forecast)
        ;
    }

    public function map($forecasts): array
    {
        return [
            $forecasts->forecast_updatedate,
            $forecasts->contact->name,
            $forecasts->user->name,
            $forecasts->product->name,
            $forecasts->amount,
            $forecasts->forecast_date,
            $forecasts->forecast_type->name,
            $forecasts->result->name ?? "No result",
        ];
    }

    public function headings(): array
    {
        return [
            'Last Updated',
            'Company',
            'User',
            'Product',
            'Amount (RM)',
            'Expected Forecast',
            'Forecast Type',
            'Result'
        ];
    }
}
