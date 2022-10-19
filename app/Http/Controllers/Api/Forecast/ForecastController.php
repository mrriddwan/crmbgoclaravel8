<?php

namespace App\Http\Controllers\Api\Forecast;

use App\Exports\Forecast\ForecastSummaryExport;
use App\Exports\ForecastExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forecast\ForecastRequest;
use App\Http\Resources\Forecast\ForecastResource;
use App\Models\Contact\Contact;
use App\Models\Forecast\Forecast;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ForecastController extends Controller
{
    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedProduct = request('selectedProduct');
        $selectedForecastType = request('selectedForecastType');
        $selectedUser = request('selectedUser');
        $filterResult = request('filterResult');

        $forecast = Forecast::select([
            'forecasts.*',
            'forecast_products.name as product_name',
            'users.name as user_name',
            'contacts.name as contact_name',
            'forecast_results.name as result_name',
            'forecast_types.name as forecast_type_name',
        ])
            ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
            ->join('contacts', 'forecasts.contact_id', '=', 'contacts.id')
            ->join('users', 'forecasts.user_id', '=', 'users.id')
            ->join('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
            ->leftJoin('forecast_results', 'forecasts.result_id', '=', 'forecast_results.id')
            ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
                $query->where('forecasts.forecast_type_id', $selectedForecastType);
            })
            ->when($selectedProduct, function ($query) use ($selectedProduct) {
                $query->where('forecasts.product_id', $selectedProduct);
            })
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('forecasts.user_id', $selectedUser);
            })
            ->when($filterResult, function ($query) use ($filterResult) {
                if ($filterResult === "null") {
                    $query->whereNull('forecasts.result_id');
                } else {
                    $query->where('forecasts.result_id', $filterResult);
                }
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->distinct()
            ->paginate($paginate);

        return ForecastResource::collection($forecast);
        // return ForecastResource::collection(Forecast::all());
    }

    public function store(ForecastRequest $request)
    {

        $forecast = Forecast::create([
            'forecast_date' => $request->forecast_date,
            'forecast_updatedate' => now(),
            'amount' => $request->amount,
            // 'user_id' => $request->user_id ?? 2, //change to current user later
            'user_id' => Auth::id(),
            'forecast_type_id' => $request->forecast_type_id,
            'contact_id' => $request->contact_id,
            'product_id' => $request->product_id,
            'contact_type_id' => $request->contact_type_id,
            'contact_status_id' => $request->contact_status_id,
        ]);

        return response()->json([
            'data' => $forecast,
            'status' => true,
            'message' => 'Successfully store forecast',
        ]);
    }
    public function show($id)
    {
        $forecast = Forecast::find($id);
        return response()->json(["data" => $forecast]);
    }

    public function update(ForecastRequest $request, Forecast $forecast)
    {
        $forecast->update([

            'forecast_date' => $request->forecast_date,
            'forecast_updatedate' => now(),
            'amount' => $request->amount,
            'user_id' => Auth::id(),
            'forecast_type_id' => $request->forecast_type_id,
            'contact_id' => $request->contact_id,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data forecast ' . $forecast->name,
            'data' => $forecast,
        ]);
    }

    public function delete(Forecast $forecast)
    {
        $forecast->delete();
        return response()->json('forecast deleted.');
    }

    public function resultSelected(Request $request, Forecast $forecast)
    {
        $forecast->update([
            'result_id' => $request->result_id,
            'forecast_updatedate' => $request->forecast_updatedate,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Successfully update data To Do ' . $forecast->id,
            'data' => $forecast,
        ]);
    }

    public function info(Forecast $forecast)
    {
        $forecast = Forecast::with('forecast_type', 'product', 'contact', 'user', 'result', 'contact_type',)
            ->where('id', $forecast->id)
            ->get();

        $data = $forecast->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data forecast ',
            'data' => $data,
        ]);
    }

    public function export($forecast)
    {
        $date = Carbon::now()->format('Ymd');

        $forecastsArray = explode(',', $forecast);

        return Excel::download(new ForecastExport($forecastsArray), ('Forecasts - ' . $date . '.xlsx'));
    }

    public function exportSummary()
    {
        $date = Carbon::now()->format('Ymd');

        // $forecastsArray = explode(',', $forecast);

        return Excel::download(new ForecastSummaryExport, ('ForecastSummary - ' . $date . '.xlsx'));
    }

    public function selectAll()
    {
        return Forecast::pluck('id');
    }

    // public function summary2()
    // {
    //     $paginate = request('paginate');
    //     $search_term = request('q', '');

    //     $sort_direction = request('sort_direction');
    //     $sort_field = request('sort_field');

    //     $selectedStatus = request('selectedStatus');
    //     $selectedForecastType = request('selectedForecastType');
    //     $selectedContactType = request('selectedContactType');
    //     $selectedUser = request('selectedUser');
    //     $selectedYear = request('selectedYear');


    //     $contact = Contact::with(
    //         [
    //             'forecast_summary' => function ($q) {
    //                 $q->select(['id', 'forecast_type_id', 'product_id', 'contact_id', 'forecast_date', 'amount'])
    //                     ->orderBy('forecast_date', 'desc');
    //             },
    //             'forecast_summary.forecast_type' => function ($q) {
    //                 $q->select('id', 'name');
    //             },
    //             'forecast_summary.product' => function ($q) {
    //                 $q->select('id', 'name');
    //             },
    //         ],
    //         // 'forecast_summary'
    //     )
    //         // ->get();
    //         ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
    //         ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
    //         // // ->join('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
    //         // // ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
    //         ->join('users', 'contacts.user_id', '=', 'users.id')
    //         ->select([
    //             'contacts.id',
    //             'contacts.name',
    //             // 'contacts.created_at',
    //             'contact_statuses.name as status_name',
    //             'contact_types.name as type_name',
    //             'users.name as user_name',
    //             // 'forecast_types.name as forecast_type_name',
    //             // 'forecast_products.name as forecast_product_name',

    //         ])
    //         // ->get();
    //         ->when($selectedStatus, function ($query) use ($selectedStatus) {
    //             $query->where('contacts.status_id', $selectedStatus);
    //         })
    //         ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
    //             $query->where('contacts.type_id', $selectedForecastType);
    //         })
    //         ->when($selectedContactType, function ($query) use ($selectedContactType) {
    //             $query->where('contacts.type_id', $selectedContactType);
    //         })
    //         ->when($selectedUser, function ($query) use ($selectedUser) {
    //             $query->where('contacts.user_id', $selectedUser);
    //         })
    //         ->when($selectedYear, function ($query) use ($selectedYear) {
    //             $query->whereHas('forecast_summary', function ($q) use ($selectedYear) {
    //                 $q->whereYear('forecast_date', $selectedYear);
    //             });
    //         })
    //         ->orderBy($sort_field, $sort_direction)
    //         ->search(trim($search_term))

    //         ->paginate(5000);

    //     // group smua todo by month
    //     $contact
    //         ->transform(function ($company) {
    //             $company->setRelation(
    //                 'forecast_summary',
    //                 $company->forecast_summary->groupBy(
    //                     fn ($forecast_summary) => \Carbon\Carbon::create($forecast_summary->forecast_date)->format('M-Y')
    //                 ),
    //                 // 'forecast_todo',
    //                 // $company->summary
    //                 //     ->groupBy(
    //                 //         fn ($summary) => \Carbon\Carbon::create($summary->todo_date)->format('F-Y')
    //                 //     )

    //             );

    //             return $company;
    //         });

    //     // ->get();
    //     return $contact->toArray();
    // }

    public function summary()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedtContact = request('selectedtContact');
        $selectedContactStatus = request('selectedContactStatus');
        $selectedContactType = request('selectedContactType');
        $selectedForecastType = request('selectedForecastType');
        $selectedForecastProduct = request('selectedForecastProduct');
        $selectedUser = request('selectedUser');
        $selectedYear = request('selectedYear');


        $forecast = Forecast::select(
            'forecasts.id',
            'forecasts.contact_id',
            'forecasts.forecast_date',
            'forecasts.amount',
            'contacts.name as contact',
            'contact_statuses.name as contact_status',
            'contact_types.name as contact_type',
            'users.name as user_name',
            'forecast_types.name as forecast_type',
            'forecast_products.name as forecast_product',
            DB::raw("DATE_FORMAT(forecasts.forecast_date, '%M-%Y') as month"),
            // DB::raw("MAX(forecasts.forecast_date, '%M %Y') as last"),
        )
            ->join('contacts', 'forecasts.contact_id', '=', 'contacts.id')
            ->join('contact_statuses', 'forecasts.contact_status_id', '=', 'contact_statuses.id')
            ->join('contact_types', 'forecasts.contact_type_id', '=', 'contact_types.id')
            ->join('forecast_types', 'forecasts.forecast_type_id', '=', 'forecast_types.id')
            ->join('forecast_products', 'forecasts.product_id', '=', 'forecast_products.id')
            ->join('users', 'forecasts.user_id', '=', 'users.id')
            ->when($selectedContactStatus, function ($query) use ($selectedContactStatus) {
                $query->where('contact_status_id', $selectedContactStatus);
            })
            ->when($selectedForecastProduct, function ($query) use ($selectedForecastProduct) {
                $query->where('product_id', $selectedForecastProduct);
            })
            ->when($selectedForecastType, function ($query) use ($selectedForecastType) {
                $query->where('forecast_type_id', $selectedForecastType);
            })
            ->when($selectedContactType, function ($query) use ($selectedContactType) {
                $query->where('contact_type_id', $selectedContactType);
            })
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('forecasts.user_id', $selectedUser);
            })
            ->when($selectedtContact, function ($query) use ($selectedtContact) {
                $query->where('contact_id', $selectedtContact);
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereHas('forecast_summary', function ($q) use ($selectedYear) {
                    $q->whereYear('forecast_date', $selectedYear);
                });
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->paginate(5000)
            // ->groupBy('contact_name')
            // ->groupBy('month')
            // ->toArray()
            ;

        // $data = Tutorial::where('completed', 0)->get();
        // $groups = $data->groupBy('subj_id');

        // $results = [];
        // foreach ($forecast as $group) {
        //     $forecast['month'] = head($group);
        // }
        // return $results;

        // return head($forecast);

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Successfully fetch data forecast ',
        //     'data' => $forecast,
        // ]);

        return $forecast->toArray();
    }


    // public function test()
    // {

    //     ### DB Raw method from discord ###

    //     ##trial 1

    //     // $contact = Contact::select(
    //     //     'name',
    //     //     DB::raw("DATE_FORMAT(created_at, '%M %Y') as months")
    //     // )
    //     // ->get()
    //     // ->groupBy('months');

    //     // return $contact->toArray();


    //     //TRIAL 5

    //     $contact = Contact::with(
    //         [
    //             'status' => function ($q) {
    //                 $q->select('id', 'name');
    //             },
    //             'category' => function ($q) {
    //                 $q->select('id', 'name');
    //             },
    //             'type' => function ($q) {
    //                 $q->select('id', 'name');
    //             },
    //             'user' => function ($q) {
    //                 $q->select('id', 'name');
    //             },
    //             'summary' => function ($q) {
    //                 $q->select(['id', 'todo_date', 'contact_id', 'action_id'])
    //                     ->orderBy('todo_date');
    //             },
    //             'summary.action' => function ($q) {
    //                 $q->select('id', 'name');
    //             },
    //         ],
    //     )
    //         ->select('id', 'name', 'status_id', 'type_id', 'category_id', 'user_id')
    //         ->get();

    //     // group smua todo by month
    //     $contact
    //         ->transform(function ($company) {
    //             $company->setRelation(
    //                 'summary',
    //                 $company->summary
    //                     ->groupBy(
    //                         fn ($summary) => \Carbon\Carbon::create($summary->todo_date)->format('F-Y')
    //                     )

    //             );

    //             return $company;
    //         });

    //     return $contact;
    // }
}
