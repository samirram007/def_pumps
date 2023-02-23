<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductTypeController extends Controller
{
    protected $roles;
    protected $routeRole='companyadmin';
    protected $roleName='companyadmin';
    protected $user=null;


    public function __construct()
    {
        $roles=ApiController::GetRoles();
        $del_val=["SuperAdmin" ];
        foreach ($roles as $key => $value){
               if (!in_array($value['name'],$del_val)){
            $this->roles[$value['name']]=$value['name'];
               }

        }
        $user=   session()->has('userData')?json_decode(json_encode(session()->get('userData')),true):ApiController::user(session()->get('loginid'));
        $roleName=session()->get('roleName');

        $this->user=json_decode(json_encode($user),true);
        $this->roleName=session()->get('roleName');
        $this->routeRole= str_replace(' ','_',strtolower($this->roleName));
    }
    public function organisation_product_index($id)
    {
        //dd($id);
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;

        $data['products']=ApiController::GetProductByOrgId($id);
        $data['office']=[ApiController::GetOffice($id)];
         // dd($data['office']);
        // $data['latest_rate']=ApiController::GetProductTypeWithRate($id);
        //dd($data['latest_rate']);
        $info['title']="Product List";
        $info['size']="modal-lg";
        return view('module.product.product',$data);
    //     $html=view('module.product.product',$data)->render();
    //    //dd($html);
    //     return response()->json([
    //         "status" => true,
    //         "html" => $html
    //     ]);
    }

    public function save_product(Request $request)
    {

        $data['productTypeId']=$request->productTypeId;
        $data['productTypeName']=$request->productTypeName;
        $data['isContainer']=$request->isContainer;
        $data['quantity']=$request->quantity ==null?0:$request->quantity;
        $data['organizationId']=$request->organizationId;
        $data['recorderPoint']=$request->recorderPoint;
        $data['maxStockLevel']=$request->maxStockLevel;
         //dd($data);
        if( $data['productTypeId'] == null){
          //  dd($data);
            $productType['productTypeName'] = base64_encode($data['productTypeName']);
            $productType['isContainer'] = $data['isContainer']==0?false:true;
            $productType['quantity'] = $data['quantity'];
            $productType['organizationId'] = $data['organizationId'];
            $productType['recorderPoint'] = $data['recorderPoint'];
            $productType['maxStockLevel'] = $data['maxStockLevel'];
           // dd(json_encode($productType));
            $response=ApiController::saveProductType($productType);

           // dd($response);
           $data['products']=ApiController::GetProductByOrgId($request->organizationId);
           $data['office']=[ApiController::GetOffice($request->organizationId)];
        //    return redirect()->back()->with('success','Product saved successfully');
            $html=view('module.product.partial.product_list_body',$data)->render();

             return response()->json(['status'=>'success','message' => 'Product saved successfully','html'=>$html]);
        }
        else{
            $productType['productTypeId'] = $data['productTypeId'];
            $productType['productTypeName'] =  base64_encode($data['productTypeName']);
            $productType['isContainer'] = $data['isContainer']==0?false:true;
            $productType['quantity'] = $data['quantity'];
            $productType['organizationId'] = $data['organizationId'];
            $productType['recorderPoint'] = $data['recorderPoint'];
            $productType['maxStockLevel'] = $data['maxStockLevel'];
            //  dd(json_encode($productType));
            $response=ApiController::updateProductType($productType);
            $data['products']=ApiController::GetProductByOrgId($request->organizationId);
            $data['office']=[ApiController::GetOffice($request->organizationId)];
          //  return redirect()->back()->with('success','Product updated successfully');
            $html=view('module.product.partial.product_list_body',$data)->render();
              return response()->json(['status'=>'success','message' => 'Product updated successfully','html'=>$html]);
        }
    }
    private function productList($orgid)
    {
        $data['products']=ApiController::GetProductByOrgId($orgid);
        $data['office']=[ApiController::GetOffice($orgid)];
         // dd($data['office']);
        // $data['latest_rate']=ApiController::GetProductTypeWithRate($id);
        //dd($data['latest_rate']);
        $info['title']="Product List";
        $info['size']="modal-lg";

        $html=view('module.product.product',$data)->render();
    }

}
