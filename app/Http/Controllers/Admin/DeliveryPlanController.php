<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\DeliveryPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
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
        $roles = ApiController::GetRoles();
        $del_val = ['SuperAdmin', 'CompanyAdmin'];
        foreach ($roles as $key => $value) {
            if (!in_array($value['name'], $del_val)) {
                $this->roles[$value['name']] = $value['name'];
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
        $user =  $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        if(session()->get('masterOfficeId')==null){
            $offices = ApiController::GetOfficeList($user['officeId']);
            $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

            $data['delivery_plans']=DeliveryPlan::get_all();
            $data['planningDate']=date('Y-m-d');
            $data['expectedDeliveryDate']=date('Y-m-d', strtotime($data['planningDate'] . ' + 4 days'));

            return view('module.delivery_plan.delivery_plan_index',$data);
        }
        else{

            $this->officeId=session()->get('officeId');

             $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($this->officeId);
              $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsByOfficeId($this->officeId);
              //$data['delivery_plans']=DeliveryPlan::get_all();
              $data['delivery_status']=DeliveryPlan::GetDeliveryStatus();
            // dd(session()->get('masterOfficeId'));
             dd($data);
            return view('module.delivery_plan.delivery_details_index',$data);
        }

    }

    public function new_request(Request $request)
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $date_diff=date_diff(date_create($request->expectedDeliveryDate),date_create($request->planningDate))->format("%a");
        //dd($date_diff);
        $data['request']=[
            "ProductTypeId"=> (int)$request->productId,
            "StartingPointId"=> (int)$request->manufactureingHub,
            "MinimumMultiple"=> (double)$request->deliveryLimit,
            "TankCapacity"=> (float)$request->tankerCapacity,
            "No_of_days_for_delivery"=>(int)$date_diff,
            "DeliveryPlanId"=>0,
            "OfficeIdList"=> []
        ];
        //$DeliveryPlanId=0;
        //dd($data);
        $data['response'] = DeliveryPlan::GetDeliveryRequest($data['request']);

        $data['request']['planningDate']=$request->planningDate;
        $data['request']['expectedDeliveryDate']=$request->expectedDeliveryDate;
        //dd($data['request']);
       // $data['jsonData'] = json_encode($data['response']);
       // dd($data['jsonData'] );
       $data['planTitle']='DeliveryPlan_'.str_replace(' ','_',$request->product).'_'.$request->tankerCapacity .'_'.$request->deliveryLimit.'_'.$request->mfgHub.'_'.date_create($request->expectedDeliveryDate)->format('d-m-Y');

       $data['requestData']=$data['request'];
       //dd($data['planTitle']);
        $view=view('module.delivery_plan.delivery_plan_request',$data)->render();
        return response()->json([
            "status" => true,
            "message"=>"Request Accepted",
            "data" =>$data['response'] ,
            "html"=>$view
        ]);

    }
    public function modified_request(Request $request)
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $date_diff=date_diff(date_create($request->ExpectedDeliveryDate),date_create($request->PlanDate))->format("%a");
        // dd(json_decode($request->OfficeIdList));
        //  dd(stripslashes(implode('","', json_decode($request->OfficeIdList))));
        //  dd([implode('","', json_decode($request->OfficeIdList))]);
        // $OfficeIdList= implode('","', json_decode($request->OfficeIdList));
        // dd([$OfficeIdList]);
        $data['request']=[
            "ProductTypeId"=> (int)$request->productTypeId,
            "StartingPointId"=> (int)$request->StartingPointId,
            "MinimumMultiple"=> (double)$request->MinimumMultiple,
            "TankCapacity"=> (float)$request->TankCapacity,
            "No_of_days_for_delivery"=>(int)$request->No_of_days_for_delivery,
            "DeliveryPlanId"=>[],
            "OfficeIdList"=> json_decode($request->OfficeIdList)
        ];
         //dd(json_encode($data['request']));
        // dd($data);[implode('","', json_decode($request->OfficeIdList))]
        $data['response'] = DeliveryPlan::GetDeliveryRequest($data['request']);
        $data['request']['planningDate']=$request->planningDate;
        $data['request']['expectedDeliveryDate']=$request->expectedDeliveryDate;
        //dd($data['response']);
       // $data['jsonData'] = json_encode($data['response']);
       // dd(json_encode($data['response'] ));
       $data['planTitle']='DeliveryPlan_'.str_replace(' ','_',$request->product).'_'.$request->tankerCapacity .'_'.$request->deliveryLimit.'_'.$request->mfgHub.'_'.date_create($request->expectedDeliveryDate)->format('d-m-Y');

       $data['requestData']=$data['request'];
       //dd($data['planTitle']);
        //$view=view('module.delivery_plan.delivery_plan_request',$data)->render();
        return response()->json([
            "status" => true,
            "message"=>"Request Accepted",
            "data" =>$data['response']
        ]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user =  $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $offices = ApiController::GetOfficeList($user['officeId']);
        $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

        $data['manufacturingHubs']=DeliveryPlan::GetManufacturingHub();

        $data['products']=Product::get_all($user['officeId']);
        $data['planningDate']=date('Y-m-d');
        $data['expectedDeliveryDate']=date('Y-m-d', strtotime($data['planningDate'] . ' + 4 days'));
        $data['tankerCapacities']=[
            ['capacity'=>5000],
            ['capacity'=>10000],
            ['capacity'=>15000],
            ['capacity'=>20000]
        ];
        $data['deliveryLimits']=[
            ['limit'=>500],
            ['limit'=>1000],
            ['limit'=>1500],
            ['limit'=>2000]

        ];
        $data['planTitle']='';
        return view('module.delivery_plan.delivery_plan_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'planTitle' => 'required|max:60',
            'PlanDate' => 'required',
            'ExpectedDeliveryDate' => 'required',
            'productId' => 'required|numeric|min:1',
            'TankCapacity' => 'required|numeric|min:1',
            'MinimumMultiple' => 'required|numeric|min:1',
        ]);
        // process the data

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }
        $data=[
            'planTitle'=>base64_encode($request->planTitle),
            'planDate'=>$request->PlanDate,
            'expectedDeliveryDate'=>$request->ExpectedDeliveryDate,
            'productId'=>$request->productId,
            'startPointId'=>$request->StartingPointId,
            'containerSize'=>$request->TankCapacity,
            'deliveryLimit'=>$request->TankCapacity,
            'deliveryPlanStatusId'=>1,
            'userId'=>$user['id'],
        ];
        $newList=json_decode($request->data);
        $data['deliveryPlanDetails']=[];
        foreach($newList as $key=>$item){
            $detailsArray['deliveryPlanDetailsId']=0;
            $detailsArray['plannedQuantity']=$item->atDeliveryRequirement;
            $detailsArray['officeId']=$item->officeId;
            $detailsArray['currentQuantity']=$item->currentStock;
            $detailsArray['availableQuantity']=$item->totalCapacity-$item->currentStock;
            // $detailsArray['approveStatus']=1;
            $detailsArray['sequenceNo']=$key+1;
            array_push($data['deliveryPlanDetails'],$detailsArray);

        }


        $response = DeliveryPlan::SaveDeliveryPlan($data);
        //dd($response['message']);
        if(!$response['status']==true){
            return response()->json([
                "status" => false,
                "errors" =>[$response['message']]
            ]);
        }
       return response()->json([
            "status" => true,
            "message" => "Delivery Plan Added successfully"
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user =  $this->user;
        // $fiscalYearId = session()->has('fiscalYearId') ? session()->get('fiscalYearId') : $user['fiscalYear']['fiscalYearId'];
        $fiscalYearId = $user['fiscalYear']['fiscalYearId'];
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $this->officeId=session()->get('officeId');
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
        $data['delivery_plans']=DeliveryPlan::get_all();
         $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsByDeliveryPlanId($id);
           //dd($data['delivery_details']);
         $data['delivery_status']=DeliveryPlan::GetDeliveryStatus();
       // dd(session()->get('masterOfficeId'));
        //dd($data['delivery_details']);
       return view('module.delivery_plan.delivery_plan_view',$data);
        //dd( $data['plan']);
        /* dd($data);*/


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user =  $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $offices = ApiController::GetOfficeList($user['officeId']);
        $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

        $data['manufacturingHubs']=DeliveryPlan::GetManufacturingHub();

        $data['products']=Product::get_all($user['officeId']);
        $data['planningDate']=date('Y-m-d');
        $data['expectedDeliveryDate']=date('Y-m-d', strtotime($data['planningDate'] . ' + 4 days'));
        $data['tankerCapacities']=[
            ['capacity'=>5000],
            ['capacity'=>10000],
            ['capacity'=>15000],
            ['capacity'=>20000]
        ];
        $data['deliveryLimits']=[
            ['limit'=>500],
            ['limit'=>1000],
            ['limit'=>1500],
            ['limit'=>2000]

        ];
        $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsByDeliveryPlanId($id);
        $data['planTitle']='';
        return view('module.delivery_plan.delivery_plan_create',$data);
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
    public function update_status(Request $request,$id){
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $submit_data=[
            "deliveryPlanId"=>$request->deliveryPlanId,
            "deliveryPlanStatusId"=> $request->deliveryPlanStatusId,
            "userId"=>$user['id'],
        ];
        $response = DeliveryPlan::UpdateDeliveryPlanStatus($submit_data);

        //$GetView = view('module.delivery_plan.receive_delivery', $data)->render();
        return response()->json([
            "status" => true,
            "message" => "Status change successfully",
        ]);
    }
    public function approve_requirement($id){

        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $data['planDetails'] = DeliveryPlan::GetDeliveryPlanDetailsById($id);

        $GetView = view('module.delivery_plan.approve_requirement', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function confirm_requirement(Request $request,$id){

        if($request->approvedQuantity==null){
            $approvedQuantity=$request->plannedQuantity;

        }
        else{
            $approvedQuantity=$request->approvedQuantity;
        }
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $submitData=[
            'deliveryPlanDetailsId'=>$id,
            'approvedQuantity'=>$approvedQuantity,
            'approveStatus'=>2,
            'approvedBy'=>$user['id'],
        ];
        $response = DeliveryPlan::ApproveDeliveryPlanDetails($submitData);
        //dd($response['message']);
        if(!$response['status']==true){
            return response()->json([
                "status" => false,
                "errors" =>[$response['message']]
            ]);
        }
       return response()->json([
            "status" => true,
            "message" => "Approval done successfully"
        ]);


    }
    public function receive_delivery($id){
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $data['planDetails'] = DeliveryPlan::GetDeliveryPlanDetailsById($id);

        $GetView = view('module.delivery_plan.receive_delivery', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function status_change($id){
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $data['planDetails'] = DeliveryPlan::GetDeliveryPlan($id);
        $data['deliveryPlanStatus'] = DeliveryPlan::GetDeliveryStatus();
// dd($data['planDetails']);
        $GetView = view('module.delivery_plan.delivery_plan_status_change', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function confirm_delivery(Request $request,$id){
        if($request->receivedQuantity==null){
            $receivedQuantity=$request->approvedQuantity;

        }
        else{
            $receivedQuantity=$request->receivedQuantity;
        }
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $submitData=[
            'deliveryPlanDetailsId'=>$id,
            'receivedQuantity'=>$receivedQuantity,
            'receivedBy'=>$user['id'],
        ];
        $response = DeliveryPlan::UpdateReceiveDelivery($submitData);
        //dd($response['message']);
        if(!$response['status']==true){
            return response()->json([
                "status" => false,
                "errors" =>[$response['message']]
            ]);
        }
       return response()->json([
            "status" => true,
            "message" => "Receiving confirm successfully"
        ]);
    }
    public function delivery_filter (Request $request){
        $user =  $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        if(session()->get('masterOfficeId')==null){

            $offices = ApiController::GetOfficeList($user['officeId']);
            $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user['officeId']);

            $data['delivery_plans']=DeliveryPlan::get_all();
            $data['planningDate']=date('Y-m-d');
            $data['expectedDeliveryDate']=date('Y-m-d', strtotime($data['planningDate'] . ' + 4 days'));
            return response()->json([
                "status" => true,
                "data"=>$data,
                "message" => "List loaded successfully"
            ]);
            // return view('module.delivery_plan.delivery_plan_index',$data);
        }
        else{
            $officeId=$request->officeId;


             $fromDate = date('Y-m-d', strtotime($request->fromDate));
             $toDate = date('Y-m-d', strtotime($request->toDate));
            //  $fromDate=$request->fromDate;
            //dd($fromDate);
            //  $toDate=$request->toDate;
            // $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($this->officeId);
              $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsFilter($officeId,$fromDate,$toDate);
             // $data['delivery_status']=DeliveryPlan::GetDeliveryStatus();
            // dd(session()->get('masterOfficeId'));
            return response()->json([
                "status" => true,
                "data"=>$data,
                "message" => "List loaded successfully"
            ]);
            //return view('module.delivery_plan.delivery_details_index',$data);
        }
    }
    public function delivery_details_filter(Request $request){
        $user =  $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $officeId=$request->officeId;
        //dd($request->all());

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
       //  $fromDate=$request->fromDate;
        //dd($officeId);
       //  $toDate=$request->toDate;
       // $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($this->officeId);
       if($officeId==null){
        // $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsByDeliveryPlanId($deliveryPlanId);
        $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsFilter('all',$fromDate,$toDate);
        // dd($data['delivery_details']);
       }
       else{
        $data['delivery_details']=DeliveryPlan::GetDeliveryPlanDetailsFilter($officeId,$fromDate,$toDate);
       }

        // $data['delivery_status']=DeliveryPlan::GetDeliveryStatus();
       // dd(session()->get('masterOfficeId'));
      // dd($data);
       return response()->json([
           "status" => true,
           "data"=>$data,
           "message" => "List loaded successfully"
       ]);
    }
    public function reject($id){

        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $submitData=[
            'deliveryPlanDetailsId'=>$id,
            'approvedQuantity'=>0,
            'approveStatus'=>-1,
            'approvedBy'=>$user['id'],
        ];
        $response = DeliveryPlan::ApproveDeliveryPlanDetails($submitData);
        //dd($response['message']);
        if(!$response['status']==true){
            return response()->json([
                "status" => false,
                "errors" =>[$response['message']]
            ]);
        }
       return response()->json([
            "status" => true,
            "message" => "Rejection done successfully"
        ]);
    }
}
