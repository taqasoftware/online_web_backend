<?php

namespace App\Http\Controllers\API;


 
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return $this->sendResponse($product, "Product");
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'products' => 'required|min:1',
            'products*.prodName' => 'required|max:200',
            'products*.prodId' => 'required|max:200',
            'products*.prodOrgID' => 'required|integer|min:1',
            'products*.prodSalePrice1' => 'required|numeric|min:0',
            'products*.prodSalePrice2' => 'required|numeric|min:0',
            'products*.prodSalePrice3' => 'required|numeric|min:0',
            'products*.prodSalePrice4' => 'required|numeric|min:0',
            'products*.prodGiftBonus' => 'required|integer|min:0',
            'products*.prodGiftQTY' => 'required|integer|min:0',
            'products*.prodNote' => 'nullable|max:250',
            'products*.prodCurrentBalance' => 'required|numeric|min:0'
        ];
    
        $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
            return $this->sendError($validator->errors());
          }
          $input = $request->all();  
          for ($x = 0; $x < count($input['products']); $x++) {
            $product_input = $input['products'][$x];
       
            $prod = Product::firstwhere('ProdID',$product_input['ProdID']);
            if(is_null($prod)){
                 $prod = Product::create($product_input);
            }else{
                $prod->where('ProdID',$product_input['ProdID'])->update($product_input);
            }
          } 
        
        
          return $this->sendResponse($prod,"Product created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $product = Product::firstwhere('ProdId',$id);
      
        if(is_null($product)){

        return $this->sendError('Product does not exist');
    }

    return $this->sendResponse($product, 'Product');

    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'ProgName' => 'required|string|max:200',
            'ProdOrgID' => 'required|integer',
            'ProdSalePrice1' => 'required|numeric',
            'ProdSalePrice2' => 'required|numeric',
            'ProdSalePrice3' => 'required|numeric',
            'ProdSalePrice4' => 'required|numeric',
            'ProdGiftBonus' => 'required|integer',
            'ProdGiftQTY' => 'required|integer',
            'ProdNote' => 'nullable|string|max:250',
            'ProdCurrentBalance' => 'required|numeric'
        ]);
    
        $product = Product::findOrFail($id);
        $product->update($data);
    
        return $this->sendResponse($region, 'Region updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('ProdId',$id)->delete();

        if ($product == 0) {

            return $this->sendError('Product does not exist');
        }
        return $this->sendResponse($product, 'Product deleted Successfully');
    }
}
