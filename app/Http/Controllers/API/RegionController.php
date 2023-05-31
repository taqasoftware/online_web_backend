<?php

namespace App\Http\Controllers\API;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class RegionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $region = Region::all();
        return $this->sendResponse($region, "Regions");
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
            'regions' => 'required|min:1',
            'regions.*.RegName' => 'required|string|max:255',
            'regions.*.RegId' => 'required|int'
        ];
    
        $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
            return $this->sendError($validator->errors());
          }
          $input = $request->all();  
          for ($x = 0; $x < count($input['regions']); $x++) {
            $reg = $input['regions'][$x];
       
            $region = Region::firstwhere('regid',$reg['RegId']);
            if(is_null($region)){
                 $region = Region::create($reg);
            }else{
                $region->where('regid',$reg['RegId'])->update(['RegId' => $reg['RegId'], 'RegName' => $reg['RegName']]);
            }
          } 
        
        
          return $this->sendResponse($reg,"Region created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $region = Region::firstwhere('regid',$id);
      
        if(is_null($region)){

        return $this->sendError('Region does not exist');
    }

    return $this->sendResponse($region, 'Region');

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
        $input = $request->all();
        $validator = Validator::make($input, [
            'RegName' => 'required|string|max:255', 
        ]);
        if ($validator->fails()) {
          return $this->sendError('Validation error', $validator->errors());
        }
    
        $region = Region::firstwhere('regid',$id); 
        $updateParam = [
          "RegName" => $input['RegName']
        ];
        try {
          $region->where('regid',$id)->update($updateParam);
        } catch (\Error $e) {
          return $this->sendError('Region does not exist');
        }
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
        $region = Region::where('regid',$id)->delete();

        if ($region == 0) {

            return $this->sendError('Region does not exist');
        }
        return $this->sendResponse($region, 'Region deleted Successfully');
    }
}
