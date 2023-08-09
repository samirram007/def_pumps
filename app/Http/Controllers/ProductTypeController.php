<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;

    public function __construct()
    {
        // $roles = ApiController::GetRoles();
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());

        $del_val = ["SuperAdmin"];
        if($roles){
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

    public function organisation_product_index($id)
    {

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        //$data['products'] = ApiController::GetProductByOrgId($id);
        $data['office'] = [ApiController::GetOffice($id)];
        $data['product_search_route'] = route($this->routeRole .'.organization.product_search');
        $data['product_create_route'] = route($this->routeRole .'.organization.product_create', $id);
        // dd($data['product_search_route']);
        //dd($data['products']);
        // $data['latest_rate']=ApiController::GetProductTypeWithRate($id);
        //dd($data['latest_rate']);

        $info['title'] = "Product List";
        $info['size'] = "modal-lg";
        return view('module.product.product_index', $data);

    }
    public function organisation_product_search(Request $request)
    {

        $products = ApiController::GetProductByOrgId($request->officeId);
        $data['products'] = $this->SetUnits($products);
        $data['product_create_route'] = route($this->routeRole .'.organization.product_create', $request->officeId);
        $html = view('module.product.product_index_body', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }
    public function SetUnits($products)
    {
        $units = ApiController::GetUnits();

        foreach ($products as $key => $product) {
            // $product['unitName'] = $this->Getvalues($units, $product['unitId'])['unitName'];

            foreach ($units as $unit) {
                if ($unit['unitId'] == $product['primaryUnitId']) {
                    $products[$key]['primaryUnitName'] = $unit['unitName'];
                }
                if ($unit['unitId'] == $product['secondaryUnitId']) {
                    $products[$key]['secondaryUnitName'] = $unit['unitName'];
                }
            }

        }
        return $products;
    }
    public function organisation_product_create(Request $request, $id)
    {
        //dd($request->all());

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['organizationId'] = $id;
        $data['units'] = ApiController::GetUnits();
        if ($request->param != null) {
            $data['productTypeId'] = $request->param;
            $data['product'] = ApiController::GetProductTypeByOrgId($id, $request->param);
            //  dd($data['product']);
        } else {
            $data['productTypeId'] = 0;
            $data['product'] = null;
        }

        $html = view('module.product.product_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }
    public function save_product(Request $request)
    {

        $data['productTypeId'] = $request->productTypeId;
        $data['productTypeName'] = $request->productTypeName;
        $data['color'] = $request->color;
        $data['isContainer'] = $request->isContainer;
        $data['quantity'] = $request->quantity == null ? 0 : $request->quantity;
        $data['organizationId'] = $request->organizationId;
        $data['recorderPoint'] = $request->recorderPoint;
        $data['maxStockLevel'] = $request->maxStockLevel;
        $data['primaryUnitId'] = $request->primaryUnitId;
        $data['useSecondaryUnit'] = $request->useSecondaryUnit == 0 ? false : true;
        $data['secondaryUnitId'] = $request->useSecondaryUnit == 1 ? $request->secondaryUnitId : null;
        $data['secondaryUnitRatio'] = $request->useSecondaryUnit == 1 ? $request->secondaryUnitRatio : null;

        if ($data['productTypeId'] == null || $data['productTypeId'] == 0) {
            //  dd($data);
            $productType['productTypeName'] = base64_encode($data['productTypeName']);
            $productType['isContainer'] = $data['isContainer'] == 0 ? false : true;
            $productType['color'] = $data['color'];
            $productType['quantity'] = $data['quantity'];
            $productType['organizationId'] = $data['organizationId'];
            $productType['recorderPoint'] = $data['recorderPoint'];
            $productType['maxStockLevel'] = $data['maxStockLevel'];
            $productType['primaryUnitId'] = $data['primaryUnitId'];
            $productType['useSecondaryUnit'] = $data['useSecondaryUnit'];
            $productType['secondaryUnitId'] = $data['secondaryUnitId'];
            $productType['secondaryUnitRatio'] = $data['secondaryUnitRatio'];
            // dd(json_encode($productType));
            $response = ApiController::saveProductType($productType);

            // dd($response);
            // $data['products'] = ApiController::GetProductByOrgId($request->organizationId);
            // $data['office'] = [ApiController::GetOffice($request->organizationId)];
            // //    return redirect()->back()->with('success','Product saved successfully');
            // $html = view('module.product.partial.product_list_body', $data)->render();
            if ($response->status() === 200) {
                $products = ApiController::GetProductByOrgId($productType['organizationId']);
                $data['products'] = $this->SetUnits($products);
                $data['product_create_route'] = route($this->routeRole .'.organization.product_create', $productType['organizationId']);
                $html = view('module.product.product_index_body', $data)->render();
                return response()->json(['status' => 'success', 'message' => 'Product saved successfully', 'html' => $html]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Product not saved successfully']);
            }
        } else {
            $productType['productTypeId'] = $data['productTypeId'];
            $productType['productTypeName'] = base64_encode($data['productTypeName']);
            $productType['isContainer'] = $data['isContainer'] == 0 ? false : true;
            $productType['color'] = $data['color'];
            $productType['quantity'] = $data['quantity'];
            $productType['organizationId'] = $data['organizationId'];
            $productType['recorderPoint'] = $data['recorderPoint'];
            $productType['maxStockLevel'] = $data['maxStockLevel'];
            $productType['primaryUnitId'] = $data['primaryUnitId'];
            $productType['useSecondaryUnit'] = $data['useSecondaryUnit'];
            $productType['secondaryUnitId'] = $data['secondaryUnitId'];
            $productType['secondaryUnitRatio'] = $data['secondaryUnitRatio'];
             //dd(json_encode($productType));
            $response = ApiController::updateProductType($productType);
            // $data['products'] = ApiController::GetProductByOrgId($request->organizationId);
            // $data['office'] = [ApiController::GetOffice($request->organizationId)];
            // //  return redirect()->back()->with('success','Product updated successfully');
            // $html = view('module.product.partial.product_list_body', $data)->render();
            if ($response->status() === 200) {
                $products = ApiController::GetProductByOrgId($productType['organizationId']);
                $data['products'] = $this->SetUnits($products);
                $data['product_create_route'] = route($this->routeRole .'.organization.product_create', $productType['organizationId']);
                $html = view('module.product.product_index_body', $data)->render();
                return response()->json(['status' => 'success', 'message' => 'Product updated successfully', 'html' => $html]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Product not updated successfully']);
            }
        }
    }
    private function productList($orgid)
    {
        $data['products'] = ApiController::GetProductByOrgId($orgid);
        $data['office'] = [ApiController::GetOffice($orgid)];
        // dd($data['office']);
        // $data['latest_rate']=ApiController::GetProductTypeWithRate($id);
        //dd($data['latest_rate']);
        $info['title'] = "Product List";
        $info['size'] = "modal-lg";

        $html = view('module.product.product', $data)->render();
    }

}
