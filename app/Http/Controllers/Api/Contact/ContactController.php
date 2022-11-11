<?php

namespace App\Http\Controllers\Api\Contact;

use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Imports\ContactImport;
use App\Models\Admin\SvSbPivot;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function getuserid(Request $request)
    {
        $user = Auth::user()->id; // Retrieve the currently authenticated user...
        $id = Auth::id(); // Retrieve the currently authenticated user's ID...


        // $user = $request->user(); // returns an instance of the authenticated user...
        // $id = $request->user()->id; // Retrieve the currently authenticated user's ID...


        // $user = auth()->user(); // Retrieve the currently authenticated user...
        // $id = auth()->id();  // Retrieve the currently authenticated user's ID...

        // $contact = Contact::all();

        // return $contact->where('user_id','=',$id);
        // $user = auth()->user();
        // dd($id);
        // dd($user);
        return $user;
    }


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

        $id = Auth::id();


        if ((DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 2)
                ->exists()) ||
            (DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 1)
                ->exists())
        ) {
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
        } else if (SvSbPivot::where('supervisor_id', '=', $id)->exists()) {
            $sv_sb = "";
            $final = [$id];

            $sv_sb = SvSbPivot::select('subordinate_id')
                ->where('supervisor_id', '=', $id)
                ->pluck('subordinate_id');


            array_push($final, ...$sv_sb);
            // ->whereIn('contacts.user_id', $final) // for view under supervisor and the subordinates

            $contact = Contact::select([
                'contacts.*',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'contact_categories.name as category_name',
                'contact_industries.name as industry_name'
            ])
                // ->where('contacts.user_id', '=', $id) // for view under user only
                ->whereIn('contacts.user_id', $final) // for view under supervisor and the subordinates
                // ->whereIn('contacts.user_id', [1])
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
        } else {
            $final = [$id];

            $sv_sb = ["null"];

            array_push($final, ...$sv_sb);
            // ->whereIn('contacts.user_id', $final) // for view under supervisor and the subordinates


            $contact = Contact::select([
                'contacts.*',
                'contact_statuses.name as status_name',
                'contact_types.name as type_name',
                'users.name as user_name',
                'contact_categories.name as category_name',
                'contact_industries.name as industry_name'
            ])
                // ->where('contacts.user_id', '=', $id) // for view under user only
                ->whereIn('contacts.user_id', $final) // for view under supervisor and the subordinates
                // ->whereIn('contacts.user_id', [1])
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
            // 'user_id' => $request->user_id ?? 2, //change to current user later
            'user_id' => Auth::id(), //change to current user later
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

    public function remark(Contact $contact)
    {
        $contact = Contact::where('id', $contact->id)
            ->select('remark')
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

    public function summary_action()
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

        // $id = Auth::id();

        // if ((DB::table('model_has_roles')
        //         ->where('model_id', '=', $id)
        //         ->where('role_id', '=', 2)
        //         ->exists()) ||
        //     (DB::table('model_has_roles')
        //         ->where('model_id', '=', $id)
        //         ->where('role_id', '=', 1)
        //         ->exists())
        // ) 
        // {
        $contact = Contact::with(
            [
                'summary_action' => function ($q) {
                    $q->select(['id', 'todo_date', 'contact_id', 'action_id'])
                        ->orderBy('todo_date', 'desc');
                },
                'summary_action.action' => function ($q) {
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
                $query->whereHas('summary_action', function ($q) use ($selectedYear) {
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
                    'summary_action',
                    $company->summary_action->groupBy(
                        fn ($summary_action) => \Carbon\Carbon::create($summary_action->todo_date)->format('MY')
                    )
                );

                return $company;
            })->toArray();

        return $contact;

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Successfully fetch data Contact ',
        //     'data' => $contact,
        // ]);
        // } 
        // else {
        //     $sv_sb = "";
        //     $final = [$id];

        //     if (SvSbPivot::where('supervisor_id', '=', $id)->exists()) {
        //         $sv_sb = SvSbPivot::select('subordinate_id')
        //             ->where('supervisor_id', '=', $id)
        //             ->pluck('subordinate_id');
        //     } else {
        //         $sv_sb = ["null"];
        //     }

        //     array_push($final, ...$sv_sb);


        //     $contact = Contact::with(
        //         [
        //             'summary_action' => function ($q) {
        //                 $q->select(['id', 'todo_date', 'contact_id', 'action_id'])
        //                     ->orderBy('todo_date', 'desc');
        //             },
        //             'summary_action.action' => function ($q) {
        //                 $q->select('id', 'name');
        //             },
        //         ],
        //     )
        //         ->join('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
        //         ->join('contact_types', 'contacts.type_id', '=', 'contact_types.id')
        //         ->join('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
        //         ->join('contact_industries', 'contacts.industry_id', '=', 'contact_industries.id')
        //         ->join('users', 'contacts.user_id', '=', 'users.id')
        //         ->select([
        //             'contacts.id',
        //             'contacts.name',
        //             'contact_statuses.name as status_name',
        //             'contact_types.name as type_name',
        //             'users.name as user_name',
        //             'contact_categories.name as category_name',
        //             'contact_industries.name as industry_name',

        //         ])
        //         ->whereIn('contacts.user_id', $final) // for view under supervisor and the subordinates
        //         ->when($selectedStatus, function ($query) use ($selectedStatus) {
        //             $query->where('contacts.status_id', $selectedStatus);
        //         })
        //         ->when($selectedType, function ($query) use ($selectedType) {
        //             $query->where('contacts.type_id', $selectedType);
        //         })
        //         ->when($selectedUser, function ($query) use ($selectedUser) {
        //             $query->where('contacts.user_id', $selectedUser);
        //         })
        //         ->when($selectedCategory, function ($query) use ($selectedCategory) {
        //             $query->where('contacts.category_id', $selectedCategory);
        //         })
        //         ->when($selectedIndustry, function ($query) use ($selectedIndustry) {
        //             $query->where('contacts.industry_id', $selectedIndustry);
        //         })
        //         ->when($selectedYear, function ($query) use ($selectedYear) {
        //             $query->whereHas('summary_action', function ($q) use ($selectedYear) {
        //                 $q->whereYear('todo_date', $selectedYear);
        //             });
        //         })
        //         ->orderBy($sort_field, $sort_direction)
        //         ->search(trim($search_term))
        //         // ->get();
        //         ->paginate(5000);

        //     // group smua todo by month
        //     $contact
        //         ->transform(function ($company) {
        //             $company->setRelation(
        //                 'summary_action',
        //                 $company->summary_action->groupBy(
        //                     fn ($summary) => \Carbon\Carbon::create($summary->todo_date)->format('MY')
        //                 )
        //             );

        //             return $company;
        //         })
        //         ->toArray();

        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Successfully fetch data Contact ',
        //         'data' => $contact,
        //     ]);
        // }
    }

    public function summary_todo()
    {
        // STACK OVERFLOW sortby with function
        // $items = UserItems::where('user_id','=',$this->id)
        // ->where('quantity','>',0)
        // ->get()
        // ->sortBy(function($useritem, $key) {
        //   return $useritem->item->type;
        // });


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

        $id = Auth::id();

        if ((DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 2)
                ->exists()) ||
            (DB::table('model_has_roles')
                ->where('model_id', '=', $id)
                ->where('role_id', '=', 1)
                ->exists())
        ) {
            $contact = Contact::with(
                [
                    'summary_todo' => function ($q) {
                        $q->select(['id', 'todo_date', 'contact_id', 'action_id'])
                            ->orderBy('todo_date', 'desc');
                    },

                    'summary_todo.action' => function ($q) {
                        $q->select('id', 'name');
                    },

                ],
            )
                ->leftJoin('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->leftJoin('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                ->leftJoin('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
                ->leftJoin('contact_industries', 'contacts.industry_id', '=', 'contact_industries.id')
                ->leftJoin('users', 'contacts.user_id', '=', 'users.id')
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
                // ->when($selectedYear, function ($query) use ($selectedYear) {
                //     $query->whereHas('summary_todo', function ($q) use ($selectedYear) {
                //         $q->whereYear('todo_date', $selectedYear);
                //     });
                // })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))

                ->paginate(5000);
            // ->get();


            // group smua todo by month
            $contact
                ->transform(function ($company) {
                    $company->setRelation(
                        'summary_todo',
                        $company->summary_todo->groupBy(
                            fn ($summary) => \Carbon\Carbon::create($summary->todo_date)->format('MY')
                        )
                    );

                    return $company;
                })
                ->toArray();

            return $contact;
        } else {
            $sv_sb = "";
            $final = [$id];

            if (SvSbPivot::where('supervisor_id', '=', $id)->exists()) {
                $sv_sb = SvSbPivot::select('subordinate_id')
                    ->where('supervisor_id', '=', $id)
                    ->pluck('subordinate_id');
            } else {
                $sv_sb = ["null"];
            }

            array_push($final, ...$sv_sb);
            $contact = Contact::with(
                [
                    'summary_todo' => function ($q) {
                        $q->select(['id', 'todo_date', 'contact_id', 'action_id'])
                            ->orderBy('todo_date', 'desc');
                    },

                    'summary_todo.action' => function ($q) {
                        $q->select('id', 'name');
                    },

                ],
            )
                ->leftJoin('contact_statuses', 'contacts.status_id', '=', 'contact_statuses.id')
                ->leftJoin('contact_types', 'contacts.type_id', '=', 'contact_types.id')
                ->leftJoin('contact_categories', 'contacts.category_id', '=', 'contact_categories.id')
                ->leftJoin('contact_industries', 'contacts.industry_id', '=', 'contact_industries.id')
                ->leftJoin('users', 'contacts.user_id', '=', 'users.id')
                ->select([
                    'contacts.id',
                    'contacts.name',
                    'contact_statuses.name as status_name',
                    'contact_types.name as type_name',
                    'users.name as user_name',
                    'contact_categories.name as category_name',
                    'contact_industries.name as industry_name',

                ])
                ->whereIn('contacts.user_id', $final) // for view under supervisor and the subordinates
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
                    $query->whereHas('summary_todo', function ($q) use ($selectedYear) {
                        $q->whereYear('todo_date', $selectedYear);
                    });
                })
                ->orderBy($sort_field, $sort_direction)
                ->search(trim($search_term))

                ->paginate(5000);
            // ->get();


            // group smua todo by month
            $contact
                ->transform(function ($company) {
                    $company->setRelation(
                        'summary_todo',
                        $company->summary_todo->groupBy(
                            fn ($summary) => \Carbon\Carbon::create($summary->todo_date)->format('MY')
                        )
                    );

                    return $company;
                })
                ->toArray();

            return $contact;
        }



        // return response()->json([
        //     'status' => true,
        //     'message' => 'Successfully fetch data Contact ',
        //     'data' => $contact,
        // ]);
    }


    public function export($contact)
    {
        $date = Carbon::now()->format('Ymd');

        $contactsArray = explode(',', $contact);

        // return Excel::download(new ContactExport($contactsArray), ('Contacts - ' . $date . '.xlsx'));
        return (new ContactExport($contactsArray))->download('Contacts - ' . $date . '.xlsx');
    }

    public function selectAll()
    {
        return Contact::pluck('id');
    }

    public function import(Request $request)
    {
        // $this->validate($request, [
        //     'file' => 'required|mimes:xls,xlsx',
        // ]);

        Excel::import(new ContactImport, $request->file('file'));

        return response()->json([
            'status' => true,
            'message' => 'Successfully import Contact ',
        ]);
        // return $request->all();
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
