<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GodownController extends Controller
{
    protected $fiscalYear;
    protected $supportService;
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;
    protected $office;
    protected $officeService;
    public function godowns($id)
    {
        $godowns = ApiController::GetGodownsByOfficeId($id);
        $data['godownTypes'] = ApiController::GodownTypes();
        // $data['officeTypes'] = ApiController::GetOfficeTypeList();
        // $data['gstTypes'] = ApiController::GetGstTypeList();
        $data['office'] = ApiController::GetOffice($id);
        $data['godowns'] = $this->SetGodownType($godowns);
        // dd($data['godowns']);
        $data['menu_name'] = 'godowns';
        $data['modal_name'] = 'Godowns';
        //dd($data['godowns']);
        $info['title'] = "Godowns";
        $info['size'] = "modal-lg";

        $GetView = view('module.godown.modal', $data)->render();

        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }

    public function godownlist($id)
    {
        //$response = ApiController::GetGodownsByOfficeId($id);
        $response = ApiController::GetGodownsWithStockByOfficeId($id);

        //dd($response);
        return response()->json([
            "status" => true,
            "response" => collect($response),
        ]);
    }
    public function create($id)
    {
        //dd($id);

        $data['office'] = ApiController::GetOffice($id);
        $data['godownTypes'] = ApiController::GodownTypes();

        $data['menu_name'] = 'create_godown';
        $data['modal_name'] = 'create Godown';
        $info['title'] = "create Godown";
        $info['size'] = "modal-lg";
        $GetView = view('module.godown.godown_create', $data)->render();
        //dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

    }
    public function store(Request $request)
    {

        $response = ApiController::createGodown([
            'officeId' => $request->input('officeId'),
            'godownName' => base64_encode($request->input('godownName')),
            'isReserver' => (boolean) $request->input('isReserver'),
            'godownTypeId' => $request->input('godownTypeId'),
        ]);

        if ($response->json()['status']) {
            // dd($response->json()['status']);
            $godowns = ApiController::GetGodownsByOfficeId($request->input('officeId'));
            $data['godowns'] = $this->SetGodownType($godowns);
            $data['office'] = ApiController::GetOffice($request->input('officeId'));

            $data['menu_name'] = 'godowns';
            $data['modal_name'] = 'Godowns';
            $GetView = view('module.godown.godown_index', $data)->render();

            return response()->json([
                "status" => true,
                "message" => $response->json()['message'],
                "html" => $GetView,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => $response->json()['message'],
            ]);
        }
    }
    public function edit($id)
    {
        // dd($godownId);
        $godown = ApiController::getGodown($id);
        $data['office'] = ApiController::GetOffice($godown['officeId']);
        $data['godownTypes'] = ApiController::GodownTypes();
        //dd($godown);
        $data['godown'] = $godown;
        $data['menu_name'] = 'edit_godown';
        $data['modal_name'] = 'Edit Godown';
        $info['title'] = "Edit Godown";
        $info['size'] = "modal-lg";
        $GetView = view('module.godown.godown_edit', $data)->render();
        //dd($GetView);
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

    }
    public function update(Request $request)
    {
        $response = ApiController::updateGodown([
            'godownId' => $request->input('godownId'),
            'officeId' => $request->input('officeId'),
            'godownName' => base64_encode($request->input('godownName')),
            'isReserver' => (boolean) $request->input('isReserver'),
            'godownTypeId' => $request->input('godownTypeId'),
        ]);

        if ($response->json()['status']) {
            $godowns = ApiController::GetGodownsByOfficeId($request->input('officeId'));
            $data['godowns'] = $this->SetGodownType($godowns);
            $data['office'] = ApiController::GetOffice($request->input('officeId'));

            $data['menu_name'] = 'godowns';
            $data['modal_name'] = 'Godowns';
            $GetView = view('module.godown.godown_index', $data)->render();

            return response()->json([
                "status" => true,
                "message" => $response->json()['message'],
                "html" => $GetView,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => $response->json()['message'],
            ]);
        }
    }
    public function delete($godownId)
    {
        //dd($godownId);
        $godown = ApiController::getGodown($godownId);
        $response = ApiController::deleteGodown($godownId);

        if ($response->status() === 200) {
            $data['godowns'] = ApiController::GetGodownsByOfficeId($godown['officeId']);

            $data['office'] = ApiController::GetOffice($godown['officeId']);

            $data['menu_name'] = 'godowns';
            $data['modal_name'] = 'Godowns';
            $GetView = view('module.godown.godown_index', $data)->render();

            return response()->json([
                "status" => true,
                "message" => "Godown deleted successfully",
                "html" => $GetView,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Godown deletion failed",
            ]);
        }

    }
    public function current_stock($godownId)
    {
        $godown = ApiController::GetGodownsWithStockByGodown($godownId);

        $data['office'] = ApiController::GetOffice($godown['officeId']);
        //dd($data['office']);
        $data['productList'] = ApiController::GetProductType($godown['officeId']);
        //dd($data['office']);
        $data['godown'] = $this->SetGodownType([$godown])[0];

        $data['menu_name'] = 'godown_stock';
        $data['modal_name'] = 'Godown Stock';
        $info['title'] = "Godown Stock";
        $info['size'] = "modal-lg";

        $htmlView = view('module.godown.godown_stock', $data)->render();

        return response()->json([
            "status" => true,
            "html" => $htmlView,
        ]);
    }
    public function all_stock($officeId)
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
        $htmlView = view('module.godown.godown_stock_all', $data)->render();

        return response()->json([
            "status" => true,
            "html" => $htmlView,
        ]);
    }
    public function stock_update(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'godownId' => 'required',
            'productTypeId' => 'required',
            'currentStock' => 'required',
            'officeId' => 'required',
        ]);
        $data = [];
        foreach ($request->input('productTypeId') as $key => $value) {
            // dd($request->input('currentStock')[$key]==$request->input('stock')[$key]? 'true':'false');
            if ($request->input('currentStock')[$key] != $request->input('stock')[$key]) {
                $sdata = [
                    'productTypeId' => $request->input('productTypeId')[$key],
                    'currentStock' => $request->input('currentStock')[$key],
                    'officeId' => $request->input('officeId')[$key],
                    'godownId' => $request->input('godownId')[$key],
                    'updatedBy' => session()->get('loginid'),
                ];
                array_push($data, $sdata);
            }
        }
        if (count($data) == 0) {
            return response()->json([
                "status" => false,
                "message" => "No data found to update",
            ]);
        }

        $response = ApiController::updateGodownStock($data);
        //dd($response);
        if ($response->status() === 200) {
            // dd($response);
            $godown = ApiController::GetGodownsWithStockByGodown($request->input('godownId')[0]);
            //dd($godown);
            $data['office'] = ApiController::GetOffice($godown['officeId']);
            $data['productList'] = ApiController::GetProductType($godown['officeId']);
            $data['godown'] = $this->SetGodownType([$godown])[0];
            $data['menu_name'] = 'godown_stock';
            $data['modal_name'] = 'Godown Stock';
            $info['title'] = "Godown Stock";
            $info['size'] = "modal-lg";
            $htmlView = view('module.godown.godown_stock', $data)->render();
            return response()->json([
                "status" => true,
                "message" => "Godown Stock updated successfully",
                "html" => $htmlView,
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Godown Stock updation failed",
            ]);
        }
    }
    protected function SetGodownType($godowns)
    {
        $godown_types = ApiController::GodownTypes();

        foreach ($godowns as $key => $godown) {
            // $product['unitName'] = $this->Getvalues($units, $product['unitId'])['unitName'];

            foreach ($godown_types as $godown_type) {
                // dd(gettype($godown['godownTypeId']));
                if ($godown_type['godownTypeId'] == $godown['godownTypeId']) {
                    $godowns[$key]['godownTypeName'] = $godown_type['godownTypeName'];
                }

            }

        }
        return $godowns;
    }
}
