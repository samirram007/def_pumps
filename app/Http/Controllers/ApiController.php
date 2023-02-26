<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class ApiController extends Controller
{
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token')?Session::get('_token'):'';
    }
    public static function  SignInWithMobile($data)
     {
       // dd($data);
        $loginData = [
                "contactNumber"=> $data['contactNumber'],
                "deviceType"=> "web",
                "pushId"=> ""

        ];
       // dd(json_encode($loginData));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json",];

        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/SignInWithMobile', $loginData)->json();
        //dd($res);
        return $res;
     }
    public static function  SignIn($data)
     {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/SignIn', $data)->json();
        return $res;
     }
    public static function  User($id,$header_token="")
    {
        $header_token=$header_token==''? Session::get('_token'):$header_token;

        $headers = ["Authorization" => "Bearer " . $header_token, "Accept" => "*",];

        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/User/'.$id)->json();

        return $res;
     }

    public static function  GetAddressList($param)
    {
       // dd($param);
        $url='https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$param.'&key=AIzaSyCiHsfkp8gd570k6bI8t83jpYN5BUcKPRM';

        $res = Http::get($url);
        return $res;

    }
    public static function  getUserListAdmin($id)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/UserListByAdmin/'.$id)->json();
        return $res;
     }
    public static function  UserByRole($roleName)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/Users/'.$roleName)->json();
        return $res;
     }
    public static function  GetRoles()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/GetRoles')->json();
        return $res;
     }
    public static function  getUsers()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/Users')->json();
        return $res;
    }
    ///api/Auth/EmailExistCheck/{email}
    public static function  EmailExistCheck($email)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/EmailExistCheck/'.$email)->json();
        return $res;
    }
    ///api/Auth/UserNameCheck/{userName}
    public static function  UserNameCheck($userName)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/UserNameCheck/'.$userName)->json();
        return $res;
    }
    ///api/Auth/ContactNoExistCheck/{contactNo}
    public static function  ContactNoExistCheck($contactNo)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/ContactNoExistCheck/'.$contactNo)->json();
        return $res;
    }
    ///api/Auth/ResendOTP
    public static function  ResendOTP($contactNumber)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/ResendOTP',$contactNumber)->json();
        return $res;
    }
    public static function createUser($data)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/CreateUser', $data);
        return $res;
    }
    public static function updateUser($data)
    {
       // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/UpdateUser', $data);
        return $res;
    }
    public static function deleteUser($id,$deletedBy)
    {
        //  dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/DeleteUser/'.$id.'/'.$deletedBy);
        //dd($res);
        return $res;
    }
    ///api/Auth/UserListByEmployeeId [POST [{  "userId": "string",  "roleName": "string",   "officeId": "string" }]]
    public static function  UserListByEmployeeId($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/UserListByEmployeeId',$data)->json();
        return $res;
    }
    ///api/Auth/ResetPassword
    public static function  ResetPassword($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/ResetPassword', $data)->json();
        return $res;
    }
    ///api/Auth/ChangePassword
    public static function  ChangePassword($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/ChangePassword', $data)->json();
        return $res;
    }
    ///api/Auth/RefreshToken post { { "jwtToken": "string", "refreshToken": "string" }}
    public static function  RefreshToken($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/RefreshToken',$data)->json();
        return $res;
    }
    public static function  GetMasterOfficeList()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/GetMasterOfficeList')->json();
         return $res;
     }
     public static function  GetOfficeAll()
     {
         $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
         $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/GetOfficeList')->json();
          return $res;
      }
    public static function  GetOfficeList($id)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/GetOfficeByMasterOfficeId/'.$id)->json();
         return $res;
     }
     public static function  GetOfficeListWithInvoiceNo($officeId,$fiscalYearId)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/GetOfficeWithInvoiceNoByMasterOfficeIdFiscalYearId/'.$officeId.'/'.$fiscalYearId)->json();
         return $res;
     }


     public static function  GetOfficeDownline($officeId,$level=-1)
     {
         $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
         $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/OfficeDownlineById/'.$officeId.'/'.$level)->json();
          return $res;
      }
     public static function  GetOfficeDropdown($officeId,$level=-1)
     {

         $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
         $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/OfficeDropdownList/'.$officeId.'/'.$level)->json();
          return $res;
      }
    public static function  GetOffice($id,$header_token="")
    {
        $header_token=$header_token==''? Session::get('_token'):$header_token;

        $headers = ["Authorization" => "Bearer " . $header_token, "Accept" => "*",];
        // $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/GetOfficeById/'.$id)->json();
        return $res;
    }
    public static function  CreateOffice($data)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Office/SaveOffice/',$data) ;

        return $res;
    }
    public static function  UpdateOffice($data)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Office/UpdateOffice',$data);
        return $res;

    }

    //======== for admin ===========
    public static function  GetOfficeByMasterOfficeId($id)
    {

        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/GetOfficeByMasterOfficeId/'.$id)->json();
        //dd($res);
        return $res;
    }



    public static function  DeleteOffice($id)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/DeleteOffice/'.$id)->json();
        return $res;
    }
    //====== OfficeType =============
    public static function  GetOfficeTypeList()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/GetOfficeTypeList')->json();
        return $res;
    }
    //========== Feature Type ==============
    public static function  GetFeatureTypeList()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'FeatureType/GetFeatureTypeList')->json();
        return $res;
    }
    //========== Gst Type ==============
    public static function  GetGstTypeList()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'GstType')->json();
        return $res;
    }
    public static function  GetGstTypeById($id)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'GstType/'.$id)->json();
        return $res;
    }

    //========== OfficeFeatureMapper ==============
    public static function  GetOfficeFeatureMapperList($id)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'OfficeFeatureMapper/OfficeFeatureMapperByOfficeId/'.$id)->json();
        return $res;
    }
    public static function  ToggleOfficeFeatureMapper($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'OfficeFeatureMapper/ToggleOfficeFeatureMapper',$data) ;
        //dd($res->status());
        return $res;
    }
    //================================== Report ===================================
    public static function  GetTaskReport($data)
    {

        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Report/GetTaskReport/'.$data['officeId'].'/'.$data['fromDate'].'/'.$data['toDate'])->json();

        return $res;
    }
    public static function  AdminDashboradData($officeId,$isAdmin)
    {
        // dd($userId);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Dashboard/AdminDashboradData/'.$officeId.'/'.$isAdmin)->json();

        return $res;
    }


    //================================== Project ===================================
    public static function  GetProjectList($id)
    {
        //dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Projects/GetProjectListByUser/'.$id)->json();

        return $res;
    }
    public static function  GetProjectList_Admin($id)
    {
        //dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Projects/GetProjectListByAdmin/'.$id)->json();

        return $res;
    }
    public static function  GetProjectById($id)
    {
        //dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Projects/GetProjectById/'.$id)->json();

        return $res;
    }
    public static function  CreateProject($data)
    {
       // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Projects/SaveProjectDetails',$data)->json();
        return $res;
    }

    public static function  SaveDocumentResource($lstFiles,$saveDocumentResourc)
    {
        if($lstFiles != null)
        {
          dd($saveDocumentResourc);
            $headers = ["Authorization" => "Bearer " . Session::get('_token') , "Accept" => "multipart/form-data",
            "Content-Type" => "multipart/form-data; boundary=<calculated when request is sent>;  ",
            "Content-Disposition" => "form-data; name=lstFiles; filename=lstFiles; ",
            "Content-Transfer-Encoding" => "binary",
            "Content-Length" => "<calculated when request is sent>",
            "Connection" => "Keep-Alive",
            "Host" => "<calculated when request is sent>",
            "Cache-Control" => "no-cache",
            ];
            $res = Http::withHeaders($headers)
            ->attach('lstFiles', $lstFiles)
            ->post(env('API_RESOURCE_URL') . 'Document/UploadDocument',$saveDocumentResourc)->json();
            //dd($res);
            return $res;
        }
    }

//==================== Sales ==============================

public static function  GetSalesIndex()
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Sales')->json();
        return $res;
    }
public static function  GetSalesIndexByDateOffice($fromDate,$toDate,$officeId,$status=null)
    {
        //dd($fromDate);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        if($status == null){
            $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Sales/GetByDateRangeOffice/'.$fromDate.'/'.$toDate.'/'.$officeId)->json();
        }
        else{
            $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Sales/GetByDateRangeOfficeStatus/'.$fromDate.'/'.$toDate.'/'.$officeId.'/'.$status)->json();
        }


        return $res;
    }
public static function  GetExpenseIndexByDateOffice($fromDate,$toDate,$officeId)
    {
        //dd($fromDate);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Expense/GetByDateRangeOffice/'.$fromDate.'/'.$toDate.'/'.$officeId)->json();
        //dd($res);
        return $res;
    }
public static function  CreateSales($data)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Sales/Store',$data);
        return $res;
    }
public static function  GetSalesById($salesId)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Sales/'.$salesId)->json();
        return $res;
    }
public static function  UpdateSales($data)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Sales/Update',$data);
        return $res;
    }
public static function  UpdateSalesStatus($data)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Sales/UpdateStatus',$data);
        return $res;
    }
public static function  DeleteSales($id,$userId)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->delete(env('API_RESOURCE_URL') . 'Sales/'.$id.'/'.$userId);

        return $res;
    }
public static function  CreateExpense($data)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Expense/Store',$data);
        return $res;
    }
    public static function  UpdateExpense($data)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Expense/Update',$data);
        return $res;
    }
public static function  DeleteExpense($id,$userId)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->delete(env('API_RESOURCE_URL') . 'Expense/'.$id.'/'.$userId);
        return $res;
    }


    public static function  GetExpenseIndex()
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Expense')->json();
        return $res;
    }
    public static function  GetExpenseById($id)
    {

        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Expense/'.$id)->json();
        return $res;
    }
public static function  GetProductType($officeId)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'ProductType/'.$officeId)->json();
        return $res;
    }
public static function  saveProductType($data)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'ProductType',$data)->json();
        return $res;
    }
public static function  updateProductType($data)
    {
//dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'ProductType/Update',$data)->json();
        return $res;
    }
    public static function  GetProductTypeWithRate($id,$date=null)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $date=!$date==null?date('Y-m-d',strtotime($date)):date('Y-m-d');
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'ProductType/GetProductTypeWithRate/'.$id.'/'.$date)->json();
        //dd($res);
        return $res;
    }
public static function  GetProductByOrgId($id)
    {
        // dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'ProductType/'.$id)->json();
        // dd($res);
        return $res;
    }
    public static function  GetLatestPriceByOfficeId($id)
    {
        // dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'FuelRate/GetFuelDetailsByOfficeId/'.$id)->json();
        // dd($res);
        return $res;
    }
    public static function  UpdateLatestPrice($data)
    {
        // dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'FuelRate/SaveFuelDetails',$data)->json();
       // dd($res);
        return $res;
    }
    public static function  GetCurrentStockByOfficeId($id)
    {
        // dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Stock/GetCurrentStockByOfficeId/'.$id)->json();
        // dd($res);
        return $res;
    }
    public static function  UpdateCurrentStock($data)
    {
        // dd($id);
      //  dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Stock/SaveCurrentStock',$data)->json();
        // dd($res);
        return $res;
    }
    public static function   AddOfficeLastInvoiceDetails($data)
    {
       // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'OrganizationInvoice/AddOfficeDetails',$data)->json();
         //dd($res);
        return $res;
    }
    public static function  GetProductTypeById($id)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'ProductType/'.$id)->json();
        return $res;
    }
    public static function  GetPaymentMode()
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'PaymentMode/GetPaymentModeList')->json();
        return $res;
    }
public static function  GetFuelRate($id)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'FuelRate/'.$id)->json();

        return $res;
    }
public static function  DEFDashBoardGraphData($param_str)
    {

        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Dashboard/DEFDashBoardGraphData/'.$param_str)->json();

        return $res;
    }

    //Support
    public static function CreateSupport($data)
     {
          $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json",];
          $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Support/CreateSupport', $data)->json();
          return $res;
     }
     public static function PostInTicket($data)
     {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];

        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Support/PostInTicket', $data)->json();

        return $res;

        //   if($Attachment==null){
        //        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];

        //          $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Support/PostInTicketNoAttachment', $data)->json();

        //   return $res;
        //   }
        //   else{
        //        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "multipart/form-data"];
        //        $res = Http::withHeaders($headers)->attach('Attachment', $Attachment)
        //        ->post(env('API_RESOURCE_URL') . 'Support/PostInTicket', $data)->json();
        //        return $res;
        //   }

     }
     public static function  UploadDocument($documentData)
     {
         if($documentData != null)
         {
              // dd($documentData);
           $saveDocumentResourc = json_encode(["CreatedBy"=>$documentData['CreatedBy'],"ModuleId"=>$documentData['ModuleId']]);
           $data=['saveDocumentResourc'=>$saveDocumentResourc];
           //dd($saveDocumentResourc);
             // $headers = ["Authorization" => "Bearer " . Session::get('_token') , "Accept" => "multipart/form-data",
             // "Content-Type" => "multipart/form-data; boundary=<calculated when request is sent>;  ",
             // "Content-Disposition" => "form-data; name=lstFiles; filename=lstFiles; ",
             // "Content-Transfer-Encoding" => "binary",
             // "Content-Length" => "<calculated when request is sent>",
             // "Connection" => "Keep-Alive",
             // "Host" => "<calculated when request is sent>",
             // "Cache-Control" => "no-cache",
             // ];

              $file = $documentData['lstFiles'];
              $mimeType = $file->getMimeType();
              $file_path = $file->getRealPath();

            $headers= ["Authorization" => "Bearer " . Session::get('_token') , "Accept" => "multipart/form-data", ];

             $res = Http::withHeaders($headers)
             ->attach('lstFiles', fopen($file_path, 'r'), $file->getClientOriginalName(), ['Content-Type' => $mimeType])
             ->post(env('API_RESOURCE_URL') . 'Document/UploadDocument',$data);

             return $res;
         }
     }
     public static function SupportTicketReadStatus($data)
     {
          $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json",];
          $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Support/SupportTicketReadStatus', $data)->json();
          return $res;
     }
     public static function ListOfSupport($createdBy)
     {
          $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json",];
          $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Support/ListOfSupport/'.$createdBy)->json();
          return $res;
     }
     public static function SupportDetailsBySupportID($SupportID)
     {
          $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json",];
          $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Support/SupportDetailsBySupportID/'. $SupportID)->json();
          return $res;
     }
     public static function ChangeReadStatus($data)
     {
        // dd(json_encode($data));
          $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json",];
          $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Support/SupportTicketReadStatus', $data)->json();
         // dd($res);
          return $res;

     }

}
