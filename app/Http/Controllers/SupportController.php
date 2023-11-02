<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Services\SupportService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class SupportController extends Controller
{
    public static $ActiveStatus = [
        "Active" => "1",
        "InActive" => "0"
    ];

    protected $routeRole='pumpadmin';
    protected $roleName='pumpadmin';
    protected $user=null;
    protected $limit = 10;
    protected $roles;
    // protected $supportService;

    public function __construct()
    {
        // $this->supportService =  $supportService;
        $this->limit = 10;
        // $roles=ApiController::GetRoles();
        $roles = session()->has('roles')? Helper::jsonDE(session()->get('roles')): session()->put('roles',ApiController::GetRoles());

        $del_val=["SuperAdmin" ];
        if($roles){
            foreach ($roles as $key => $value) {
                if (!in_array($value['name'], $del_val)) {
                    $this->roles[$value['name']] = $value['name'];
                }
            }
        }
        $user=   session()->has('userData')?Helper::jsonDE(session()->get('userData') ):ApiController::user(session()->get('loginid'));
        $roleName=session()->get('roleName');

        $this->user=Helper::jsonDE($user);
       $this->roleName=session()->get('roleName');
        $this->routeRole= str_replace(' ','_',strtolower($this->roleName));
    }



    public function SupportList()
    {
       // dd(Session::get('loginid'));
       $createdBy = $this->roleName  == 'superadmin' ? 'All' : Session::get('loginid') ;
       //dd($this->roleName);
       // $json_call_data=['CreatedBy'=>Session::get('loginid')];
       $data['roleName']=$this->roleName;
       $data['routeRole']=$this->routeRole;
        $data['allData'] = ApiController::ListOfSupport($createdBy);
        // $data['allData'] = $this->supportService->SupportList();

        //  dd($data['allData']);

        return view('support.support-list',$data);
    }
    public function SupportCreate()
    {
        $data['roleName']=$this->roleName;
        $data['routeRole']=$this->routeRole;
        // dd($data['allData']);
        $html= view('support.support_create',$data)->render() ;
        return response()->json([
            "status" => true,
            "html" => $html
        ]);
    }
    public function SupportAdd(Request $request)
    {


        $data=$request->get('param');

        // $decrypt_data 						= openssl_decrypt($data,"AES-128-ECB",md5(env('ENC_SALT')));
		// $elmData['allData']						= (!empty($decrypt_data))?json_decode($decrypt_data, true):array();
		$elmData['allData']						= json_decode(base64_decode($data),true);
        //dd($elmData['allData']);
        $elmData['ActiveStatus'] = self::$ActiveStatus;
        $SupportID = $elmData['allData']['supportId'];


        return response()->json([
            "status" => true,
            "html" => $this->GetChatView($SupportID,$elmData)
        ]);
    }
    private function GetChatView($SupportID,$elmData){
        $info['title']="Support [add/modify]";
        $info['size']="modal-lg";


        $elmData['SupportDetails'] = ApiController::SupportDetailsBySupportID($SupportID);
        //dd($elmData['SupportDetails']);
        if(empty($elmData['allData'])){
            $elmData['allData'] = ApiController::SupportDetailsBySupportID($SupportID);
        }
        $allData['supportId']=$elmData['SupportDetails'][0]['supportId'];
        $allData['title']=$elmData['SupportDetails'][0]['title'];
        $allData['createdBy']=  $elmData['SupportDetails'][0]['createdBy'];
        $allData['createdOn']=$elmData['SupportDetails'][0]['createdOn'];
        $allData['lastModifyOn']=$elmData['SupportDetails'][0]['createdOn'];
        $allData['chatCount']=count($elmData['SupportDetails'][0]['supportDetails']);
        $allData['readStatus']=0;
        if($this->roleName=='superadmin'){
            $elmData['readStatus']= $elmData['SupportDetails'][0]['isAdminRead'];
        }

        $allData['userDetails']=$elmData['SupportDetails'][0]['userDetails'];


        // dd($elmData['SupportDetails'][0]['supportDetails']==null?'true':'false');
        $elmData['info']=$info;
        $elmData['chatCount']=0;
        $elmData['lastModifyOn']=date('Y-m-d H:i:s');
        $elmData['readStatus']=0;
        if($elmData['SupportDetails'][0]['supportDetails']!=null)
        {
            usort($elmData['SupportDetails'][0]['supportDetails'], function($a, $b) {
                return strtotime($b['sendTime']) - strtotime($a['sendTime']);
            });


            $elmData['info']=$info;
            $elmData['chatCount']=count($elmData['SupportDetails'][0]['supportDetails']);
            $elmData['lastModifyOn']=$elmData['SupportDetails'][0]['supportDetails'][0]['sendTime'];
            if($this->roleName=='superadmin'){
                $elmData['readStatus']= $elmData['SupportDetails'][0]['isAdminRead'];
            }
        }

       $elmData['allData']=$allData;
        return view('support.add-support',$elmData)->render();
    }
    public function  SupportStore(Request $request )
    {
        $validator=Validator::make($request->all(),[
            'title' => 'required|max:40|min:3',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors()->first()
            ]);
        }
        $data['title']=base64_encode($request->title);
        $data['createdBy']= Session::get('loginid');

        $response=ApiController::CreateSupport($data);
        // dd($response);
        if($response['status'])
        {

            return response()->json([
                "status" => true,
                "message" => "New Ticket Created",
                "html" => $this->GetChatView($response['id'],[])
            ]);
        }
       else{
        return response()->json([
            "status" => false,
            "html" => "message not sent"
        ]);
       }

    }
    public function SupportDetailsStore(Request $request )
    {

        $data['supportId']= $request->supportId;
        $data['bodyText']= base64_encode($request->bodyText) ;
        $data['sendBy']= Session::get('loginid');
        $data['documentId']="";

        if($request->Attachment!=null){
            $documentData=["CreatedBy"=>Session::get('loginid'),
            "lstFiles"=>$request->Attachment,
            "ModuleId"=>"4"];
            $documentResponse=ApiController::UploadDocument($documentData);
            if($documentResponse->status()==200){
                $data['documentId']=$documentResponse->json()[0];
            }

        }

        $response=ApiController::PostInTicket($data);
        // dd($response);
        if($response['status'])
        {
           // return $this->ChatBody($request->SupportID);
            return response()->json([
                "status" => true,
                "html" => "Thank you for your support"
            ]);
        }
       else{
        return response()->json([
            "status" => false,
            "html" => "message not sent"
        ]);
       }

    }
    public function changeReadStatus($data):void
    {

        $response=ApiController::ChangeReadStatus($data);
        //dd($response);
    }
    public function ChatBody($supportId){
        $sendBy=Session::get('loginid');
        $data['supportId']=$supportId;
        $data['sendBy']=$sendBy;
        $this->changeReadStatus($data);
        // dd($supportId);
        // $json_call_data=['SupportID'=>$request->SupportID];
        $SupportDetails= ApiController::SupportDetailsBySupportID($supportId);

        $elmData['chatCount']=0;
        $elmData['lastModifyOn']=date('Y-m-d H:i:s');
        $elmData['readStatus']=true;
        //sort by date desc
        if($SupportDetails[0]['supportDetails']!=null)
        {


            usort($SupportDetails[0]['supportDetails'], function($a, $b) {

                return strtotime($b['sendTime']) - strtotime($a['sendTime']);
            });
            $elmData['SupportDetails']=collect($SupportDetails);
           // $elmData['SupportDetails'][0]['supportDetails']=$SupportDetails[0]['supportDetails'];
            //    dd($b);
            //dd($SupportDetails[0]['supportDetails']);
            $elmData['chatCount']=count($elmData['SupportDetails'][0]['supportDetails']);
            $elmData['lastModifyOn']=$elmData['SupportDetails'][0]['supportDetails'][0]['sendTime'];

            $elmData['readStatus']=$elmData['SupportDetails'][0]['isAdminRead'];
            if(strtolower($this->roleName)=='superadmin'){
                $elmData['readStatus']= $elmData['SupportDetails'][0]['isUserRead'];
               // dd($elmData['readStatus']);
            }

        }




        //dd($elmData['SupportDetails']);
        $GetView= view('support.chat_body',$elmData)->render();
        // dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView,
            "chatCount" => $elmData['chatCount'],
            "lastModifyOn" => $elmData['lastModifyOn'],
            "readStatus" => $elmData['readStatus']
        ]);
    }
}
