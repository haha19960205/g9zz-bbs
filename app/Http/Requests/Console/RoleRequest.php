<?php

namespace App\Http\Requests\Console;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

class RoleRequest extends BaseRequest
{
    public $key = 'role';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $actionMethod = Request::route()->getActionMethod();
        $rule = [];
        if ($actionMethod == 'store') {
            $rule = [
                'name' => 'required|unique:roles,name',
                'displayName' => 'required|unique:roles,display_name',
                'level' => 'required|integer',
                'description' => 'max:150',
            ];
        }
        if ($actionMethod == 'update') {
            $id = Request::route()->parameter('id');
            $rule = [
                'name' => 'required|unique:roles,name,null,null,id,!'.$id,
                'displayName' => 'required|unique:roles,display_name,null,null,id,!'.$id,
                'level' => 'required|integer',
                'description' => 'max:150',
            ];
        }

        if ($actionMethod == 'attachPermission' || $actionMethod == 'coverAttachPermission') {
            $rule = [
                'permissionIds' => 'required'
            ];
        }

        return $rule;
    }
}
