<?php
namespace App\Repositories;

use session;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\SupportRepositoryInterface;

class SupportRepository   implements SupportRepositoryInterface
{

    public static $ActiveStatus = [
        "Active" => "1",
        "InActive" => "0"
    ];
    protected $roleName;
    // protected $apiController;
    function __construct()
    {
        // $this->apiController =  $apiController;
        $this->limit = 10;
        $this->roleName = session()->get('roleName');
    }

    public function SupportList():array
    {

       $createdBy = $this->roleName  == 'superadmin' ? 'All' : session()->get('loginid') ;

        return ApiController::ListOfSupport($createdBy);

    }
    public function SupportAdd(Request $request):array
    {
        $info['title']="Support [add/modify]";
        $info['size']="modal-lg";

        $data=$request->get('param');
        // $decrypt_data 						= openssl_decrypt($data,"AES-128-ECB",md5(env('ENC_SALT')));
        // $elmData['allData']						= (!empty($decrypt_data))?json_decode($decrypt_data, true):array();
        $elmData['allData']						= json_decode(base64_decode($data),true);

        $elmData['ActiveStatus'] = self::$ActiveStatus;
        $SupportID = $elmData['allData']['supportId'];
        // $json_call_data=['SupportID'=>$SupportID];
        $elmData['SupportDetails'] = ApiController::SupportDetailsBySupportID($SupportID);

        $elmData['info']=$info;
       // dd($elmData);
        $GetView= view('support.add-support',$elmData)->render();
        //return $GetView;
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
    }
    public function SupportStore(Request $request ):array
    {
        $data['title']=base64_encode($request->title);
        $data['createdBy']= session()->get('loginid');

         $response=ApiController::CreateSupport($data);
        $data['SupportID']= $request->SupportID;
        $data['BodyText']= $request->BodyText ;
        $data['SendBy']=session()->get('loginid');
       // dd(json_decode(json_encode(session()->get('userData')),true));
        $user=json_decode(json_encode(session()->get('userData')),true);
        //dd($user['roleName']);
        $data['SenderUserType']= $user['roleName'];

       $Attachment= $request->Attachment==null? null:fopen($request->Attachment, 'r');
        // $Attachment= $request->Attachment==null ? null:fopen($request->Attachment, 'r');

        $response=ApiController::PostInTicket($data,$Attachment);
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

    public function ChatBody(Request $request):array{
        //dd($SupportID);
        $json_call_data=['SupportID'=>$request->SupportID];
        $elmData['SupportDetails']= ApiController::SupportDetailsBySupportID($json_call_data)['response'];
        //dd($SupportDetails);
        $GetView= view('support.chat_body',$elmData)->render();
        // dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
    }
}
