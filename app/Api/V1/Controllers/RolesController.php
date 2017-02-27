<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;

class RolesController extends Controller
{
	use Helpers;

    public function createRole(Request $request){
    	$role = new Role();
    	$role->name = $request->input('name');
    	$role->save();

    	return response()->json(['status' => 'role created']);
    }

    public function assignRole(Request $request){
    	$user = User::where('email', '=', $request->input('email'))->first();

    	$role = Role::where('name', '=', $request->input('role'))->first();

    	$user->roles()->attach($role->id);

    	return response()->json(['status' => 'role assigned to user']);
    }
}
