<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected $roles;
    protected $months = [
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];
    protected $years = [
        '2022' => '2022',
        '2023' => '2023',
    ];
    public function __construct()
    {

       // $roles = ApiController::GetRoles();
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());
        $del_val = ['SuperAdmin'];
       if($roles){
         foreach ($roles as $key => $value) {
            if (!in_array($value['name'], $del_val)) {
                $this->roles[$value['name']] = $value['name'];
            }
        }
       }

    }
    public function welcome()
    {
        //   dd('welcome');
        return view('welcome');
    }
    public function CheckDashboard()
    {
        $userData = session()->has('loginid') ? (object) ApiController::User(session()->get('loginid')) : '';
        //   dd($userData);
        $userData->roleName = strtolower($userData->roleName);
        // dd($userData->roleName);
        if (in_array($userData->roleName, ['superadmin', 'SuperAdmin'])) {
            return \redirect ()->route('superadmin.dashboard');
        } else if (in_array($userData->roleName, ['companyadmin', 'CompanyAdmin'])) {
            return \redirect ()->route('companyadmin.dashboard');
        } else if (in_array($userData->roleName, ['pumpadmin', 'Pump Admin'])) {

            return \redirect ()->route('pumpadmin.dashboard');
        }

    }
    public function SignInWithMobile(Request $request)
    {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->get('recaptcha'),
            'remoteip' => $remoteip,
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        //  dd($options);
        $context = stream_context_create($options);

        $result = file_get_contents($url, false, $context);
        //dd($result);
        $resultJson = json_decode($result);

        if ($resultJson->success != true) {
            session()->flash('message', 'ReCaptcha Error');
            session()->flash('alert-class', 'alert-danger');
            return response()->json(['success' => false, 'message' => 'ReCaptcha Error']);
            //return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }

        if ($resultJson->score >= 0.3) {
            $data = $request->all();
            // dd($data['otp']);
            if ($data['otp'] == null) {
                $res = User::SignInWithMobile($data);
                // dd($res);
                if ($res['status']) {

                    $token = $res['loginToken']['jwtToken'];

                    // dd($token);
                    $tokenParts = explode(".", $token);

                    $tokenHeader = base64_decode($tokenParts[0]);
                    $tokenPayload = base64_decode($tokenParts[1]);
                    $jwtHeader = json_decode($tokenHeader);
                    $jwtPayload = json_decode($tokenPayload);

                    $userId = $jwtPayload->sub;
                    $expire = $jwtPayload->exp;
                    env('JWT_EXPIRATION_TIME', $expire);
                    session()->put('jwt_token', $token);
                    $userData = (object) ApiController::User($userId, $token);

                    if ($userData != null) {

                        session()->put('tmp_res', $res);
                        return response()->json(
                            [
                                'status' => 'success',
                                'message' => 'Login Successfully',
                                'otp' => base64_encode($res['otp']),
                                'data' => $userData,
                            ]);
                    } else {
                        return response()->json(['status' => 'error', 'message' => 'Invalid Credentials']);
                    }
                    // return redirect()->route('welcome');
                } else {

                    return response()->json(['success' => false, 'status' => 'error', 'message' => 'Invalid Credentials']);

                    //return redirect()->route('login')->with('fail', 'Invalid username or password');
                }

            } else {
                // $input_otp=base64_decode($request->get('otp'));
                $res = session()->get('tmp_res');

                if ($res['status']) {

                    // Add masterotp here base64_decode(668822)
                    $token = $res['loginToken']['jwtToken'];

                    // dd($token);
                    $tokenParts = explode(".", $token);

                    $tokenHeader = base64_decode($tokenParts[0]);
                    $tokenPayload = base64_decode($tokenParts[1]);
                    $jwtHeader = json_decode($tokenHeader);
                    $jwtPayload = json_decode($tokenPayload);

                    $userId = $jwtPayload->sub;
                    // dd($userId);

                    $expire = $jwtPayload->exp;
                    env('JWT_EXPIRATION_TIME', $expire);
                    $userData = (object) ApiController::User($userId, $token);
                    //dd($userData);
                    if ($userData != null) {
                        // dd($userData);
                        session()->put('userData', $userData);
                        session()->put('loginid', $userId);
                        $userData->roleName = strtolower($userData->roleName);
                        session()->put('roleName', $userData->roleName);
                        session()->put('routeRole', str_replace(' ', '_', strtolower($userData->roleName)));

                        session()->put('fiscalYearId', $userData->fiscalYear['fiscalYearId']);

                        session()->put('fiscalYearData', $userData->fiscalYear);
                        foreach ($userData->features as $feature) {
                            session()->put($feature['featureType'], $feature['isActive']);

                        }

                        if (!in_array($userData->roleName, ['SuperAdmin', 'superadmin', 'Superadmin', 'superAdmin'])) {
                            session()->put('isSuperAdmin', false);
                            session()->put('officeId', $userData->officeId);
                            $office = [ApiController::GetOffice($userData->officeId, $token)];
                            session()->put('officeData', $office);
                            session()->put('officeName', $userData->officeName);
                            // dd($office);
                            session()->put('masterOfficeId', $office[0]['masterOfficeId']);

                        } else {
                            session()->put('isSuperAdmin', true);
                            session()->put('superAdminId', $userId);

                        }
                        //dd(session()->get('superAdminId'));
                        // session()->put('Language', $userData->features['featureTypeId']);

                        session()->put('_token', $token);
                        session()->put('_refreshtoken', $res['loginToken']['refreshToken']);
                        if (session()->has('tmp_res')) {
                            session()->forget('tmp_res');
                        }

                        return response()->json(
                            [
                                'status' => 'success',
                                'message' => 'Login Successfully',
                                'data' => $userData,
                            ]);
                    } else {
                        return response()->json(['status' => 'error', 'message' => 'Invalid Credentials']);
                    }
                }

                // return redirect()->route('
            }

        } else {
            session()->flash('message', 'ReCaptcha Error');
            session()->flash('alert-class', 'alert-danger');
            return response()->json(['status' => 'error', 'message' => 'ReCaptcha Error']);
            // return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }

    }
    public function switchmode($userId = 'none')
    {

        if ($userId == 'none') {

            $sessionUserIds = session()->get('sessionUserIds');

            $userId = $sessionUserIds[count($sessionUserIds) - 1];
            $userData = (object) ApiController::User($userId);
            foreach ($sessionUserIds as $key => $value) {
                if ($value == $userId) {
                    unset($sessionUserIds[$key]);
                }
            }
            $sessionUserIds = array_values($sessionUserIds);
            session()->put('sessionUserIds', $sessionUserIds);
            // $userId = session()->get('previousUserId');
        } else {
            if(session()->has('users') ){
                 session()->forget('users');
            }
            $sessionUserIds = session()->get('sessionUserIds');

            $currentUserId = session()->get('loginid');
            if ($sessionUserIds == null) {
                $sessionUserIds = [];
            }
            if (session()->get('loginid') != $userId) {

                if (!in_array($currentUserId, $sessionUserIds)) {
                    array_push($sessionUserIds, $currentUserId);
                }
                $sessionUserIds = array_values($sessionUserIds);
                session()->put('sessionUserIds', $sessionUserIds);
            }
            $userData = (object) ApiController::User($userId);

        }

        if ($userData != null) {
            // dd($userData);
            //session()->put('previousUserId', $currentUserId);
            session()->put('userData', $userData);
            session()->put('loginid', $userId);
            $userData->roleName = strtolower($userData->roleName);
            session()->put('roleName', $userData->roleName);
            session()->put('routeRole', str_replace(' ', '_', strtolower($userData->roleName)));

            session()->put('fiscalYearId', $userData->fiscalYear['fiscalYearId']);

            session()->put('fiscalYearData', $userData->fiscalYear);
            foreach ($userData->features as $feature) {
                session()->put($feature['featureType'], $feature['isActive']);

            }

            if (!in_array($userData->roleName, ['SuperAdmin', 'superadmin', 'Superadmin', 'superAdmin'])) {
                session()->put('isSuperAdmin', true);
                session()->put('officeId', $userData->officeId);
                $office = [ApiController::GetOffice($userData->officeId)];
                session()->put('officeData', $office);
                session()->put('officeName', $userData->officeName);
                // dd($office);
                session()->put('masterOfficeId', $office[0]['masterOfficeId']);
                //dd($userData->roleName);

            } else {
                session()->put('isSuperAdmin', true);

            }

            // session()->put('Language', $userData->features['featureTypeId']);

            // session()->put('_token', $token);
            // session()->put('_refreshtoken', $res['loginToken']['refreshToken']);
            // if (session()->has('tmp_res')) {
            //     session()->forget('tmp_res');
            // }

            return redirect('/');
        }

        return redirect('/');

    }
    public function SignIn(Request $request)
    {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->get('recaptcha'),
            'remoteip' => $remoteip,
        ];
        // dd($data);
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);
        if ($resultJson->success != true) {
            session()->flash('message', 'ReCaptcha Error');
            session()->flash('alert-class', 'alert-danger');
            return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }
        if ($resultJson->score >= 0.3) {
            $data = $request->all();

            $res = User::SignIn($data);

            if (!empty($res['jwtToken'])) {
                $token = $res['jwtToken'];

                $tokenParts = explode(".", $token);

                $tokenHeader = base64_decode($tokenParts[0]);
                $tokenPayload = base64_decode($tokenParts[1]);
                $jwtHeader = json_decode($tokenHeader);
                $jwtPayload = json_decode($tokenPayload);

                $userId = $jwtPayload->sub;
                // dd($userId);
                $expire = $jwtPayload->exp;
                env('JWT_EXPIRATION_TIME', $expire);
                $userData = (object) ApiController::User($userId);
                // dd($userData);

                if (strtolower($userData->roleName) == 'superadmin') {
                    session()->put('loginid', $userId);
                    session()->put('_token', $token);
                    session()->put('_refreshtoken', $res['refreshToken']);
                    return redirect()->route('superadmin.dashboard');
                }

                return redirect()->route('welcome');
            } else {

                return redirect()->route('login')->with('fail', 'Invalid username or password');
            }
        } else {
            session()->flash('message', 'ReCaptcha Error');
            session()->flash('alert-class', 'alert-danger');
            return back()->withErrors(['captcha' => 'ReCaptcha Error']);
        }

    }

    public function login()
    {
        return view('auth.login');
    }
    public function logout()
    {

        session()->flush();

        Auth::logout();

        return Redirect::back();
        //->with('message', 'Operation Successful !');
    }
    public function dashboard()
    {

        $userData = session()->has('loginid') ? ApiController::User(session()->get('loginid')) : '';
        //dd($userData);
        $userData = (object) $userData;

        session()->put('fiscalYearId', $userData->fiscalYear['fiscalYearId']);
        //  dd($userData->fiscalYear['fiscalYearId']);
        $userData->roleName = strtolower($userData->roleName);
        $data['roleName'] = session()->get('roleName');
        $data['routeRole'] = session()->get('roleName');
        //dd($userData->roleName);

        if (in_array($userData->roleName, ['superadmin', 'SuperAdmin'])) {
            return view('superadmin.dashboard', $data);
        } else if ($userData->roleName == 'companyadmin') {
            session()->put('roleName', $userData->roleName);

            $isAdmin = 1;
        //     $data['admin_dashboard_data'] = ApiController::AdminDashboradData($userData->officeId, $isAdmin);

        //     //  dd($data['admin_dashboard_data']);
        //     $data['productTypeList'] = ApiController::GetProductTypeWithRate($userData->officeId);

        //     $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($userData->officeId);
        //     // dd($data['officeList']);
        //     $fromDate = date('Y-m-d', strtotime('-6 days'));
        //     $toDate = date('Y-m-d');
        //     $officeId = $userData->officeId;
        //     $isAdmin = 6;
        //     $param_str = $fromDate . '/' . $toDate . '/' . $officeId . '/' . $isAdmin;

        //     $DEFDashBoardGraphData = ApiController::DEFDashBoardGraphData($param_str);
        //     // dd($DEFDashBoardGraphData);
        //     $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        //     $data['months'] = $this->months;
        //     $data['years'] = $this->years;

        //     session()->put('productTypeList', $data['productTypeList']);
        //     $sales = [];
        //     $expense = [];
        //     $data['labels'] = [];
        //     $data['data_sales'] = [];
        //     $data['data_expense'] = [];

        //     $data['graph2'] = [];

        //     $data['product_sales'] = [];

        //     $data['product_sales_labels'] = [];
        //     $data['average'] = [];
        //     if ($DEFDashBoardGraphData == null) {
        //         return view('companyadmin.dashboard', $data);
        //     }
        //     foreach ($DEFDashBoardGraphData['graph1'] as $key => $graph_data) {
        //         $sales[$graph_data['requestedDate']] = $graph_data['totalIncome'];
        //         $expense[$graph_data['requestedDate']] = $graph_data['totalExpense'];
        //     }
        //     //dd($DEFDashBoardGraphData['graph2']);
        //     $product_sales = [];
        //     $product_sales_with_qty= [];
        //     foreach ($DEFDashBoardGraphData['graph2'] as $key => $graph_data) {
        //         foreach ($graph_data['lstproduct'] as $key1 => $graph_data1) {

        //             if (!isset($product_sales[$graph_data1['productName']])) {
        //                 $product_sales[$graph_data1['productName']]= $graph_data1['totalSale'];
        //                 $product_sales_with_qty[$graph_data1['productName']]['sale'] = $graph_data1['totalSale'];
        //                 $product_sales_with_qty[$graph_data1['productName']]['qty'] = $graph_data1['qty'];
        //                 $product_sales_with_qty[$graph_data1['productName']]['PrimaryUnit'] = $graph_data1['primaryUnit'];
        //             } else {
        //                 $product_sales[$graph_data1['productName']] += (double) $graph_data1['totalSale'];
        //                 $product_sales_with_qty[$graph_data1['productName']]['sale']+= (double) $graph_data1['totalSale'];
        //                 $product_sales_with_qty[$graph_data1['productName']]['qty'] += (double)$graph_data1['qty'];
        //             }

        //         }

        //     }

        //     $data['sales'] = collect($sales);
        //     $data['expense'] = collect($expense);
        //     // $data['average']=(collect($sales)->max()>=collect($expense)->max())?collect($sales)->max()/2:collect($expense)->max()/2;
        //     // dd($sales);
        //     $data['labels'] = collect($sales)->keys();
        //     $data['data_sales'] = collect($sales)->values();
        //     $data['data_expense'] = collect($expense)->values();
        //     $average = collect($sales)->sum() / count($data['labels']);
        //     for ($i = 0; $i < count($data['labels']); $i++) {
        //         $data['average'][$i] = $average;
        //     }
        //     $data['graph2'] = collect($product_sales_with_qty);
        //    // dd($data['graph2'] );
        //     $data['product_sales'] = collect($product_sales) ->values();

        //     $data['product_sales_labels'] = collect($product_sales)->keys();

            //   dd($data['productTypeList']);
            return view('companyadmin.dashboard', $data);
        } else if ($userData->roleName == 'pumpadmin') {
            session()->put('roleName', $userData->roleName);

            $data['officeList'] = [ApiController::GetOffice($userData->officeId)];
            $isAdmin = 0;
            $data['admin_dashboard_data'] = (object) ApiController::AdminDashboradData($userData->officeId, $isAdmin);

            $data['productTypeList'] = ApiController::GetProductTypeWithRate($userData->officeId);

            $fromDate = date('Y-m-d', strtotime('-6 days'));
            $toDate = date('Y-m-d');
            $officeId = $userData->officeId;

            $param_str = $fromDate . '/' . $toDate . '/' . $officeId . '/' . $isAdmin;

            $DEFDashBoardGraphData = ApiController::DEFDashBoardGraphData($param_str);

            $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
            $data['months'] = $this->months;
            $data['years'] = $this->years;

            session()->put('productTypeList', $data['productTypeList']);
            $sales = [];
            $expense = [];

            $data['labels'] = [];
            $data['data_sales'] = [];
            $data['data_expense'] = [];

            $data['graph2'] = [];

            $data['product_sales'] = [];

            $data['product_sales_labels'] = [];
            $data['average'] = [];
            if ($DEFDashBoardGraphData == null) {
                return view('pumpadmin.dashboard', $data);
            }
            foreach ($DEFDashBoardGraphData['graph1'] as $key => $graph_data) {
                $sales[$graph_data['requestedDate']] = $graph_data['totalIncome'];
                $expense[$graph_data['requestedDate']] = $graph_data['totalExpense'];
            }
            //dd($DEFDashBoardGraphData['graph2']);
            $product_sales = [];
            foreach ($DEFDashBoardGraphData['graph2'] as $key => $graph_data) {
                foreach ($graph_data['lstproduct'] as $key1 => $graph_data1) {

                    if (!isset($product_sales[$graph_data1['productName']])) {
                        $product_sales[$graph_data1['productName']] = $graph_data1['totalSale'];
                    } else {
                        $product_sales[$graph_data1['productName']] += (double) $graph_data1['totalSale'];
                    }

                }

            }

            $data['sales'] = collect($sales);
            $data['expense'] = collect($expense);
            // dd($sales);
            $data['labels'] = collect($sales)->keys();
            $data['data_sales'] = collect($sales)->values();
            $data['data_expense'] = collect($expense)->values();
            $average = collect($sales)->sum() / count($data['labels']);
            for ($i = 0; $i < count($data['labels']); $i++) {
                $data['average'][$i] = $average;
            }
            $data['graph2'] = collect($product_sales);

            $data['product_sales'] = collect($product_sales)->values();

            $data['product_sales_labels'] = collect($product_sales)->keys();

            // dd($data['pumpadmin_dashboard_data']);
            return view('pumpadmin.dashboard', $data);
        } else if ($userData->roleName == 'pumpuser') {
            return view('user.dashboard', $data);
        } else {
            return view('auth.login');
        }

    }

}
