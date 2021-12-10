<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;
use App\Services\Slug;
use App\Models\PermissionScreen;
use App\Permissions\DefaultPermission;

class RoleController extends CoreController
{
    /*protected static $permissions = [
        'read' => 'Read Only',
        'read_write' => 'Read and write',
        'none' => 'None'
    ];*/

    // protected static $permissions = [
    //     'create' => 'Create',
    //     'edit' => 'Edit',
    //     'view' => 'View',
    //     /*'all' => 'All',
    //     'none' => 'None'*/
    // ];

    /**
     * Create the constructor
     *
     */
    public function __construct(Slug $slugObj, DefaultPermission $defaultPermissionObj)
    {
        parent::__construct();

        $this->slugObj = $slugObj;
        $this->defaultPermissionObj = $defaultPermissionObj;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Sentinel::getRoleRepository()->get();

        return view('auth.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $screens = PermissionScreen::active()->pluck('name', 'id')->toArray();

        return view('auth.roles.create', ['screens' => $screens, 'permissions' => $this->access_permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $slug = $this->slugObj->createSlug($request->name, 'roles');

        if($slug)
        {   
            $permission_list = $screen_list = [];
            if(isset($request->screens) && isset($request->permission) && !empty($request->screens) && !empty($request->permission) && count($request->screens) == count($request->permission))
            {
                $rolePermissionData = $this->defaultPermissionObj->getRolePermission($request->screens, $request->permission);

                $permission_list = $rolePermissionData['permission_list'];
                $screen_list = $rolePermissionData['screen_list'];
            }

            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name' => $request->name,
                'slug' => $slug
            ]);

            if(!empty($permission_list) && !empty($screen_list))
            {
                $role->permissions = $permission_list;
                $role->screens = $screen_list;
                $role->save();
            }

            return redirect()->route('roles.index')->with('message', __('messages.add', ['name' => 'Role']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function array_find($needle, array $haystack)
    {
        foreach ($haystack as $key => $value) {
            if (false !== stripos($value, $needle)) {
                return $haystack;
            }
        }
        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        if($slug)
        {
            $role = Sentinel::findRoleBySlug($slug);

            if($role)
            {
                $screens_data = PermissionScreen::active()->get();

                $screens = [];
                if(isset($screens_data) && !empty($screens_data))
                {
                    $screens = $screens_data->pluck('name', 'id')->toArray();

                    $selected_permissions = [];
                    if(isset($role->permissions) && !empty($role->permissions))
                    {
                        $screens_data = $screens_data->toArray();
                        foreach ($role->permissions as $permissionKey => $permission)
                        {
                            foreach ($screens_data as $key_1 => $item) {
                                $success = 0;
                                foreach ($item as $pKey => $value_1) {
                                    if (false !== stripos($value_1, $permissionKey))
                                    {
                                        $selected_permissions[$item['id']] = isset($selected_permissions[$item['id']]) ? $selected_permissions[$item['id']] : [];

                                        $selected_permissions[$item['id']][] = $pKey;
                                        $selected_permissions[$item['id']] = array_unique($selected_permissions[$item['id']]);

                                        $success = 1;
                                        break;
                                    }
                                }

                                if($success)
                                    break;
                            }

                            /*$item = array_values(array_filter($screens_data, function($item) use ($permissionKey){
                                return in_array($permissionKey, $item);
                            }));

                            if($item)
                            {
                                $pKey = array_search($permissionKey, $item);

                                if($pKey)
                                {
                                    $selected_permissions[$item['id']] = isset($selected_permissions[$item['id']]) ? $selected_permissions[$item['id']] : [];
                                    $selected_permissions[$item['id']][] = $pKey;
                                }
                            }*/
                        }
                    }
                }

                return view('auth.roles.edit', ['role' => $role, 'screens' => $screens, 'permissions' => $this->access_permissions, 'selected_permissions' => $selected_permissions]);
            }
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
        ]);

        $role = Sentinel::findRoleById($id);

        if($role)
        {
            $slug = $this->slugObj->createSlug($request->name, 'roles', 'slug', $role->id);

            if($slug)
            {
                $permission_list = $screen_list = [];
                if(isset($request->screens) && isset($request->permission) && !empty($request->screens) && !empty($request->permission) && count($request->screens) == count($request->permission))
                {
                    $rolePermissionData = $this->defaultPermissionObj->getRolePermission($request->screens, $request->permission);

                    $permission_list = $rolePermissionData['permission_list'];
                    $screen_list = $rolePermissionData['screen_list'];
                }

                if($role->update(['name' => $request->name, 'slug' => $slug, 'permissions' => $permission_list, 'screens' => $screen_list]))
                {
                    return redirect()->route('roles.index')->with('message', __('messages.update', ['name' => 'Role']));
                }
            }
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
