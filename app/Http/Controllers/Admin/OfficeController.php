<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Services\OfficeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    // protected $FiscalYear = [
    //     ['fiscalYearId' => 1, 'fiscalYearName' => '22-23'],
    //     ['fiscalYearId' => 2, 'fiscalYearName' => '23-24'],
    // ];
    protected $fiscalYear;
    protected $supportService;
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;
    protected $office;
    protected $officeService;

    public function __construct(OfficeService $officeService)
    {
        $this->officeService = $officeService;
        $this->fiscalYear = ApiController::GetFiscalYears();

        $this->office = json_decode(json_encode(session()->get('officeData')), true);
        // $roles = ApiController::GetRoles();
        $roles = session()->has('roles') ? json_decode(json_encode(session()->get('roles')), true) : session()->put('roles', ApiController::GetRoles());

        $del_val = ['SuperAdmin', 'CompanyAdmin'];
        if ($roles) {
            foreach ($roles as $key => $value) {
                if (!in_array($value['name'], $del_val)) {
                    $this->roles[$value['name']] = $value['name'];
                }
            }
        }
        $user = session()->has('userData') ? json_decode(json_encode(session()->get('userData')), true) : ApiController::user(session()->get('loginid'));
        $roleName = session()->get('roleName');

        $this->user = json_decode(json_encode($user), true);
        $this->roleName = session()->get('roleName');
        $this->routeRole = str_replace(' ', '_', strtolower($this->roleName));
    }

    public function index()
    {
        $data['title'] = '';

        // load the view and pass the users
        return view('companyadmin.office.office_index', $data);

    }
    public function populateOffice()
    {
        $user = (object) $this->user;
        $fiscalYearId = session()->has('fiscalYearId') ? session()->get('fiscalYearId') : $user->fiscalYear['fiscalYearId'];

        $offices = ApiController::GetOfficeListWithInvoiceNo($user->officeId, $fiscalYearId);
        $hierarchy = [];
        foreach ($offices as $office) {

            if ($office['level'] === 0) {
                $hierarchy = $office;

                $hierarchy['children'] = $this->getChildren($office, $offices, $hierarchy);
                //dd($hierarchy);
            }
        }
        $data['offices'] = collect([$hierarchy]);

        // $offices=ApiController::GetOfficeList($user->officeId);
        $data['MasterOffice'] = $this->officeService->GetOfficeById($user->officeId);

        $data['MasterOffice'] = [$data['MasterOffice']];

        $data['collections'] = $offices;

        $GetView = view('module.office._partial.index_body', $data)->render();
        //dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }

    private function getChildren($parent, $offices, &$hierarchy)
    {
        // dd($parent);
        $children = array_filter($offices, function ($office) use ($parent) {
            return $office['masterOfficeId'] === $parent['officeId'];
        });

        foreach ($children as $key => $child) {
            // $hierarchy[] = $child;
            $children[$key]['children'] = $this->getChildren($child, $offices, $hierarchy);
//unset($children[$key]);
        }
        return $children;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $user = (object) $this->user;

        $data['masterOfficeId'] = $user->officeId;
        //dd($data['masterOfficeId']);
        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['gstTypes'] = ApiController::GetGstTypeList();
        $data['masterOfficeList'] = Office::GetMasterOfficeList($user->officeId);
        $info['title'] = "Create Office";
        $info['size'] = "modal-lg";

        $GetView = view('companyadmin.office.office_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function create_wizard()
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $user = (object) $this->user;

        $data['masterOfficeId'] = $user->officeId;
        //dd($data['masterOfficeId']);
        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['gstTypes'] = ApiController::GetGstTypeList();
        // $data['masterOfficeList']=Office::GetMasterOfficeList($user->officeId);
        $data['masterOfficeList'] = Office::GetOfficeById($user->officeId);
        //dd($data['masterOfficeList']);
        $info['title'] = "Create Office";
        $info['size'] = "modal-lg";
        $GetView = view('companyadmin.office.office_new_wizard', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // validate the data
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'officeName' => 'required|max:255',
            'masterOfficeId' => 'required',
            'officeContactNo' => 'nullable|numeric|digits:10',
            'officeEmail' => 'nullable|max:255|email',
        ], [
            'officeName.required' => 'Office Name is required',
            'officeName.max' => 'Office Name is too long',
            'masterOfficeId.required' => 'Master Office is required',
        ])
        ;
        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        } else {
            if ($request->input('gstTypeId') > 0) {
                $validator = Validator::make($request->all(), [
                    'gstNumber' => 'required|min:13|max:15',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        "status" => false,
                        "errors" => $validator->errors(),
                    ]);
                }
            }
            // store the user
            $data = [
                'officeName' => base64_encode($request->input('officeName')),
                'officeTypeId' => $request->input('officeTypeId'),
                'masterOfficeId' => $request->input('masterOfficeId'),
                'registeredAddress' => base64_encode($request->input('registeredAddress')),
                'officeAddress' => base64_encode($request->input('officeAddress')),
                'officeContactNo' => $request->input('officeContactNo'),
                'officeEmail' => $request->input('officeEmail'),
                'longitude' => $request->input('longitude'),
                'latitude' => $request->input('latitude'),
                'appName' => null,
                'tagLine' => null,
                'logo' => null,
                'pin' => null,
                'stateId' => 0,
                'countryId' => null,
                'gstNumber' => $request->input('gstNumber'),
                'gstTypeId' => $request->input('gstTypeId'),
                'panNumber' => null,
                'isActive' => true,
            ];
            //dd(json_encode($data));
            $response = ApiController::CreateOffice($data);

            return response()->json([
                "status" => true,
                "message" => "Office created successfully",
                "officeId" => $response['id'],
            ]);

            //return redirect()->route('companyadmin.office.index')->with('success', 'Office created successfully');
        }
    }

    public function show($id)
    {
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        // get the user
        $office = ApiController::GetOffice($id);

        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['gstTypes'] = ApiController::GetGstTypeList();
        $data['editData'] = (object) $office;
        $info['title'] = "Create Office";
        $info['size'] = "modal-lg";

        $GetView = view('companyadmin.office.office_show', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // dd($id);
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $office = [ApiController::GetOffice($id)];

        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['gstTypes'] = ApiController::GetGstTypeList();
        $data['editData'] = (object) $office[0];
        $info['title'] = "Edit Office";
        $info['size'] = "modal-lg";
        $user = (object) $this->user;
        $data['masterOfficeList'] = Office::GetMasterOfficeList($user->officeId);
        //dd($data);
        $GetView = view('companyadmin.office.office_edit', $data)->render();

        return response()->json([
            "status" => true,
            "html" => base64_encode($GetView),
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // validate the data
        $validator = Validator::make($request->all(), [
            'officeName' => 'required|max:255',
            'masterOfficeId' => 'required',
            'officeContactNo' => 'nullable|numeric|digits:10',
            'officeEmail' => 'nullable|max:255|email',
        ]);

        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        } else {
            if ($request->input('gstTypeId') > 0) {
                $validator = Validator::make($request->all(), [
                    'gstNumber' => 'required|min:13|max:15',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        "status" => false,
                        "errors" => $validator->errors(),
                    ]);
                }
            }
            // update office

            $data = [
                'officeId' => $id,
                'officeName' => base64_encode($request->input('officeName')),
                'officeTypeId' => $request->input('officeTypeId'),
                'masterOfficeId' => $request->input('masterOfficeId') == $id ? null : $request->input('masterOfficeId'),
                'registeredAddress' => base64_encode($request->input('registeredAddress')),
                'officeAddress' => base64_encode($request->input('officeAddress')),
                'officeContactNo' => $request->input('officeContactNo'),
                'officeEmail' => $request->input('officeEmail'),
                'longitude' => $request->input('longitude'),
                'latitude' => $request->input('latitude'),
                'appName' => null,
                'tagLine' => null,
                'logo' => null,
                'pin' => null,
                'stateId' => 0,
                'countryId' => 0,
                'gstNumber' => $request->input('gstNumber'),
                'gstTypeId' => $request->input('gstTypeId'),
                'panNumber' => null,
                'isActive' => true,
            ];

            //dd(json_encode($data));
            $response = ApiController::UpdateOffice($data);
            return response()->json([
                "status" => true,
                "message" => "Office updated successfully",
            ]);
            //return redirect()->route('companyadmin.office.index',$request->input('masterOfficeId'))->with('success', 'Office updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function invoice_no($officeId)
    {
        $data['office'] = [ApiController::GetOffice($officeId)];
        $data['invoice_no'] = 0;

        $data['fiscalYear'] = ApiController::GetFiscalYears();
        //$data['fiscalYear'] = $this->fiscalYear;
        //dd($this->fiscalYear);
        $info['title'] = "Invoice No";
        $info['size'] = "modal-lg";

        $GetView = view('module.office.invoice_no.invoice_no', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function invoice_no_update(Request $request)
    {
        $data = [
            'organizationId' => $request->input('organizationId'),
            'fiscalYearId' => $request->input('fiscalYearId'),
            'invoiceNo' => $request->input('invoiceNo'),
        ];
        $response = ApiController::AddOfficeLastInvoiceDetails($data);

        return response()->json([
            "status" => true,
            "message" => "Invoice No updated successfully",
        ]);
    }

}
