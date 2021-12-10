<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Rules\Tablename;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\CustomDatabaseService;
use App\Services\Slug;
use Sentinel;

class ModuleController extends CoreController
{
    use CustomDatabaseService;
    
    protected static $types = [
        '1' => 'Custom',
        '2' => 'User'
    ];

    protected static $data_types = [
        'string' => 'string',
        'text' => 'text',
        'unsignedBigInteger' => 'unsignedBigInteger',
        'integer' => 'integer',
        'dateTime' => 'dateTime',
    ];

    /**
     * Create the constructor
     *
     */
    public function __construct(Slug $slugObj)
    {
        parent::__construct();
        
        $this->slugObj = $slugObj;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::get();

        return view('admin.modules.index', ['modules' => $modules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::pluck('name', 'id')->toArray();

        return view('admin.modules.create', ['types' => static::$types, 'data_types' => static::$data_types, 'modules' => $modules]);
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
            'name' => 'required|unique:modules,name',
            'alias' => 'required|unique:modules,alias',
            'type' => 'bail|required|in:1,2',
            'table' => ['required_if:type,1', new Tablename],
            'parent_module' => 'required_if:type,1|nullable|exists:modules,id'
        ]);

        $post = $request->all();

        if($post)
        {
            $post['table'] = ($request->type == 2) ? 'users' : $request->table;

            $has_error = true;
            if($request->type == 1)
            {
                if(!empty($request->column_name) && !empty($request->column_type) && (count($request->column_name) == count($request->column_type)))
                {
                    $fields = [];
                    foreach ($request->column_name as $key => $column) {
                        $fields[] = [
                            'name' => $column,
                            'type' => $request->column_type[$key]
                        ];
                    }
                    $fields[] = [
                        'name' => 'module_id',
                        'type' => 'unsignedBigInteger'
                    ];
                    $fields[] = [
                        'name' => 'active',
                        'type' => 'integer',
                        'default' => 1
                    ];

                    $result = $this->createTable($request->table, $fields);

                    if($result)
                    {
                        $has_error = false;
                    }
                }
            }
            else
            {
                $slug = $this->slugObj->createSlug($request->name, 'roles');

                if($slug)
                {
                    $role = Sentinel::getRoleRepository()->createModel()->create([
                        'name' => $request->name,
                        'slug' => $slug,
                    ]);

                    $has_error = false;
                }
            }
            
            if(! $has_error)
            {
                $module_slug = $this->slugObj->createSlug($request->name, 'modules');
                $post['slug'] = ($module_slug) ? $module_slug : $request->name;

                $module = new Module($post);

                if($module->save())
                {
                    return redirect()->route('modules.index')->with('message', __('messages.add', ['name' => 'Module']));
                }
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
        if($id)
        {
            $module = Module::with('module_relationships')->find($id);

            if($module)
            {
                $columns = $table_columns = $rel_tables = [];
                if($module->type == 1)
                {
                    $columns = $this->getTableColumns($module->table);

                    //$columns = \DB::select(\DB::raw('SHOW FIELDS FROM '.$module->table));

                    if(!empty($columns))
                    {
                        $table_columns = array_column($columns, "Field", "Field");

                        $rel_tables = Module::distinct()->pluck('table', 'table')->toArray();
                        if(!empty($rel_table))
                        {
                            if(! in_array($this->user_table, $rel_table))
                            {
                                $rel_tables[] = $this->user_table;
                            }
                        }
                    }
                }

                return view('admin.modules.show', ['types' => static::$types, 'module' => $module, 'columns' => $columns, 'table_columns' => $table_columns, 'rel_tables' => $rel_tables]);
            }
        }

        abort(404);
    }

    /**
     * Get tabel columns from the database 
     * 
     * @param $table_name
     *
     * @return array $fields
     */
    public function getRealtedTableColumns($table_name)
    {
        //$columns = $this->getTableColumns($table_name);
        $columns = Schema::getColumnListing($table_name);

        if(!empty($columns))
        {
            return response()->json(['success' => true, 'columns' => $columns], 200);
        }

        return response()->json(['success' => false], 400);
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
            $module = Module::with('module_relationships')->find($id);

            if($module)
            {
                $modules = Module::pluck('name', 'id')->toArray();

                return view('admin.modules.edit', ['types' => static::$types, 'module' => $module, 'modules' => $modules]);
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
            'name' => 'required|unique:modules,name,'.$id,
            'alias' => 'required|unique:modules,alias,'.$id,
            'type' => 'bail|required|in:1,2',
            'parent_module' => 'nullable|exists:modules,id'
        ]);

        $post = $request->all();
        $module = Module::find($id);

        if($post && $module)
        {
            $module_slug = $this->slugObj->createSlug($request->name, 'modules', 'slug', $module->id);
            $post['slug'] = ($module_slug) ? $module_slug : $request->name;

            if($module->update($post))
            {
                return redirect()->route('modules.index')->with('message', __('messages.update', ['name' => 'Module']));
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
