<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Contact\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedUser = request('selectedUser');
        $selectedStatus = request('selectedStatus');
        $selectedCategory = request('selectedCategory');
        $selectedType = request('selectedType');
        $selectedIndustry = request('selectedIndustry');

        $contact = Contact::select([
            'contacts.*',
            'contact_statuses.name as status_name',
            'contact_types.name as type_name',
            'users.name as user_name',
            'contact_categories.name as category_name',
            'contact_industries.name as industry_name'
        ])
            ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
            ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
            ->join('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
            ->join('contact_industries', 'contacts.industry_id', '=', 'contact_industries.id')
            ->join('users', 'contacts.user_id', '=', 'users.id')
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('contacts.user_id', $selectedUser);
            })
            ->when($selectedStatus, function ($query) use ($selectedStatus) {
                $query->where('contacts.status_id', $selectedStatus);
            })
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('contacts.category_id', $selectedCategory);
            })
            ->when($selectedType, function ($query) use ($selectedType) {
                $query->where('contacts.type_id', $selectedType);
            })
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                $query->where('contacts.industry_id', $selectedIndustry);
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            ->distinct()
            ->paginate($paginate);

        return ContactResource::collection($contact);
    }

    public function list()
    {
        $contact = Contact::select('id', 'name')->orderBy('name')->get();

        return response()->json([
            'data' => $contact,
            'status' => true,
            'message' => 'Successfully retrieve list of contacts',
        ]);
    }

    public function store(ContactRequest $request)
    {

        $contact = Contact::create([
            'industry_id' => $request->industry_id,
            'name' => $request->name,
            'address' => $request->address ?? 'None',
            'remark' => $request->remark ?? 'None',
            'category_id' => $request->category_id,
            'user_id' => $request->user_id ?? 1, //change to current user later
            'type_id' => $request->type_id,
            'status_id' => $request->status_id,
        ]);

        return response()->json([
            'data' => $contact,
            'status' => true,
            'message' => 'Successfully store contact',
        ]);
    }
    public function show($id)
    {
        $contact = Contact::find($id);
        return response()->json(["data" => $contact]);
    }

    public function update(Request $request, Contact $contact)
    {
        $contact->update([
            'user_id' => $request->user_id,
            'status_id' => $request->status_id,
            'type_id' => $request->type_id,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'industry_id' => $request->industry_id,
            'address' => $request->address,
            'remark' => $request->remark,
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ' . $contact->name,
            'data' => $contact,
        ]);
    }

    public function delete(Contact $contact)
    {
        $contact->delete();
        return response()->json('Contact deleted.');
    }

    public function info(Contact $contact)
    {
        $contact = Contact::with('category', 'type', 'status', 'incharge', 'user', 'todo', 'industry', 'forecast')
            ->where('id', $contact->id)
            ->get();

        $data = $contact->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }

    public function summary()
    {
        $paginate = request('paginate');
        $search_term = request('q', '');

        $sort_direction = request('sort_direction');
        $sort_field = request('sort_field');

        $selectedStatus = request('selectedStatus');
        $selectedType = request('selectedType');
        $selectedUser = request('selectedUser');
        $selectedCategory = request('selectedCategory');


        // Post::with('user:id,username,team_id')

        //     $data
        //         ->selectRaw("
        //     count(id) AS data, 
        //     DATE_FORMAT(created_at, '%Y-%m') AS new_date, 
        //     YEAR(created_at) AS year, 
        //     MONTH(created_at) AS month
        //      ")
        //         ->groupBy('new_date')
        //         ->get();


        $contact = Contact::with(['summary' => function ($query) {
            $query->select(['id', 'contact_id', 'todo_date as todo_date', 'action_id'])
                ->orderBy('todo_date', 'asc')
                ->get();
        }])

            // ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
            // ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
            // ->join('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
            // ->join('users', 'contacts.user_id', '=', 'users.id')

            // ->leftJoin('to_dos', 'contacts.id', '=', 'to_dos.contact_id')

            ->select([
                'contacts.id',
                'contacts.name',
                'contacts.created_at',
                // 'contacts.*',
                // 'contact_statuses.name as status_name',
                // 'contact_types.name as type_name',
                // 'users.name as user_name',
                // 'contact_categories.name as category_name',

            ])
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))

            ->paginate($paginate);

        // ->when($selectedStatus, function ($query) use ($selectedStatus) {
        //     $query->where('contacts.status_id', $selectedStatus);
        // })
        // ->when($selectedType, function ($query) use ($selectedType) {
        //     $query->where('contacts.type_id', $selectedType);
        // })
        // ->when($selectedUser, function ($query) use ($selectedUser) {
        //     $query->where('contacts.user_id', $selectedUser);
        // })
        // ->when($selectedCategory, function ($query) use ($selectedCategory) {
        //     $query->where('contacts.category_id', $selectedCategory);
        // })
        // ->distinct()


        return $contact;
    }


    public function test()
    {
        // $contact = Contact::whereMonth('created_at', Carbon::now()->month)
        //     ->select(DB::raw("MONTH(created_at) month"), DB::raw("count('month') as total_per_month"))
        //     ->groupby('month')
        //     ->get();

        // return $contact;

        // ->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
        // ->groupby('year','month')
        // ->get();

        // $res = ModelName::where('someColumn', 'test')
        //     ->get()
        //     ->groupBy(function ($val) {
        //         return Carbon::parse($val->created_at)->format('Y');
        //     });

        $contact = Contact::with(['summary' => function ($query) {
            $query->select(['id', 'contact_id', 'todo_date', 'action_id'])
                ->groupBy(function ($val) {
                    return Carbon::parse($val->todo_date)->format('Y');
                })
                ->orderBy('todo_date', 'ASC')
                ->get();
        }])

            ->select([
                'contacts.id',
                'contacts.name',
                'contacts.created_at',
            ])
            ->paginate(20);
        return $contact;

        // $todo =  DB::table("to_dos")
        //     ->select("id", DB::raw("(COUNT(*)) as total_click"))
        //     ->orderBy('created_at')
        //     ->groupBy(DB::raw("MONTH(created_at)"))
        //     ->get();

        // return $todo;
    }
}
