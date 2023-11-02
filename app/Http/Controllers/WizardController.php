<?php

namespace App\Http\Controllers;

use App\Models\Godown;
use App\Models\Office;
use App\Services\OfficeService;

class WizardController extends Controller
{
    protected $fiscalYear;
    protected $title = 'New Business Entity';
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;
    protected $users = null;
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
        $data['routeRole'] = $this->routeRole;
        $data['step'] = 'modal';
        $data['title'] = 'New Pump Wizard';
        // $data['officeId']='06D5DDA0-6834-4EA1-183D-08DAF95AD4EF';
        $data['officeId'] = '18c00830-166c-4aac-15af-08dbae72bf8b';

        return view('module.wizard.index', $data);

    }
    public function modal_index($step = 'modal', $id = null)
    {
        //dd($step);
        $data['routeRole'] = $this->routeRole;
        $data['step'] = 'modal';
        $data['title'] = 'New Pump Wizard';
        // $data['officeId']='06D5DDA0-6834-4EA1-183D-08DAF95AD4EF';
        $data['officeId'] = '18c00830-166c-4aac-15af-08dbae72bf8b';
        if ($step == 'create_office') {
            return $this->createOffice();
        } elseif ($step == 'show_office') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->showOffice($id);
        } elseif ($step == 'godown_list') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->godownList($id);
        } elseif ($step == 'create_godown') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->createGodown($id);
        } elseif ($step == 'edit_godown') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->editGodown($id);
        } elseif ($step == 'all_stock') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->allStock($id);
        } elseif ($step == 'current_stock') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->currentStock($id);
        } elseif ($step == 'product_rate') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->productRate($id);
        } elseif ($step == 'invoice_no') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->invoiceNo($id);
        } elseif ($step == 'create_user') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->createUser($id);
        } elseif ($step == 'user_list') {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong',
                ]);
            }
            return $this->userList($id);
        }

        return response()->json([
            'status' => true,
            'html' => view('module.wizard.modal', $data)->render(),
        ]);

    }
    private function createOffice()
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $user = (object) $this->user;

        $data['masterOfficeId'] = $user->officeId;

        $officeTypes = ApiController::GetOfficeTypeList();

        $data['officeTypes'] = array_filter($officeTypes, function ($var) use ($data) {
            return (in_array($var['officeTypeId'], [2, 3]));
        });
        $data['gstTypes'] = ApiController::GetGstTypeList();
        // $data['masterOfficeList'] = Office::GetMasterOfficeList($user->officeId);
        $data['masterOfficeList'] = [Office::GetOfficeById($user->officeId)];
        $info['title'] = "New Pump";
        $info['size'] = "modal-lg";
        $data['step'] = 'create_office';
        $data['title'] = 'New Pump';
        $GetView = view('module.wizard.office.create', $data)->render();
        //dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    private function showOffice($id)
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $user = (object) $this->user;

        $data['masterOfficeId'] = $user->officeId;
        //dd($data['masterOfficeId']);
        $officeTypes = ApiController::GetOfficeTypeList();

        $data['officeTypes'] = array_filter($officeTypes, function ($var) use ($data) {
            return (in_array($var['officeTypeId'], [2, 3]));
        });
        $data['gstTypes'] = ApiController::GetGstTypeList();
        $data['masterOfficeList'] = Office::GetMasterOfficeList($user->officeId);

        $data['office'] = ApiController::GetOffice($id);
        //dd($data['office']);
        $info['title'] = "Show Pump";
        $info['size'] = "modal-lg";
        $data['step'] = 'show_office';
        $data['title'] = 'View Pump';
        $GetView = view('module.wizard.office.show', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    private function godownList($id)
    {
        $godowns = ApiController::GetGodownsByOfficeId($id);

        $data['godownTypes'] = ApiController::GodownTypes();
        // $data['officeTypes'] = ApiController::GetOfficeTypeList();
        // $data['gstTypes'] = ApiController::GetGstTypeList();
        $data['office'] = ApiController::GetOffice($id);
        $data['godowns'] = Godown::SetGodownType($godowns);
        // dd($data['godowns']);
        $data['menu_name'] = 'godowns';
        $data['modal_name'] = 'Godowns';
        //dd($data['godowns']);
        $info['title'] = "Godowns";
        $info['size'] = "modal-lg";
        $info['step'] = "godown_list";

        $GetView = view('module.wizard.godown.index', $data)->render();

        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

    }
    public function createGodown($id)
    {
        //dd($id);

        $data['office'] = ApiController::GetOffice($id);
        $data['godownTypes'] = ApiController::GodownTypes();

        $data['menu_name'] = 'create_godown';
        $data['modal_name'] = 'create Godown';
        $info['title'] = "create Godown";
        $info['size'] = "modal-lg";
        $GetView = view('module.wizard.godown.create', $data)->render();
        //dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

    }
    public function editGodown($id)
    {
        $godown = ApiController::getGodown($id);
        $data['office'] = ApiController::GetOffice($godown['officeId']);
        $data['godownTypes'] = ApiController::GodownTypes();
        //dd($godown);
        $data['godown'] = $godown;
        $data['menu_name'] = 'edit_godown';
        $data['modal_name'] = 'Edit Godown';
        $info['title'] = "Edit Godown";
        $info['size'] = "modal-lg";
        $GetView = view('module.wizard.godown.edit', $data)->render();
        //dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

    }
    public function allStock($officeId)
    {
        $godown = ApiController::GetGodownsWithStockByOfficeId($officeId);

        $data['office'] = ApiController::GetOffice($officeId);

        $data['productList'] = ApiController::GetProductType($officeId);
        $data['godownList'] = ApiController::GetGodownsByOfficeId($officeId);

        //dd($data['office']);
        $data['godowns'] = $godown;
        $data['menu_name'] = 'all_stock';
        $data['modal_name'] = 'Godown Stock All';
        $info['title'] = "Godown Stock All";
        $info['size'] = "modal-lg";
        //dd($data);
        $htmlView = view('module.wizard.stock.index', $data)->render();

        return response()->json([
            "status" => true,
            "html" => $htmlView,
        ]);
    }
    public function currentStock($godownId)
    {
        $godown = ApiController::GetGodownsWithStockByGodown($godownId);

        $data['office'] = ApiController::GetOffice($godown['officeId']);
        //dd($data['office']);
        $data['productList'] = ApiController::GetProductType($godown['officeId']);
        //dd($data['office']);
        $data['godown'] = Godown::SetGodownType([$godown])[0];

        $data['menu_name'] = 'godown_stock';
        $data['modal_name'] = 'Godown Stock';
        $info['title'] = "Godown Stock";
        $info['size'] = "modal-lg";

        $htmlView = view('module.wizard.stock.current', $data)->render();

        return response()->json([
            "status" => true,
            "html" => $htmlView,
        ]);
    }
    public function productRate($id)
    {
        $user = $this->user;
        $roleName = $this->roleName;

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $data['latest_rate'] = ApiController::GetLatestPriceByOfficeId($id);
        $data['office'] = ApiController::GetOffice($id);

        $info['title'] = "Latest Rate";
        $info['size'] = "modal-lg";

        $html = view('module.wizard.product.latest_rate', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }
    public function invoiceNo($officeId)
    {
        $user = $this->user;
        $roleName = $this->roleName;

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $data['office'] = [ApiController::GetOffice($officeId)];
        $data['invoice_no'] = 0;

        $data['fiscalYear'] = ApiController::GetFiscalYears();
        //$data['fiscalYear'] = $this->fiscalYear;
        //dd($this->fiscalYear);
        $info['title'] = "Invoice No";
        $info['size'] = "modal-lg";

        $html = view('module.wizard.invoice_no.create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }
    public function createUser($id)
    {
        $user = (object) $this->user;
        $data['office'] = ApiController::GetOffice($id);
        $data['officeList'] = [$data['office']];

        //dd($data['officeList']);
        $data['roles'] = $this->roles;

        $data['roles'] = array_filter($this->roles, function ($var) use ($data) {
            return (in_array($var, ['PumpUser']));
        });
        //  dd($data['roles'] );
        $info['title'] = "Create User";
        $info['size'] = "modal-lg";
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;

        $html = view('module.wizard.user.create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }
    public function userList($id)
    {

        //$office = (object) [ApiController::GetOffice($id)][0];
        $data['office'] = ApiController::GetOffice($id);
        // $user = (object) $this->user;
        //  dd($this->users);

        $data['roles'] = $this->roles;
        $data['roles'] = array_filter($this->roles, function ($var) use ($data) {
            return (in_array($var, ['PumpUser']));
        });
        $this->loadUsers($id);
        // dd($this->users );
        $data['collections'] = $this->users;
        // $data['office'] = $office;
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        // load the view and pass the users

        $html = view('module.wizard.user.index', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }

    private function loadUsers($officeId)
    {

        $param_data = [
            'userId' => '',
            'roleName' => 'PumpUser',
            'officeId' => $officeId,
        ];
        $this->users = ApiController::UserListByEmployeeId($param_data);

    }
}
