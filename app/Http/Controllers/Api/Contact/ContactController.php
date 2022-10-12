<?php

namespace App\Http\Controllers\Api\Contact;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            'user_id' => $request->user_id ?? 2, //change to current user later
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
        $contact = Contact::with([
            'category', 'type', 'status', 'incharge', 'user',
            'todo' => function ($q) {
                $q->orderBy('todo_date', 'desc');
            }, 'industry', 'forecast'
        ])
            ->where('id', $contact->id)
            ->get();

        $data = $contact->toArray();

        return response()->json([
            'status' => true,
            'message' => 'Successfully fetch data Contact ',
            'data' => $data,
        ]);
    }

    public function history(Contact $contact)
    {
        $contact = Contact::with([
            'todo' => function ($q) {
                $q->select(
                    'id',
                    'contact_id',
                    'todo_date',
                    'todo_deadline',
                    'todo_remark',
                    'user_id',
                    'task_id',
                    'action_id'
                )
                    ->orderBy('todo_date', 'desc');
            },
        ])->select('contacts.id', 'contacts.name')
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
        $selectedIndustry = request('selectedIndustry');
        $selectedYear = request('selectedYear');


        $contact = Contact::with(
            [
                'summary' => function ($q) {
                    $q->select(['id', 'todo_date', 'contact_id', 'action_id'])
                        ->orderBy('todo_date', 'desc');
                },
                'summary.action' => function ($q) {
                    $q->select('id', 'name');
                },
            ],
        )
            ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
            ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
            ->join('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
            ->join('contact_industries', 'contacts.industry_id', '=', 'contact_industries.id')
            ->join('users', 'contacts.user_id', '=', 'users.id')
            ->select([
                'contacts.id',
                'contacts.name',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'contact_categories.name as category_name',
                'contact_industries.name as industry_name',

            ])
            ->when($selectedStatus, function ($query) use ($selectedStatus) {
                $query->where('contacts.status_id', $selectedStatus);
            })
            ->when($selectedType, function ($query) use ($selectedType) {
                $query->where('contacts.type_id', $selectedType);
            })
            ->when($selectedUser, function ($query) use ($selectedUser) {
                $query->where('contacts.user_id', $selectedUser);
            })
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->where('contacts.category_id', $selectedCategory);
            })
            ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
                $query->where('contacts.industry_id', $selectedIndustry);
            })
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereHas('summary', function ($q) use ($selectedYear) {
                    $q->whereYear('todo_date', $selectedYear);
                });
            })
            ->orderBy($sort_field, $sort_direction)
            ->search(trim($search_term))
            // ->get();
            ->paginate(5000);

        // group smua todo by month
        $contact
            ->transform(function ($company) {
                $company->setRelation(
                    'summary',
                    $company->summary->groupBy(
                        fn ($summary) => \Carbon\Carbon::create($summary->todo_date)->format('MY')
                    )
                );

                return $company;
            });


        return $contact->toArray();
    }


    public function export($contact)
    {
        $date = Carbon::now()->format('Ymd');

        $contactsArray = explode(',', $contact);

        return Excel::download(new ContactExport($contactsArray), ('Contacts - ' . $date . '.xlsx'));
    }

    public function selectAll()
    {
        return Contact::pluck('id');
    }

    public function test()
    {

        ### DB Raw method from discord ###

        ##trial 1

        // $contact = Contact::select(
        //     'name',
        //     DB::raw("DATE_FORMAT(created_at, '%M %Y') as months")
        // )
        // ->get()
        // ->groupBy('months');

        // return $contact->toArray();


        //TRIAL 5

        $contact = Contact::with(
            [
                'status' => function ($q) {
                    $q->select('id', 'name');
                },
                'category' => function ($q) {
                    $q->select('id', 'name');
                },
                'type' => function ($q) {
                    $q->select('id', 'name');
                },
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'industry' => function ($q) {
                    $q->select('id', 'name');
                },
                'summary' => function ($q) {
                    $q->select(['id', 'todo_date', 'contact_id', 'action_id'])
                        ->orderBy('todo_date');
                },
                'summary.action' => function ($q) {
                    $q->select('id', 'name');
                },
            ],
        )
            ->select('id', 'name', 'status_id', 'type_id', 'category_id', 'industry_id', 'user_id')
            ->get();

        // group smua todo by month
        $contact
            ->transform(function ($company) {
                $company->setRelation(
                    'summary',
                    $company->summary
                        ->groupBy(
                            fn ($summary) => \Carbon\Carbon::create($summary->todo_date)->format('F-Y')
                        )

                );

                return $company;
            });

        return $contact;
    }
}
