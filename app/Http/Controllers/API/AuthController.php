<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as baseController;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset; 
use Illuminate\Auth\Events\Registered;
use Intervention\Image\Facades\Image;

class AuthController extends BaseController
{
 
    public function login(Request $request)
    {

            try{

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('random key')->accessToken;
            $success['name'] = $user->name;
            $success['role'] = $user->getRoleNames();
            $success['userId'] = $user->userId;
            $success['active'] = $user->isActive;
            return $this->sendResponse($success, 'User Login Successfully!');
        } else {
            return $this->sendError('Unauthorised', ['error', 'Unauthorised']);
        }
            }catch(\Illuminate\Database\QueryException $e){
                return $this->sendError('error', $e);
            }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required", 
            "password" => 'required', 
        ]);


        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
   
        try {
            $user = User::create($input);
            $role = Role::where('name', 'user')->first();
            
            $user->save();
            event(new Registered($user));
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return $this->sendError('User already exist');
            }else{
                 return $this->sendError($e);
            }
        }
        $success['token'] = $user->createToken('random key')->accessToken;
        $success['name'] = $user->name;
        $success['role'] = $user->getRoleNames();;
        $success['id'] = $user->id;
        return $this->sendResponse($success, "test");
    }

    protected function sendResetLinkResponse(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT)
            return $this->sendResponse(__($status), 'Send Successfully!');
        else
            return $this->sendError('ERROR', ['email' => __($status)]);
    }

    protected function sendResetResponse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->createToken('random key')->accessToken;

                $user->save();
                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET)
            return $this->sendResponse(__($status), 'Updated Successfully!');
        else
            return $this->sendError('ERROR', ['email' => __($status)]);
    }
}
