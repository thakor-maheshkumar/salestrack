<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\User;
use Sentinel;
use App\Http\Requests\Admin\UserRequest;
use App\Models\PermissionScreen;
use App\Models\UserPermission;
use App\Permissions\DefaultPermission;
use App\Models\States;

class UserController extends CoreController
{
    protected static $gender = [
        'Male' => 'Male',
        'Female' => 'Female',
        'Not Specified' => 'Not Specified'
    ];

    protected static $suffix_list = [
        'Mr.' => 'Mr.',
        'Mrs.' => 'Mrs.',
        'Miss' => 'Miss',
    ]; 

    /**
     * Create the constructor
     *
     */
    public function __construct(DefaultPermission $defaultPermissionObj)
    {
        parent::__construct();
        $this->defaultPermissionObj = $defaultPermissionObj;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Sentinel::getUser();
        $users = User::with('country')->whereHas('roles', function($query) {
                    $query->where('slug', '!=', 'admin');
                 })->where('id', '!=', $user->id)->get();
        

        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$screens = \App\Models\PermissionScreen::active()->pluck('name', 'id')->toArray();

        $roles = Sentinel::getRoleRepository()->whereNotIn('slug', $this->admin_roles)->pluck('name', 'id')->toArray();
        $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();
        $companies = \App\Models\Company::where('active', 1)->pluck('name', 'id')->toArray();
        $departments = \App\Models\Department::where('active', 1)->pluck('name', 'id')->toArray();
        $states = States::where('active', 1)->pluck('state','state')->toArray();
        //$hierarchy_list = $this->getModuleData();

        if(!empty($roles))
        {
            return view('admin.user.create', ['roles' => $roles,'states'=>$states, 'gender' => static::$gender, 'suffix_list' => static::$suffix_list, 'countries' => $countries, 'companies' => $companies, 'departments' => $departments, 'permissions' => $this->access_permissions]);
        }

        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $credential = [
            'company_id' => isset($request->company_id) ? $request->company_id : NULL,
            'suffix' => isset($request->suffix) ? $request->suffix : NULL,
            'name' => isset($request->first_name) ? $request->first_name : NULL,
            'first_name' => isset($request->first_name) ? $request->first_name : NULL,
            'middle_name' => isset($request->middle_name) ? $request->middle_name : NULL,
            'last_name' => isset($request->last_name) ? $request->last_name : NULL,
            'sex' => isset($request->sex) ? $request->sex : NULL,
            'date_of_birth' => isset($request->date_of_birth) ? $request->date_of_birth : NULL,
            'landline_no' => isset($request->landline_no) ? $request->landline_no : NULL,
            'mobile_no' => isset($request->mobile_no) ? $request->mobile_no : NULL,
            'email' => $request->email,
            'password' => $request->password,
            'address' => isset($request->address) ? $request->address : NULL,
            'address_1' => isset($request->address_1) ? $request->address_1 : NULL,
            'landmark' => isset($request->landmark) ? $request->landmark : NULL,
            'city' => isset($request->city) ? $request->city : NULL,
            'state' => isset($request->state) ? $request->state : NULL,
            'country_id' => isset($request->country_id) ? $request->country_id : NULL,
            'pincode' => isset($request->pincode) ? $request->pincode : NULL,
            /*'user_type' => isset($request->role) ? $request->role : NULL,
            'is_manager' => (isset($request->is_manager) && $request->is_manager == 1) ? 1 : 0,
            'dept_id' => isset($request->dept_id) ? $request->dept_id : NULL,*/
            'pan_no' => isset($request->pan_no) ? $request->pan_no : NULL,
            'aadhar_no' => isset($request->aadhar_no) ? $request->aadhar_no : NULL,
            'id_card' => isset($request->id_card) ? $request->id_card : NULL,
            'bank_name' => isset($request->bank_name) ? $request->bank_name : NULL,
            'bank_acc_no' => isset($request->bank_acc_no) ? $request->bank_acc_no : NULL,
            'bank_ifsc' => isset($request->bank_ifsc) ? $request->bank_ifsc : NULL,
            'valid_till' => isset($request->valid_till) ? $request->valid_till : NULL,
            'pf_no' => isset($request->pf_no) ? $request->pf_no : NULL,
            'employee_code' => isset($request->employee_code) ? $request->employee_code : NULL
        ];

        if ($request->file('photo'))
        {
            $credential['photo'] = \Storage::put('avatars', $request->file('photo'));
        }

        if ($request->file('pan_photo'))
        {
            $credential['pan_photo'] = \Storage::put('pancard', $request->file('pan_photo'));
        }

        if ($request->file('aadhar_photo'))
        {
            $credential['aadhar_photo'] = \Storage::put('aadhar-card', $request->file('aadhar_photo'));
        }

        if ($request->file('bank_document'))
        {
            $credential['bank_document'] = \Storage::put('bank-document', $request->file('bank_document'));
        }

        try {
            $user = Sentinel::registerAndActivate($credential);

            if ($user)
            {
                $permission_list = $user_permission = [];

                if(isset($request->roles) && isset($request->permission) && isset($request->expiry_date) && !empty($request->roles) && !empty($request->permission) && !empty($request->expiry_date) && (count($request->roles) == count($request->permission)))
                {
                    $userPermissionData = $this->defaultPermissionObj->getUserPermission($user, $request->roles, $request->permission, $request->start_date, $request->expiry_date);

                    $user->roles()->sync($request->roles);

                    if(!empty($userPermissionData['permission_list']))
                    {
                        $user->permissions = $userPermissionData['permission_list'];
                        $user->save();
                    }
                    if(!empty($userPermissionData['user_permission']))
                    {
                        //\DB::table('user_permission')->insert($userPermissionData['user_permission']);
                        foreach ($userPermissionData['user_permission'] as $key => $upermission)
                        {
                            $createdOrUpdated = UserPermission::updateOrCreate([
                                'user_id' => $upermission['user_id'],
                                'role_id' => $upermission['role_id']
                            ], $upermission);
                        }
                    }

                    /*foreach ($request->roles as $key_1 => $role_id) {
                        $role = Sentinel::findRoleById($role_id);
                        $role_permission_list = [];

                        if($role)
                        {
                            $role->users()->attach($user);

                            if(!empty($role->screens))
                            {
                                foreach ($role->screens as $key_2 => $screen) {
                                    $screen_key = array_search($screen, array_column($screens_data, 'id'));
                                    if(isset($screens_data[$screen_key]))
                                    {
                                        foreach ($request->permission[$key_1] as $key_3 => $permission) 
                                        {
                                            if(isset($screens_data[$screen_key][$permission]) && !empty($screens_data[$screen_key][$permission]))
                                            {
                                                $all_permissions = array_values(explode(',',$screens_data[$screen_key][$permission]));
                                                
                                                foreach ($all_permissions as $key_4 => $temp_permission) {
                                                    $permission_list[$temp_permission] = true;
                                                    $role_permission_list[$temp_permission] = true;
                                                }
                                            }
                                        }
                                    }
                                }

                                if(isset($request->start_date[$key_1]) && isset($request->expiry_date[$key_1]))
                                {
                                    $user_permission[] = [
                                        'user_id' => $user->id,
                                        'role_id' => $role_id,
                                        'start_date' => $request->start_date[$key_1],
                                        'expiry_date' => $request->expiry_date[$key_1],
                                        'role_permissions' => json_encode($role_permission_list),
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                    ];
                                }
                            }
                        }
                    }*/ 
                }

                if(isset($request->departments) && !empty($request->departments))
                {
                    $to_update = [];
                    foreach ($request->departments as $key => $user_dept)
                    {
                        if(isset($user_dept['department']) && $user_dept['start_date'] && $user_dept['end_date'])
                        {
                            $to_update[$user_dept['department']] = [
                                'start_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $user_dept['start_date'])->format('Y-m-d'),
                                'end_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $user_dept['end_date'])->format('Y-m-d'),
                                'is_manager' => isset($user_dept['is_manager']) ? 1 : 0
                            ];
                        }
                    }
                   
                   
                    if(!empty($to_update))
                    {
                        $user->departments()->attach($to_update);
                    }
                }

                return redirect()->route('users.index')->with('message', __('messages.add', ['name' => 'User']));
            }

            return redirect()->back()->with('error', __('messages.somethingWrong'));
        }
        catch (Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($id)
        {
            $login_user = Sentinel::getUser();

            $user = User::whereHas('roles', function($query){
                $query->where('slug', '!=', 'admin');
            })->where('id', '!=', $login_user->id)->find($id);
            $states = States::where('active', 1)->pluck('state','state')->toArray();

            if($user)
            {
                $roles = Sentinel::getRoleRepository()->whereNotIn('slug', $this->admin_roles)->pluck('name', 'id')->toArray();
                $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();
                $companies = \App\Models\Company::where('active', 1)->pluck('name', 'id')->toArray();
                $departments = \App\Models\Department::where('active', 1)->pluck('name', 'id')->toArray();

                $screens_data = PermissionScreen::active()->get()->toArray();
                $user_permission = \App\Models\UserPermission::where('user_id', $user->id)->get();

                $screens = [];
                $selected_permissions = $user_permission_expiry = $user_permission_start = [];

                if(isset($user_permission) && $user_permission->isNotEmpty())
                {
                    foreach ($user_permission as $key_1 => $upermission) 
                    {
                        if(!empty($upermission->role_permissions))
                        {
                            //pred($upermission->role_permissions);
                            foreach ($upermission->role_permissions as $permissionKey => $permission)
                            {
                                foreach ($screens_data as $key_2 => $item) {
                                    $success = 0;
                                    foreach ($item as $pKey => $value_1) {
                                        if (false !== stripos($value_1, $permissionKey))
                                        {
                                            $selected_permissions[$upermission->role_id] = isset($selected_permissions[$upermission->role_id]) ? $selected_permissions[$upermission->role_id] : [];

                                            $selected_permissions[$upermission->role_id][] = $pKey;
                                            $selected_permissions[$upermission->role_id] = array_unique($selected_permissions[$upermission->role_id]);

                                            $success = 1;
                                            break;
                                        }
                                    }

                                    if($success)
                                        break;
                                }

                                $expiry_date = (!empty($upermission->expiry_date)) ? \Carbon\Carbon::parse($upermission->expiry_date)->format('d/m/Y') : '';
                                $start_date = (!empty($upermission->start_date)) ? \Carbon\Carbon::parse($upermission->start_date)->format('d/m/Y') : '';

                                $user_permission_expiry[$upermission->role_id] = $expiry_date;
                                $user_permission_start[$upermission->role_id] = $start_date;
                            }
                        }
                    }
                }
                
                if(!empty($roles))
                {
                    return view('admin.user.edit', ['user' => $user,'states' => $states,'roles' => $roles, 'gender' => static::$gender, 'suffix_list' => static::$suffix_list, 'countries' => $countries, 'companies' => $companies, 'departments' => $departments, 'permissions' => $this->access_permissions, 'selected_permissions' => $selected_permissions, 'user_permission_expiry' => $user_permission_expiry, 'user_permission_start' => $user_permission_start]);
                }
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
    public function update(UserRequest $request, $id)
    {
        if($id)
        {
            $user = User::find($id);

            if($user)
            {
                $credential = $request->all();

                if ($request->file('photo'))
                {
                    if($user->photo)
                    {
                        $this->deleteFiles($user->photo);
                    }

                    $credential['photo'] = \Storage::put('avatars', $request->file('photo'));
                }

                if ($request->file('pan_photo'))
                {
                    if($user->pan_photo)
                    {
                        $this->deleteFiles($user->pan_photo);
                    }

                    $credential['pan_photo'] = \Storage::put('pancard', $request->file('pan_photo'));
                }

                if ($request->file('aadhar_photo'))
                {
                    if($user->aadhar_photo)
                    {
                        $this->deleteFiles($user->aadhar_photo);
                    }

                    $credential['aadhar_photo'] = \Storage::put('aadhar-card', $request->file('aadhar_photo'));
                }

                if ($request->file('bank_document'))
                {
                    if($user->bank_document)
                    {
                        $this->deleteFiles($user->bank_document);
                    }

                    $credential['bank_document'] = \Storage::put('bank-document', $request->file('bank_document'));
                }

                if ($request->has('password') && !empty($request->password))
                {
                    $credential['password'] = $request->password;
                }
                else if($request->has('password') && empty($request->password))
                {
                    unset($credential['password']);
                }

                /*$credential['user_type'] = isset($request->role) ? $request->role : NULL;*/
                $credential['is_manager'] = (isset($request->is_manager) && $request->is_manager == 1) ? 1 : 0;

                //$screens_data = PermissionScreen::active()->get()->toArray();
                $permission_list = $user_permission = [];

                if(isset($request->roles) && isset($request->permission) && isset($request->start_date) && isset($request->expiry_date) && !empty($request->roles) && !empty($request->permission) && !empty($request->start_date) && !empty($request->expiry_date) && (count($request->roles) == count($request->permission)))
                {
                    $userPermissionData = $this->defaultPermissionObj->getUserPermission($user, $request->roles, $request->permission, $request->start_date, $request->expiry_date);

                    if(!empty($userPermissionData['permission_list']))
                    {
                        $user->permissions = $userPermissionData['permission_list'];
                        $user->save();
                    }
                    if(!empty($userPermissionData['user_permission']))
                    {
                        $usersPermissionToDelete = UserPermission::where('user_id', $user->id)->pluck('id', 'id');

                        foreach ($userPermissionData['user_permission'] as $key => $upermission)
                        {
                            $createdOrUpdated = UserPermission::updateOrCreate([
                                'user_id' => $upermission['user_id'],
                                'role_id' => $upermission['role_id']
                            ], $upermission);

                            if(!empty($usersPermissionToDelete[$createdOrUpdated->id])) {
                                unset($usersPermissionToDelete[$createdOrUpdated->id]);
                            }
                        }

                        if (count($usersPermissionToDelete)) {
                            UserPermission::whereIn('id', $usersPermissionToDelete)->delete();

                            /*UserPermission::whereRaw(sprintf('id IN (%s)', implode(',', $usersPermissionToDelete)))->delete();*/
                        }
                    }

                    /*foreach ($request->roles as $key_1 => $role_id) {
                        $role = Sentinel::findRoleById($role_id);
                        $role_permission_list = [];

                        if($role)
                        {
                            //$role->users()->attach($user);
                            if(!empty($role->screens))
                            {
                                foreach ($role->screens as $key_2 => $screen) {
                                    $screen_key = array_search($screen, array_column($screens_data, 'id'));
                                    if(isset($screens_data[$screen_key]))
                                    {
                                        foreach ($request->permission[$key_1] as $key_3 => $permission) 
                                        {
                                            if(isset($screens_data[$screen_key][$permission]) && !empty($screens_data[$screen_key][$permission]))
                                            {
                                                $all_permissions = array_values(explode(',',$screens_data[$screen_key][$permission]));
                                                
                                                foreach ($all_permissions as $key_4 => $temp_permission) {
                                                    $permission_list[$temp_permission] = true;
                                                    $role_permission_list[$temp_permission] = true;
                                                }
                                            }
                                        }
                                    }
                                }

                                if(isset($request->start_date[$key_1]) && isset($request->expiry_date[$key_1]))
                                {
                                    $user_permission[] = [
                                        'user_id' => $user->id,
                                        'role_id' => $role_id,
                                        'start_date' => $request->start_date[$key_1],
                                        'expiry_date' => $request->expiry_date[$key_1],
                                        'role_permissions' => $role_permission_list,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                    ];
                                }
                            }
                        }
                    }*/
                }

                if(isset($request->departments) && !empty($request->departments))
                {
                    $to_update = [];
                    foreach ($request->departments as $key => $user_dept)
                    {
                        if(isset($user_dept['department']) && $user_dept['start_date'] && $user_dept['end_date'])
                        {
                            $to_update[$user_dept['department']] = [
                                'start_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $user_dept['start_date'])->format('Y-m-d'),
                                'end_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $user_dept['end_date'])->format('Y-m-d'),
                                'is_manager' => isset($user_dept['is_manager']) ? 1 : 0
                            ];
                        }
                    }
                    if(!empty($to_update))
                    {
                        $user->departments()->sync($to_update);
                    }
                }

                if(Sentinel::update($user, $credential))
                {
                    if(isset($request->roles) && !empty($request->roles))
                    {
                        //pred($request->roles);
                        $user->roles()->sync($request->roles);
                            /*
                        // Get the user roles
                        $userRoles = $user->roles->pluck('id')->toArray();
                        $roles = $request->roles;

                        // Prepare the roles to be added and removed
                        $toAdd = array_diff($roles, $userRoles);
                        $toDel = array_diff($userRoles, $roles);

                        // Detach the user roles
                        if (! empty($toDel)) {
                            $user->roles()->detach($toDel);
                        }

                        // Attach the user roles
                        if (! empty($toAdd)) {
                            $user->roles()->attach($toAdd);
                        }*/
                    }

                    return redirect()->route('users.index')->with('message', __('messages.update', ['name' => 'User']));
                }
            }

            return redirect()->back()->with('error', __('messages.somethingWrong'));
        }

        abort(404);
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

    public function buildTree(array $elements, $parentIdKey = 'parent_module', $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element[$parentIdKey] == $parentId) {
                $children = $this->buildTree($elements, $parentIdKey, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function buildTempSubTree(&$final_tree_1)
    {
        if(isset($final_tree_1['module_id']))
        {
            $child_module = \App\Models\Module::where('parent_module', $final_tree_1['module_id'])->active()->select('id', 'name', 'parent_module', 'table', 'type')->get();

            if($child_module->isNotEmpty())
            {
                foreach ($child_module as $nkey => $child_module_1)
                {
                    $customModule = new \App\Models\CustomModule;
                    $customModule->setTable($child_module_1['table']);

                    $module_data = $customModule->where('active', 1)->where('parent_unit', $final_tree_1['id'])->select('id', 'name', 'parent_unit', 'module_id')->get()->toArray();
                    if(!empty($module_data))
                    {
                        $final_tree_1['children'] = (isset($final_tree_1['children'])) ? $final_tree_1['children'] : [];

                        $final_tree_1['children'] = array_merge($final_tree_1['children'], $module_data);
                    }
                }
            }
        }

        return $final_tree_1;
    }

    public function buildTempChildSubTree(&$final_tree_1)
    {
        if(isset($final_tree_1['children']) && !empty($final_tree_1['children']))
        {
            foreach ($final_tree_1['children'] as $key_2 => &$final_tree_2) {
                $children_node = $this->buildTempSubTree($final_tree_2);
                $final_tree_1['children'][$key_2] = $children_node;
                $children_node_test = $this->buildTempChildSubTree($children_node);
                if ($children_node_test) {
                    $final_tree_1['children'][$key_2] = $children_node_test;
                }
            }
            //pred($final_tree_2);
        }
        return $final_tree_1;
    }

    public function getModuleData() {
        $modules = \App\Models\Module::where('slug', '!=', 'country')->active()->select('id', 'name', 'parent_module', 'table', 'type')->get();

        if(!empty($modules))
        {
            $module_data = $modules->toArray();
            $module_tree = $this->buildTree($module_data);

            $final_tree_data = [];

            //pred($module_tree);

            foreach ($module_tree as $key => &$tree_1) 
            {
                $customModule = new \App\Models\CustomModule;
                $customModule->setTable($tree_1['table']);

                $module_data = $customModule->where('active', 1)->select('id', 'name', 'parent_unit', 'module_id')->get()->toArray();
                $final_tree = $this->buildTree($module_data, 'parent_unit');

                if(!empty($final_tree))
                {
                    $hierarchy_list = [];
                    $final_tree_result = $final_tree;
                    foreach ($final_tree as $key_1 => $final_tree_1) {
                        # code...
                        $final_tree_result = $this->buildTempSubTree($final_tree_1);
                        $hierarchy_list[$key_1] = $final_tree_result;
                        if(isset($final_tree_result['children']))
                        {
                            //echo "final_tree_result"; pred($final_tree_result);
                            $hierarchy_list[$key_1] = $this->buildTempChildSubTree($final_tree_result);
                        }
                    }
                    
                    /*foreach ($final_tree as $fkey => &$final_tree_1) 
                    {
                        if(isset($final_tree_1['module_id']))
                        {
                            $child_module = \App\Models\Module::where('parent_module', $final_tree_1['module_id'])->active()->select('id', 'name', 'parent_module', 'table', 'type')->get();

                            if($child_module->isNotEmpty())
                            {
                                foreach ($child_module as $nkey => $child_module_1)
                                {
                                    $customModule = new \App\Models\CustomModule;
                                    $customModule->setTable($child_module_1['table']);

                                    $module_data = $customModule->where('active', 1)->where('parent_unit', $final_tree_1['id'])->select('id', 'name', 'parent_unit', 'module_id')->get()->toArray();
                                    if(!empty($module_data))
                                    {
                                        $final_tree[$fkey]['children'] = array_merge($final_tree_1['children'], $module_data);
                                    }
                                }
                            }
                        }
                        if(isset($final_tree_1['children']))
                        {
                            foreach ($final_tree_1['children'] as $fkey_2 => &$final_tree_2) 
                            {
                                //pred($final_tree, $final_tree_1['children']);
                                $child_module = \App\Models\Module::where('parent_module', $final_tree_2['module_id'])->active()->select('id', 'name', 'parent_module', 'table', 'type')->get();

                                if($child_module->isNotEmpty())
                                {
                                    foreach ($child_module as $nkey => $child_module_1)
                                    {
                                        $customModule = new \App\Models\CustomModule;
                                        $customModule->setTable($child_module_1['table']);

                                        $module_data = $customModule->where('active', 1)->where('parent_unit', $final_tree_2['id'])->select('id', 'name', 'parent_unit', 'module_id')->get()->toArray();
                                        if(!empty($module_data))
                                        {
                                            $final_tree_2['children'] = (isset($final_tree_2['children'])) ? $final_tree_2['children'] : [];
                                        
                                            $final_tree_2['children'] = array_merge($final_tree_2['children'], $module_data);
                                        }
                                    }
                                }

                                if(isset($final_tree_2) && !empty($final_tree_2))
                                {
                                    if(isset($final_tree_2['children']))
                                    {
                                        foreach ($final_tree_2['children'] as $fkey_3 => &$final_tree_3) 
                                        {
                                            //pred($final_tree, $final_tree_1['children']);
                                            $child_module = \App\Models\Module::where('parent_module', $final_tree_3['module_id'])->active()->select('id', 'name', 'parent_module', 'table', 'type')->get();

                                            if($child_module->isNotEmpty())
                                            {
                                                foreach ($child_module as $nkey => $child_module_1)
                                                {
                                                    $customModule = new \App\Models\CustomModule;
                                                    $customModule->setTable($child_module_1['table']);

                                                    $module_data = $customModule->where('active', 1)->where('parent_unit', $final_tree_3['id'])->select('id', 'name', 'parent_unit', 'module_id')->get()->toArray();
                                                    if(!empty($module_data))
                                                    {
                                                        $final_tree_3['children'] = (isset($final_tree_3['children'])) ? $final_tree_3['children'] : [];
                                                    
                                                        $final_tree_3['children'] = array_merge($final_tree_3['children'], $module_data);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                //pred($final_tree);
                            }
                        }
                    }*/
                }

                $final_tree_data[] = $final_tree;
            }
        }

        //pred($final_tree, $hierarchy_list);
    }
}
