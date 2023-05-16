<?php


namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Costumer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
 

class UserController extends BaseController
{
 


  public function index()
  {

    $users = User::all();
    return $this->sendResponse($users, "Users");
  }


  public function autoComplete(Request $request){
    $searchTerm = $request->input('query');
        
    // Fetch the autocomplete suggestions based on the search term
    
    // Example: Fetch suggestions from a database table
    $suggestions = Costumer::
        where('CustName', 'like', '%'.$searchTerm.'%') 
        ->pluck('CustName');
    
    return response()->json($suggestions);
  }


  public function store(Request $request)
  {

    $validator = Validator::make($request->all(), [
      "name" => "required", 
      "password" => 'required',
      'role' => 'required', 
    ]);

    if ($validator->fails()) {
      return $this->sendError($validator->errors());
    }
    $input = $request->all();
    $role = $this->GetRole($input['role']);
    $input['password'] = Hash::make($request->password);
    try {

      $user = User::create($input);
      $user->assignRole($role);
      $this->createUserPhoto($request->file('image'), $user);
      event(new Registered($user));
    } catch (\Illuminate\Database\QueryException $e) {
      $errorCode = $e->errorInfo[1];
      if ($errorCode == 1062) {
        return $this->sendError('User already exist');
      }
    }
    return $this->sendResponse($user, "User created");
  }

 




  private function GetRole($role)
  {
    $role = Role::where('name', $role)->first();
    if (is_null($role)) {

      return $this->sendError('Role does not exist');
    }

    return $role;
  }

  public function show($id)
  {
    $user = User::find($id);
    if (is_null($user)) {

      return $this->sendError('User does not exist');
    }
    return $this->sendResponse($user, "User");
  }


  public function update(Request $request,  $id)
  {
    $input = $request->all();
    $validator = Validator::make($input, [
      "name" => "required", 
      "password" => 'required',
      "role" => "required"
    ]);
    if ($validator->fails()) {
      return $this->sendError('Validation error', $validator->errors());
    }

    $user = User::find($id);
    $input['password'] = Hash::make($request->password);
    $updateParam = [
      "name" => $input['name'], 
      "password" => $input['password'],
      "role" => $input['role'],
    ];
    try {
      $user->update($updateParam);
    } catch (\Error $e) {
      return $this->sendError('User does not exist');
    }
    return $this->sendResponse($user, 'User updated Successfully!');
  }

  public function deactivate(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      "id" => "required", 

    ]);
    if ($validator->fails()) {
      return $this->sendError('Validation error', $validator->errors());
    }
    $user = User::where('id', $request->id)->update(['is_active' => 0]);

    $result = $user;

    if ($result == 0) {

      return $this->sendError('User does not exist');
    }
    return $this->sendResponse($result, 'User deleted Successfully!');
  }





  public function listUnactiveUser()
  {
    try {
      $users = User::with('roles')->where('is_active', 0)->whereHas(
        'roles',
        function ($q) {
          $q->where('name', 'user');
        }
      )->get();
      return $this->sendResponse($users, 'All Un Accepted Users!');
    } catch (\Error $e) {
      return $this->sendError('All Users Have Been Accepted');
    }
  }

 
  public function activeUser(Request $request, $id)
  {
    $user = User::find($id);
    if (!is_null($user->picture)) {
      $this->deleteTempMedia($request->id);
    }
    try {
      $user->update(['is_active' => true]);
    } catch (\Error $e) {
      return $this->sendError('User does not exist');
    }

    return $this->sendResponse($user, 'user activated!');
  }

  


   

 


  
}
