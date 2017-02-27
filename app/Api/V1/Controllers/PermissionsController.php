<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\User;

class PermissionsController extends Controller
{
	use Helpers;

    public function createPermission(Request $request){
    	$permission = new Permission();
    	$permission->name = $request->input('name');
    	$permission->save();

    	return response()->json(['status' => 'permission created']);
    }

    public function attachPermission(Request $request){
    	$role = Role::where('name', '=', $request->input('role'))->first();
    	$permission = Permission::where('name', '=', $request->input('name'))->first();
    	$role->attachPermission($permission);

    	return response()->json(['status' => 'attached permission']);
    }
}
