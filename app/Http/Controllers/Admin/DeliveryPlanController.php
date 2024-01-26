<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\DeliveryPlan;
use App\Models\Driver;
use App\Models\Godown;
use App\Models\Hub;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryPlanController extends Controller
{
    protected $roles;
    protected $fiscalYear;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;
    protected $officeId = '';
    protected $paymentMode = '';
    public function __construct()
    {

        // $this->paymentMode = ApiController::GetPaymentMode();
        // $this->fiscalYear = ApiController::GetFiscalYears();
        //dd(session()->all());
        $roles = session()->has('roles') ? Helper::jsonDE(session()->get('roles')) : session()->put('roles', ApiController::GetRoles());
        $del_val = ['SuperAdmin', 'CompanyAdmin'];
        if ($roles) {
            foreach ($roles as $key => $value) {
                if (!in_array($value['name'], $del_val)) {
                    $this->roles[$value['name']] = $value['name'];
                }
            }
        }
        $user = session()->has('userData') ? Helper::jsonDE(session()->get('userData')) : ApiController::user(session()->get('loginid'));
        $roleName = session()->get('roleName');

        $this->user = Helper::jsonDE($user);
        $this->roleName = session()->get('roleName');
        $this->routeRole = str_replace(' ', '_', strtolower($this->roleName));
    }
    public function index()
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        if (session()->get('masterOfficeId') == null) {
            $offices = ApiController::GetOfficeList($user['officeId']);
            $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

            $delivery_plans = DeliveryPlan::get_all();
            // dd($delivery_plans);
            usort($delivery_plans, function ($a, $b) {
                return strtotime($b['planDate']) - strtotime($a['planDate']);
            });
            $data['delivery_plans'] = $delivery_plans;

            $data['planDate'] = date('Y-m-d');
            $data['expectedDeliveryDate'] = date('Y-m-d', strtotime($data['planDate'] . ' + 4 days'));
            $products = Product::get_all($user['officeId']);

            $data['products'] = array_filter($products, function ($item) {
                if (stripos($item['productTypeId'], 1) !== false) {
                    return true;
                }
                return false;
            });
            $data['plan_statuses'] = DeliveryPlan::GetDeliveryStatus();
            return view('module.delivery_plan.delivery_plan_index', $data);
        } else {
            $data['planDate'] = date('Y-m-d');
            $data['expectedDeliveryDate'] = date('Y-m-d', strtotime($data['planDate'] . ' + 4 days'));
            $this->officeId = session()->get('officeId');
            $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

            $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($this->officeId);
            // $delivery_plans = DeliveryPlan::GetDeliveryPlanByOfficeId($this->officeId);
            $delivery_plans = DeliveryPlan::GetDeliveryPlanAllByOfficeId($this->officeId);
            usort($delivery_plans, function ($a, $b) {
                return strtotime($b['planDate']) - strtotime($a['planDate']);
            });
            $data['delivery_plans'] = $delivery_plans;

            // $data['delivery_details'] = DeliveryPlan::GetDeliveryPlanDetailsByOfficeId($this->officeId);

            //$data['delivery_plans']=DeliveryPlan::get_all();
            $data['delivery_status'] = DeliveryPlan::GetDeliveryStatus();
            $products = Product::get_all($this->officeId);

            $data['products'] = array_filter($products, function ($item) {
                if (stripos($item['productTypeId'], 1) !== false) {
                    return true;
                }
                return false;
            });
            $plan_statuses = DeliveryPlan::GetDeliveryStatus();
            $data['plan_statuses'] = array_filter($plan_statuses, function ($item) {
                if (!in_array($item['deliveryPlanStatusId'], [1, 7])) {
                    return true;
                }
                return false;
            });
            //dd($data['products'] );
            // dd(session()->get('masterOfficeId'));
            //dd($data);
            return view('module.delivery_plan.delivery_plan_index_for_companyadmin', $data);
            // return view('module.delivery_plan.delivery_details_index',$data);
        }

    }
    public function sortByPlanDateDesc($a, $b)
    {
        return strtotime($b['planDate']) - strtotime($a['planDate']);
    }
    public function create()
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $offices = ApiController::GetOfficeList($user['officeId']);
        $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

        // $data['manufacturingHubs']=DeliveryPlan::GetManufacturingHub();
        $data['manufacturingHubs'] = Hub::GetHubList();

        $products = Product::get_all($user['officeId']);
        $data['products'] = array_filter($products, function ($item) {
            if (stripos($item['productTypeId'], 1) !== false) {
                return true;
            }
            return false;
        });

        // dd($data['products']);
        $data['tankerCapacities'] = [
            ['capacity' => 5000],
            ['capacity' => 10000],
            ['capacity' => 15000],
            ['capacity' => 20000],
        ];
        $data['deliveryLimits'] = [
            ['limit' => 500],
            ['limit' => 1000],
            ['limit' => 1500],
            ['limit' => 2000],

        ];
        $data['deliveryPlanId'] = 0;
        $data['delivery_details'] = null;

        $data['planDate'] = date('Y-m-d H:i:s');
        $data['expectedDeliveryDate'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 4 days'));
        $data['tankerCapacity'] = 12000;
        $data['deliveryLimit'] = 500;
        $data['planTitle'] = 'New';
        $data['deliveryPlanStatusId'] = 0;
        $data['manufactureingHub'] = 1;
        $data['productId'] = 1;
        return view('module.delivery_plan.delivery_plan_create', $data);
    }
    public function new_request(Request $request)
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        //dd($request->all());
        $data['request'] = [
            "ProductTypeId" => (int) $request->productId,
            "StartingPointId" => (int) $request->manufactureingHub,
            "MinimumMultiple" => (double) $request->deliveryLimit,
            "TankCapacity" => (float) $request->tankerCapacity,
            "PlanDateTime" => date('Y-m-d H:i:s', strtotime($request->planDate)),
            "DeliveryDateTime" => date('Y-m-d H:i:s', strtotime($request->expectedDeliveryDate)),
            "DeliveryPlanId" => (int) $request->deliveryPlanId,
            "OfficeIdList" => [],
            "SpeedOfVehicle" => null,
            "StoppageUnloadingTime" => null,
            "ExtraUnloadingTime" => null,
        ];

        //dd(json_encode($data['request'], true));
        // Python Api
        $data['response'] = DeliveryPlan::GetDeliveryRequest($data['request']);
        // dd($data['response']);
        $data['request']['planDate'] = $request->planDate;
        $data['request']['expectedDeliveryDate'] = $request->expectedDeliveryDate;

        $data['planTitle'] = 'DP_' . str_replace(' ', '_', $request->product) . '_' . $request->tankerCapacity . '_' . $request->deliveryLimit . '_' . $request->mfgHub . '_' . date_create($request->expectedDeliveryDate)->format('d-m-Y');

        $data['requestData'] = $data['request'];
        //dd($data['response']);
        $view = view('module.delivery_plan.delivery_plan_request', $data)->render();
        return response()->json([
            "status" => true,
            "message" => "Request Accepted",
            "data" => $data['response'],
            "html" => $view,
        ]);

    }
    public function modified_request(Request $request)
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        // dd($request->all());
        $data['request'] = [
            "ProductTypeId" => (int) $request->productTypeId,
            "StartingPointId" => (int) $request->StartingPointId,
            "MinimumMultiple" => (double) $request->MinimumMultiple,
            "TankCapacity" => (float) $request->TankCapacity,
            "PlanDateTime" => date('Y-m-d H:i:s', strtotime($request->planDate)),
            "DeliveryDateTime" => date('Y-m-d H:i:s', strtotime($request->expectedDeliveryDate)),
            "DeliveryPlanId" => [],
            "OfficeIdList" => json_decode($request->OfficeIdList),
        ];
        //dd(json_encode($data['request']));
        //python request
        $data['response'] = DeliveryPlan::GetDeliveryRequest($data['request']);
        $data['request']['planDate'] = $request->planDate;
        $data['request']['expectedDeliveryDate'] = $request->expectedDeliveryDate;

        $data['planTitle'] = 'DeliveryPlan_' . str_replace(' ', '_', $request->product) . '_' . $request->tankerCapacity . '_' . $request->deliveryLimit . '_' . $request->mfgHub . '_' . date_create($request->expectedDeliveryDate)->format('d-m-Y');

        $data['requestData'] = $data['request'];

        return response()->json([
            "status" => true,
            "message" => "Request Accepted",
            "data" => $data['response'],
        ]);

    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'planTitle' => 'required|max:60',
            'planDate' => 'required',
            'StartingPointId' => 'required',
            'expectedDeliveryDate' => 'required',
            'ExpectedReturnTime' => 'required',
            'productId' => 'required|numeric|min:1',
            'TankCapacity' => 'required|numeric|min:1',
            'MinimumMultiple' => 'required|numeric|min:1',
        ]);
        // process the data

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        }

        $data = [
            'planTitle' => base64_encode($request->planTitle),
            'planDate' => $request->planDate,
            'expectedDeliveryDate' => $request->expectedDeliveryDate,
            'expectedReturnTime' => $request->ExpectedReturnTime,
            'productId' => $request->productId,
            'startPointId' => $request->StartingPointId,
            'containerSize' => $request->TankCapacity,
            'deliveryLimit' => $request->MinimumMultiple,
            'deliveryPlanStatusId' => 1,
            'userId' => $user['id'],
        ];
        $newList = json_decode($request->data);
        //dd($newList);
        $data['deliveryPlanDetails'] = [];
        foreach ($newList as $key => $item) {
            $detailsArray['deliveryPlanDetailsId'] = 0;
            $detailsArray['plannedQuantity'] = $item->atDeliveryRequirement;
            $detailsArray['expectedDeliveryTime'] = date('c', strtotime($item->estimatedDeliveryTime));
            $detailsArray['officeId'] = $item->officeId;
            $detailsArray['currentQuantity'] = $item->currentStock;
            $detailsArray['availableQuantity'] = $item->totalCapacity - $item->currentStock;
            $detailsArray['deliveryPlanDetailsStatusId'] = $item->DeliveryPlanDetailsStatusId ?? 1;
            $detailsArray['sequenceNo'] = $key + 1;
            array_push($data['deliveryPlanDetails'], $detailsArray);

        }

        if ($request->deliveryPlanId > 0) {
            $data['deliveryPlanId'] = $request->deliveryPlanId;
            // dd(json_encode($data));
            $response = DeliveryPlan::UpdateDeliveryPlan($data);
        } else {
            // dd(json_encode($data));
            $response = DeliveryPlan::SaveDeliveryPlan($data);
        }

        //dd($response['message']);
        if (!$response['status'] == true) {
            return response()->json([
                "status" => false,
                "errors" => [$response['message']],
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Delivery Plan Updated successfully",
        ]);

    }

    public function show($id)
    {
        $user = $this->user;
        // $fiscalYearId = session()->has('fiscalYearId') ? session()->get('fiscalYearId') : $user['fiscalYear']['fiscalYearId'];
        $fiscalYearId = $user['fiscalYear']['fiscalYearId'];
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $this->officeId = session()->get('officeId');
        // $offices = ApiController::GetOfficeList($user['officeId']);
        // $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

        //ViewDeliveryPlan
        // $data['delivery_details'] = DeliveryPlan::GetDeliveryPlan($id);

        //dd($id);
        // $data['currentOffice'] = ApiController::GetOffice($this->officeId);
        // $data['officeList'] = ApiController::GetOfficeDownline($this->officeId,3);
        // $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($this->officeId);

        $offices = ApiController::GetOfficeListWithInvoiceNo($this->officeId, $fiscalYearId);
        $data['officeList'] = $offices;
        $data['delivery_plans'] = DeliveryPlan::get_all();
        $data['delivery_details'] = DeliveryPlan::GetDeliveryPlanDetailsByDeliveryPlanId($id);
        //dd($data['delivery_details']);
        $data['delivery_status'] = DeliveryPlan::GetDeliveryStatus();
        // dd(session()->get('masterOfficeId'));
        //dd($data['delivery_details']);
        return view('module.delivery_plan.delivery_plan_view', $data);
        //dd( $data['plan']);
        /* dd($data);*/

    }

    public function edit($id)
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $offices = ApiController::GetOfficeList($user['officeId']);
        $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

        $data['manufacturingHubs'] = DeliveryPlan::GetManufacturingHub();

        $products = Product::get_all($user['officeId']);
        $data['products'] = array_filter($products, function ($item) {
            if (stripos($item['productTypeId'], 1) !== false) {
                return true;
            }
            return false;
        });
        $data['tankerCapacities'] = [
            ['capacity' => 5000],
            ['capacity' => 10000],
            ['capacity' => 15000],
            ['capacity' => 20000],
        ];
        $data['deliveryLimits'] = [
            ['limit' => 500],
            ['limit' => 1000],
            ['limit' => 1500],
            ['limit' => 2000],

        ];
        $data['deliveryPlanId'] = $id;

        $data['delivery_details'] = DeliveryPlan::GetDeliveryPlanDetailsByDeliveryPlanId($id);
        // dd($data);
        $data['planDate'] = date('Y-m-d H:i:s', strtotime($data['delivery_details'][0]['deliveryPlan']['planDate']));
        $data['expectedDeliveryDate'] = date('Y-m-d H:i:s', strtotime($data['delivery_details'][0]['deliveryPlan']['expectedDeliveryDate']));
        $data['tankerCapacity'] = $data['delivery_details'][0]['deliveryPlan']['containerSize'];
        $data['deliveryLimit'] = $data['delivery_details'][0]['deliveryPlan']['deliveryLimit'];
        $data['planTitle'] = $data['delivery_details'][0]['deliveryPlan']['planTitle'];
        $data['deliveryPlanStatusId'] = $data['delivery_details'][0]['deliveryPlan']['deliveryPlanStatusId'];
        $data['manufactureingHub'] = $data['delivery_details'][0]['deliveryPlan']['startPointId'];
        $data['productId'] = $data['delivery_details'][0]['deliveryPlan']['productId'];
        return view('module.delivery_plan.delivery_plan_create', $data);
    }

    public function update(Request $request, $id)
    {
        //
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
    public function update_status(Request $request, $id)
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $submit_data = [
            "deliveryPlanId" => $request->deliveryPlanId,
            "deliveryPlanStatusId" => $request->deliveryPlanStatusId,
            "userId" => $user['id'],
        ];

        $response = DeliveryPlan::UpdateDeliveryPlanStatus($submit_data);
        // dd($response);
        // dd($submit_data);
        //$GetView = view('module.delivery_plan.receive_delivery', $data)->render();
        // dd($response['status']);
        return response()->json([
            "status" => $response['status'],
            "message" => $response['message'],
        ]);
    }
    public function delete(Request $request)
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $submit_data = [
            "deliveryPlanId" => $request->deliveryPlanId,
            "deliveryPlanStatusId" => 7,
            "userId" => $user['id'],
        ];
        $response = DeliveryPlan::UpdateDeliveryPlanStatus($submit_data);
        // dd($response->json());
        return response()->json([
            "status" => $response->json()['status'],
            "message" => $response->json()['message'],
        ]);
    }
    public function approve_requirement($id)
    {

        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['planDetails'] = DeliveryPlan::GetDeliveryPlanDetailsById($id);

        $GetView = view('module.delivery_plan.approve_requirement', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function confirm_requirement(Request $request, $id)
    {
        //dd($request);
        if ($request->approvedQuantity == null) {
            $approvedQuantity = $request->plannedQuantity;

        } else {
            $approvedQuantity = $request->approvedQuantity;
        }
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $submitData =
            [
            [
                'deliveryPlanDetailsId' => $id,
                'approvedQuantity' => $approvedQuantity,
                'deliveryPlanDetailsStatusId' => 2,
                'approvedBy' => $user['id'],
            ],
        ];
        $response = DeliveryPlan::ApproveDeliveryPlanDetails($submitData);
        //dd($response['message']);
        if (!$response['status'] == true) {
            return response()->json([
                "status" => false,
                "errors" => [$response['message']],
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Approval done successfully",
        ]);

    }
    public function approve($id)
    {

        $user = $this->user;
        $officeId = $user['officeId'];
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['title'] = 'Approval: ';
        $data['deliveryPlanId'] = $id;
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        if ($data['isTopAdmin']) {
            // $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlan($id);
            $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlanByDeliveryPlanIdOfficeId($id, $user['officeId']);
            //   dd($data['planDetails']);
        } else {
            //$this->officeId = session()->get('officeId');
            $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlanByDeliveryPlanIdOfficeId($id, $user['officeId']);

        }
        $data['planDetails'] = $data['deliveryPlan'];
        $GetView = view('module.delivery_plan.approval.index', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function receive($id)
    {

        $user = $this->user;
        $officeId = $user['officeId'];
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['title'] = 'Receiving: ';
        $data['deliveryPlanId'] = $id;
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        // $data['planDetails'] = DeliveryPlan::GetDeliveryPlanDetailsByDeliveryPlanId($id);
        // $planDetails = DeliveryPlan::GetDeliveryPlanDetailsByOfficeId($officeId);

        if ($data['isTopAdmin']) {
            // $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlan($id);
            $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlanByDeliveryPlanIdOfficeId($id, $user['officeId']);
            //   dd($data['planDetails']);
        } else {
            //$this->officeId = session()->get('officeId');
            $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlanByDeliveryPlanIdOfficeId($id, $user['officeId']);

        }
        $data['planDetails'] = $data['deliveryPlan'];

        $data['deliveryPlanStatus'] = DeliveryPlan::GetDeliveryStatus();
        // $data['planDetails'] = collect($planDetails)->where('deliveryPlanId', $id)->values()->all();
        $GetView = view('module.delivery_plan.receiving.index', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function confirm_requirement_multi(Request $request)
    {
        // dd($request->all());
        $user = $this->user;
        $submitData = [];
        foreach ($request->input('deliveryPlanDetailsId') as $key => $value) {
            //dd($request->input('plannedQuantity')[$key]);
            if ($request->input('approvedQuantity')[$key] == null) {
                $approvedQuantity = $request->input('plannedQuantity')[$key];

            } else {
                $approvedQuantity = $request->input('approvedQuantity')[$key];
            }

            $data['roleName'] = $this->roleName;
            $data['routeRole'] = $this->routeRole;
            $deliveryPlanDetailsId = $request->input('deliveryPlanDetailsId')[$key];
            array_push($submitData, [
                'deliveryPlanDetailsId' => (int) $deliveryPlanDetailsId,
                'approvedQuantity' => (float) $approvedQuantity,
                'deliveryPlanDetailsStatusId' => (int) $request->input('switch_one')[$key][$deliveryPlanDetailsId],
                'approvedBy' => $user['id'],
            ]
            );

        }
        // dd(json_encode($submitData));
        $response = DeliveryPlan::ApproveDeliveryPlanDetailsByAdmin($submitData);
        //dd($response['status']);
        if (!$response['status'] == true) {
            return response()->json([
                "status" => false,
                "errors" => [$response['message']],
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => $response['message'],
        ]);

    }
    public function receive_delivery_from_multi(Request $request)
    {
        //dd($request->all());
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['receivingQuantity'] = $request->receivingQuantity;
        $deliveryPlanDetails = json_decode(base64_decode($request->planDetails), true);
        //dd($planDetails['deliveredQuantity']);
        $data['title'] = 'Tank Fillup: ';

        if ($deliveryPlanDetails['deliveredQuantity'] == 0) {
            return response()->json([
                "status" => false,
                "message" => 'wait for delivery',
            ]);
        }
        $planDetails = DeliveryPlan::GetDeliveryPlanDetailsById($deliveryPlanDetails['deliveryPlanDetailsId']);
        // dd($planDetails['deliveredQuantity']);

        $planDetails['receivedQuantity'] = ($request->receivedQuantity == null || $request->receivingQuantity == 0) ? $planDetails['deliveredQuantity'] : (float) ($request->receivingQuantity);

        if ($request->receivingQuantity > 0) {
            $planDetails['receivedQuantity'] = (float) $request->receivingQuantity;
        }
        // dd($planDetails);
        $data['orderedQuantity'] = $planDetails['approvedQuantity'];
        $data['deliveredQuantity'] = $planDetails['deliveredQuantity'];
        $data['receivedQuantity'] = $planDetails['receivedQuantity'];

        $data['planDetails'] = $planDetails;
        // $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlan($planDetails['deliveryPlanId']);
        $data['next'] = true;
        // dd($data['planDetails']);
        $officeId = $data['planDetails']['officeId'];
        $data['godowns'] = Godown::GetCurrentStockWithGodownByOfficeId($officeId);

        $GetView = view('module.delivery_plan.receiving.delivery.index', $data)->render();
        //dd($GetView);
        return response()->json([
            "status" => true,
            "message" => 'loading....',
            "html" => $GetView,
        ]);
    }
    public function receive_delivery_from_multi_backup(Request $request)
    {
        dd($request->all);
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['deliveryPlanId'] = $request->deliveryPlanId;
        $data['title'] = 'Tank Fillup: ';

        if ($request->deliveredQuantity == 0) {
            return response()->json([
                "status" => false,
                "message" => 'wait for delivery',
            ]);
        }
        $planDetails = DeliveryPlan::GetDeliveryPlanDetailsById($request->deliveryPlanDetailsId);
        // dd($planDetails['deliveredQuantity']);

        $planDetails['receivedQuantity'] = ($request->receivedQuantity == null || $request->receivedQuantity == 0) ? $planDetails['deliveredQuantity'] : (float) ($request->receivedQuantity);

        if ($request->receivedQuantity > 0) {
            $planDetails['receivedQuantity'] = (float) $request->receivedQuantity;
        }
        // dd($planDetails);
        $data['orderedQuantity'] = $request->orderedQuantity;
        $data['deliveredQuantity'] = $request->deliveredQuantity;
        $data['receivedQuantity'] = $request->receivedQuantity;

        $data['planDetails'] = $planDetails;
        $data['deliveryPlan'] = $planDetails;
        $data['next'] = true;
        // dd($data['planDetails']);
        $officeId = $data['planDetails']['officeId'];
        $data['godowns'] = Godown::GetCurrentStockWithGodownByOfficeId($officeId);
        $GetView = view('module.delivery_plan.receiving.delivery.index', $data)->render();
        return response()->json([
            "status" => true,
            "message" => 'loading....',
            "html" => $GetView,
        ]);
    }
    public function receive_delivery($id)
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['planDetails'] = DeliveryPlan::GetDeliveryPlanDetailsById($id);
        // dd($data['planDetails']);
        $officeId = $data['planDetails']['officeId'];
        $data['godowns'] = Godown::GetCurrentStockWithGodownByOfficeId($officeId);
        $GetView = view('module.delivery_plan.receive_delivery', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function status_change($id, $driver = '')
    {
        $user = $this->user;
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['title'] = 'Plan: ';
        $data['userId'] = $user['id'];
        $data['page'] = $driver;
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;
        //dd($data['isTopAdmin']);
        $data['deliveryPlanId'] = $id; //DeliveryPlan::GetDeliveryPlan($id);
        // $data['planDetails'] = []; //DeliveryPlan::GetDeliveryPlan($id);
        // $data['deliveryPlanStatus'] = []; //DeliveryPlan::GetDeliveryStatus();
        if ($data['isTopAdmin']) {
            $data['planDetails'] = DeliveryPlan::GetDeliveryPlan($id);
            //   dd($data['planDetails']);
        } else {
            //$this->officeId = session()->get('officeId');
            $data['planDetails'] = DeliveryPlan::GetDeliveryPlanByDeliveryPlanIdOfficeId($id, $user['officeId']);

        }

        $data['deliveryPlanStatus'] = DeliveryPlan::GetDeliveryStatus();

        //  $GetView = view('module.delivery_plan.delivery_plan_status_change', $data)->render();
        $GetView = view('module.delivery_plan.status_change.index', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function get_data($id)
    {
        $user = $this->user;
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;

        if ($data['isTopAdmin']) {
            $data['planDetails'] = DeliveryPlan::GetDeliveryPlan($id);
            //   dd($data['planDetails']);
        } else {
            //$this->officeId = session()->get('officeId');
            $data['planDetails'] = DeliveryPlan::GetDeliveryPlanByDeliveryPlanIdOfficeId($id, $user['officeId']);

        }

        //  $planDetails = DeliveryPlan::GetDeliveryPlan($id);
        $deliveryPlanStatus = DeliveryPlan::GetDeliveryStatus();
        //dd($planDetails);
        return response()->json([
            "status" => true,
            "data" => $data['planDetails'],
            "deliveryPlanStatus" => $deliveryPlanStatus,
        ]);
    }
    public function confirm_delivery(Request $request, $id)
    {
        // Working Conntroller After 13/11/2023
        //dd($request->all());
        if ($request->receivedQuantity == null) {
            if ($request->deliveredQuantity > 0) {
                $receivedQuantity = $request->deliveredQuantity;
            } else {
                $receivedQuantity = $request->approvedQuantity;
            }

        } else {
            $receivedQuantity = $request->receivedQuantity;
        }
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $submitData = [
            'deliveryPlanDetailsId' => $id,
            'receivedQuantity' => $receivedQuantity,
            'receivedBy' => $user['id'],
        ];
        $deliveryGodownList = $request->deliveryGodownList;
        $submitData['deliveryGodownMapper'] = json_decode($deliveryGodownList);
        // dd(json_encode($submitData));
        $response = DeliveryPlan::UpdateReceiveDelivery($submitData);
        if (!$response['status'] == true) {
            return response()->json([
                "status" => false,
                "errors" => [$response['message']],
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Receiving confirm successfully",
        ]);
    }
    public function delivery_filter(Request $request)
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        if (session()->get('masterOfficeId') == null) {

            $offices = ApiController::GetOfficeList($user['officeId']);
            $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

            //$data['delivery_plans']=DeliveryPlan::get_all();
            $delivery_plans = DeliveryPlan::get_all();
            $data['delivery_plans'] = $delivery_plans;

            $data['planDate'] = date('Y-m-d');
            $data['expectedDeliveryDate'] = date('Y-m-d', strtotime($data['planDate'] . ' + 4 days'));
            return response()->json([
                "status" => true,
                "data" => $data,
                "message" => "List loaded successfully",
            ]);
            // return view('module.delivery_plan.delivery_plan_index',$data);
        } else {
            $officeId = $request->officeId;

            $fromDate = date('Y-m-d', strtotime($request->fromDate));
            $toDate = date('Y-m-d', strtotime($request->toDate));
            //  $fromDate=$request->fromDate;
            //dd($fromDate);
            //  $toDate=$request->toDate;
            // $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($this->officeId);
            $data['delivery_details'] = DeliveryPlan::GetDeliveryPlanDetailsFilter($officeId, $fromDate, $toDate);
            // $data['delivery_status']=DeliveryPlan::GetDeliveryStatus();
            // dd(session()->get('masterOfficeId'));
            return response()->json([
                "status" => true,
                "data" => $data,
                "message" => "List loaded successfully",
            ]);
            //return view('module.delivery_plan.delivery_details_index',$data);
        }
    }
    public function delivery_details_filter(Request $request)
    {
        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $officeId = $request->officeId;
        if (!$request->officeId || $request->officeId == '') {
            $officeId = $user['officeId'];
        }

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        //  $fromDate=$request->fromDate;
        //dd($officeId);
        //  $toDate=$request->toDate;
        // $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($this->officeId);
        if ($officeId == null) {
            // $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsByDeliveryPlanId($deliveryPlanId);
            $data['delivery_details'] = DeliveryPlan::GetDeliveryPlanDetailsFilter('all', $fromDate, $toDate);
            // dd($data['delivery_details']);
        } else {
            $data['delivery_details'] = DeliveryPlan::GetDeliveryPlanDetailsFilter($officeId, $fromDate, $toDate);
        }

        // $data['delivery_status']=DeliveryPlan::GetDeliveryStatus();
        // dd(session()->get('masterOfficeId'));
        // dd($data);
        return response()->json([
            "status" => true,
            "data" => $data,
            "message" => "List loaded successfully",
        ]);
    }
    public function reject($id)
    {

        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $submitData = [
            'deliveryPlanDetailsId' => $id,
            'approvedQuantity' => 0,
            'deliveryPlanDetailsStatusId' => 3,
            'approvedBy' => $user['id'],
        ];
        $response = DeliveryPlan::ApproveDeliveryPlanDetails($submitData);
        //dd($response['message']);
        if (!$response['status'] == true) {
            return response()->json([
                "status" => false,
                "errors" => [$response['message']],
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Rejection done successfully",
        ]);
    }
    public function driver_backup($id)
    {
        $user = $this->user;
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['title'] = 'Driver Assigning: ';
        $data['drivers'] = Driver::GetDrivers();
        $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlan($id);
        //dd($data['deliveryPlan']);

        if ($data['deliveryPlan']['driver'] !== null) {
            $data['driverId'] = $data['deliveryPlan']['driver']['driverId'];
            foreach ($data['drivers'] as $key => $value) {
                if ($value['driverId'] == $data['driverId']) {
                    $data['drivers'][$key]['assigned'] = true;
                    break;
                }
            }
        }
        $data['planDetails'] = $data['deliveryPlan'];
        //dd($data['drivers']);
        return response()->json([
            'status' => true,
            'data' => $data,
            'html' => view('module.delivery_plan.driver_assigning.index', $data)->render(),
        ]);
    }
    public function driver($id)
    {
        $user = $this->user;
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['title'] = 'Driver Assigning: ';
        $data['deliveryPlanId'] = $id;
        // $data['drivers'] = Driver::GetDrivers();

        $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlan($id);
        $driverAvailable = DeliveryPlan::GetAvailableDriver($id);
        $data['drivers'] = $driverAvailable['driverAvailable'];

        $data['planDetails'] = $data['deliveryPlan'];
        //dd($data['drivers']);
        return response()->json([
            'status' => true,
            'data' => $data,
            'html' => view('module.delivery_plan.driver_assigning.index', $data)->render(),
        ]);
    }

    public function map_data($id)
    {
        $user = $this->user;
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['title'] = 'Driver Assigning: ';
        $data['deliveryPlanId'] = $id;
        // $data['drivers'] = Driver::GetDrivers();

        $mapData = DeliveryPlan::GetDeliveryPlanMapData($id);
        // dd($mapData);
        $data['driverRoute'] = $mapData['driverRoute'];
        $data['plannedRoute'] = $mapData['plannedRoute'];
        //dd($data['drivers']);
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
    public function assign_driver(Request $request, $id)
    {
        $user = $this->user;
        $data['officeId'] = $user['officeId'];
        $data['adminId'] = $user['id'];
        $data['isTopAdmin'] = !$user['masterOfficeId'] ? true : false;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['title'] = 'Driver Assigning: ';
        $data['deliveryPlanId'] = $id;
        $submitData = [
            "driverId" => $request->driverId,
            "deliveryPlanId" => $id,
            "updatedBy" => $user['id'],
        ];
        $response = DeliveryPlan::AssignDriver($submitData);
        if (!$response['status'] == true) {
            return response()->json([
                "status" => false,
                "errors" => [$response['message']],
            ]);
        }

        $data['deliveryPlan'] = DeliveryPlan::GetDeliveryPlan($id);
        $driverAvailable = DeliveryPlan::GetAvailableDriver($id);
        $data['drivers'] = $driverAvailable['driverAvailable'];
        $data['planDetails'] = $data['deliveryPlan'];
        return response()->json([
            'status' => true,
            'data' => $data,
            'html' => view('module.delivery_plan.driver_assigning.index', $data)->render(),
        ]);
    }
}
