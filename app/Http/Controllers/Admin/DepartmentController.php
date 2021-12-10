<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Company;
use App\Models\Department;
use App\Http\Requests\Admin\DepartmentRequest;
use App\Http\Controllers\Admin\CustomModuleController;

class DepartmentController extends CoreController
{
    protected $module_name;

    protected static $parent_type = [
        'App\Models\Department' => 'Department',
        'App\Models\Warehouse' => 'Warehuse',
    ];

    /**
     * Create the constructor
     *
     */
    public function __construct(CustomModuleController $customObj)
    {
        parent::__construct();
        
        $this->customObj = $customObj;
        $this->module_name = 'department';
    }

    /**
     * Get parent module data list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDepartmentParentDataList($module)
    {
        $parent_modules = [];

        if(!empty($module) && !empty($module->parent_module))
        {
            $parent_modules = $this->customObj->getParentModuleDataList($module);
        }
        else
        {
            $parent_modules = Company::active()->pluck('name', 'id')->toArray();
        }

        return $parent_modules;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return view('admin.departments.index', ['departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_modules = [];
        $module = $this->getModule($this->module_name);

        if(!empty($module))
        {
            $parent_modules = $this->getDepartmentParentDataList($module);
            $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();

            $departments = \App\Models\Department::where('active', 1)->pluck('name', 'id')->toArray();
            $warehouses = \App\Models\Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

            return view('admin.departments.create', ['countries' => $countries, 'parent_modules' => $parent_modules, 'module' => $module, 'parent_type' => static::$parent_type, 'departments' => $departments, 'warehouses' => $warehouses]);
        }

        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        $post = $request->all();

        if($post)
        {
            $department = new Department($post);

            if($department->save())
            {
                /*if(isset($request->parent_type) && !empty($request->parent_type) && isset($request->parent_unit) && !empty($request->parent_unit))
                {
                    $modal = $request->parent_type;
                    $parent_unit = $modal::find($request->parent_unit);

                    if(isset($parent_unit) && !empty($parent_unit))
                    {
                        $parent_unit->departmentParent()->updateOrCreate(['department_id' => $department->id]);
                    }
                }*/

                return redirect()->route('departments.index')->with('message', __('messages.add', ['name' => 'Department']));
            }
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
            $department = Department::with('parentable')->find($id);

            if($department)
            {
                $module = $this->getModule($this->module_name);

                if(!empty($module))
                {
                    $parent_modules = $this->getDepartmentParentDataList($module);
                    $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();

                    $departments = \App\Models\Department::where('active', 1)->where('id', '!=', $department->id)->pluck('name', 'id')->toArray();
                    $warehouses = \App\Models\Warehouse::where('active', 1)->pluck('name', 'id')->toArray();

                    return view('admin.departments.edit', ['department' => $department, 'countries' => $countries, 'parent_modules' => $parent_modules, 'module' => $module, 'parent_type' => static::$parent_type, 'departments' => $departments, 'warehouses' => $warehouses]);
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
    public function update(DepartmentRequest $request, $id)
    {
        if($id)
        {
            $post = $request->all();

            $department = Department::find($id);

            if($post && $department)
            {
                /*if(isset($request->parent_type) && !empty($request->parent_type) && isset($request->parent_unit) && !empty($request->parent_unit))
                {
                    $modal = $request->parent_type;
                    $parent_unit = $modal::find($request->parent_unit);

                    if(isset($parent_unit) && !empty($parent_unit))
                    {
                        $parent_unit->departmentParent()->updateOrCreate(['department_id' => $department->id]);
                    }
                }*/

                if($department->update($post))
                {
                    return redirect()->route('departments.index')->with('message', __('messages.update', ['name' => 'Department']));
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
}
