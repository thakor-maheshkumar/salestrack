<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\ModuleRelationship;
use App\Rules\Tablename;
use App\Rules\ColumnName;

class ModuleRelationController extends CoreController
{
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'module_id' => 'required',
            'module_table' => ['bail', 'required'],
            'relationships' => 'required_without:new_relationships|array',
            'relationships.*.table_column' => ['required_with:new_relationships', new ColumnName($request->module_table, 'exists')],
            'relationships.*.rel_table' => ['required_with:new_relationships', new Tablename('exists')],
            'relationships.*.rel_table_column' => ['required_with:new_relationships'],
            'new_relationships' => 'required_without:relationships|array',
            'new_relationships.*.table_column' => ['required_with:new_relationships', new ColumnName($request->module_table, 'exists')],
            'new_relationships.*.rel_table' => ['required_with:new_relationships', new Tablename('exists')],
            'new_relationships.*.rel_table_column' => ['required_with:new_relationships'],
        ]);

        if(isset($request->relationships) && !empty($request->relationships))
        {
            foreach ($request->relationships as $relation_id => $relation)
            {
                $moduleRelationship = ModuleRelationship::find($relation_id);

                if($moduleRelationship)
                {
                    $data = [
                        'module_id' => $request->module_id,
                        'table' => $request->module_table,
                        'table_column' => $relation['table_column'],
                        'related_table' => $relation['rel_table'],
                        'related_table_column' => $relation['rel_table_column']
                    ];

                    if(! $moduleRelationship->update($data))
                    {
                        return redirect()->back()->with('error', __('messages.somethingWrong'));
                    }
                }
            }
            $all_relationships = array_keys($request->relationships);

            ModuleRelationship::where('module_id', $request->module_id)->whereNotIn('id', $all_relationships)->delete();
        }
        else if(isset($request->new_relationships) && !empty($request->new_relationships) && (!(isset($request->relationships)) || empty($request->relationships)))
        {
            // delete all relationship
            ModuleRelationship::where('module_id', $request->module_id)->delete();
        }
        else {
            return redirect()->back()->with('error', __('messages.somethingWrong'));
        }

        if(isset($request->new_relationships) && !empty($request->new_relationships))
        {
            foreach ($request->new_relationships as $key => $new_relation) {
                $result = ModuleRelationship::updateOrCreate([
                    'module_id' => $request->module_id,
                    'table' => $request->module_table,
                    'table_column' => $new_relation['table_column'],
                    'related_table' => $new_relation['rel_table'],
                    'related_table_column' => $new_relation['rel_table_column']
                ]);
            }
        }

        return redirect()->route('modules.index')->with('message', __('messages.update', ['name' => 'Module relationship']));

        /*return redirect()->back()->with('error', __('messages.somethingWrong'));*/
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
