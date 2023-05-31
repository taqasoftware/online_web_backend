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
    public function index(Request $request)
    {
        $origin_id = $request->query('origin_id'); 
        if ($origin_id && $origin_id != 'undefined') {
            $products = Product::where('prodOrgID', $origin_id)->paginate(10);
            
          
            return $this->sendResponse($products, 'Products');
        }
        else {

            $products = Product::paginate(10);
        }
        return $this->sendResponse($products, 'Products');
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
            'products.*.ProdName' => 'required|max:200',
            'products.*.ProdID' => 'required|max:200',
            'products.*.ProdOrgID' => 'required|integer|min:1',
            'products.*.ProdSalePrice1' => 'required|numeric|min:0',
            'products.*.ProdSalePrice2' => 'required|numeric|min:0',
            'products.*.ProdSalePrice3' => 'required|numeric|min:0',
            'products.*.ProdSalePrice4' => 'required|numeric|min:0',
            'products.*.ProdGiftBonus' => 'required|integer|min:0',
            'products.*.ProdGiftQTY' => 'required|integer|min:0',
            'products.*.ProdNote' => 'nullable|max:250',
            'products.*.ProdCurrentBalance' => 'required|numeric|min:0'
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
        $product = Product::firstwhere('ProdID',$id);
      
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
    
        return $this->sendResponse($product, 'Region updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('ProdID',$id)->delete();

        if ($product == 0) {

            return $this->sendError('Product does not exist');
        }
        return $this->sendResponse($product, 'Product deleted Successfully');
    }




    public function search(Request $request)
    {
        $query = $request->input('query');
 
        $results = Product::where('ProdName', 'like', "%{$query}%")->get();

        return response()->json($results);
    }


   

}
