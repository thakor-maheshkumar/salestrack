<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\CustomModule;
use App\Models\Module;
use App\Traits\CustomDatabaseService;

class CustomModuleController extends CoreController
{
    use CustomDatabaseService;

    protected static $exceptColumns = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'module_id',
        'status',
        'active'
    ];

    /**
     * Create the constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        if($slug)
        {
            $module = Module::where('slug', $slug)->first();

            if($module && !empty($module))
            {
                $customModule = new CustomModule;
                $customModule->setTable($module->table);

                $moduleRows = $customModule->get()->toArray();

                return view('admin.custom-module.index', ['module' => $module, 'moduleRows' => $moduleRows, 'exceptColumns' => self::$exceptColumns]);
            }
        }

        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        if($slug)
        {
            $module = Module::where('slug', $slug)->first();

            if($module && !empty($module))
            {
                $moduleColumns = $this->getTableColumns($module->table);
                //pred($moduleColumns);
                return view('admin.custom-module.create', ['module' => $module, 'moduleColumns' => $moduleColumns, 'exceptColumns' => self::$exceptColumns]);
            }
        }

        abort(404);
    }

    /**
     * Get parent module data list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getParentModuleDataList($module)
    {
        $parent_modules = [];

        if(isset($module->parent_unit_module) && !empty($module->parent_unit_module))
        {
            $customModule = new CustomModule;
            $customModule->setTable($module->parent_unit_module->table);

            $parent_modules = $customModule->active()->pluck('name', 'id')->toArray();
        }

        return $parent_modules;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
