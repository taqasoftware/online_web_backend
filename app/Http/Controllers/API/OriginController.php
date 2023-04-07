<?php

namespace App\Http\Controllers\API;

use App\Models\Origin;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class OriginController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $origin = Origin::all();
        return $this->sendResponse($origin, "Origins");
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
            'origins' => 'required|min:1',
            'origins*.OrgName' => 'required|string|max:255',
            'origins*.OrgId' => 'required|int'
        ];
    
        $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
            return $this->sendError($validator->errors());
          }
          $input = $request->all();  
          for ($x = 0; $x < count($input['origins']); $x++) {
            $reg = $input['origins'][$x];
       
            $origin = Origin::firstwhere('OrgId',$reg['OrgId']);
            if(is_null($origin)){
                 $origin = Origin::create($reg);
            }else{
                $origin->where('OrgId',$reg['OrgId'])->update(['OrgId' => $reg['OrgId'], 'OrgName' => $reg['OrgName']]);
            }
          } 
        
        
          return $this->sendResponse($reg,"Origin created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Origin  $origin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $origin = Origin::firstwhere('OrgId',$id);
      
        if(is_null($origin)){

        return $this->sendError('Origin does not exist');
    }

    return $this->sendResponse($origin, 'Origin');

    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Origin  $origin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'OrgName' => 'required|string|max:255', 
        ]);
        if ($validator->fails()) {
          return $this->sendError('Validation error', $validator->errors());
        }
    
        $origin = Origin::firstwhere('OrgId',$id); 
        $updateParam = [
          "OrgName" => $input['OrgName']
        ];
        try {
          $origin->where('OrgId',$id)->update($updateParam);
        } catch (\Error $e) {
          return $this->sendError('Origin does not exist');
        }
        return $this->sendResponse($origin, 'Origin updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Origin  $origin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $origin = Origin::where('OrgId',$id)->delete();

        if ($origin == 0) {

            return $this->sendError('Origin does not exist');
        }
        return $this->sendResponse($origin, 'Origin deleted Successfully');
    }
}
