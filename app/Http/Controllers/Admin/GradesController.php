<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Grades;
use App\Http\Requests\Admin\GradesRequest;



class GradesController extends CoreController
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

    function index()
    {
        $grades = Grades::all();

        return view('admin.settings.grades.index', ['grades' => $grades]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin.settings.grades.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradesRequest $request)
    {
        $result = Grades::create([
            'grade_name' => $request->grade_name,
        ]);

        if($result)
        {
            return redirect()->route('grades.index')->with('message', __('messages.add', ['name' => 'Grade']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
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
            $grades = Grades::find($id);
            if($grades)
            {
                $grade = Grades::where('active', 1)->where('id', '!=', $id)->pluck('grade_name', 'id')->toArray();
                return view('admin.settings.grades.edit', ['grades' => $grades,'grade' => $grade]);
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
    public function update(GradesRequest $request, $id)
    {
        $data = [
            'grade_name' => $request->grade_name,
        ];

        $group = Grades::find($id);

        if($group)
        {
            if ($group->update($data))
            {
                return redirect()->route('grades.index')->with('message', __('messages.update', ['name' => 'Grades']));
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
        $group = Grades::find($id);

        if ($group)
        {
            $group->delete();

            return redirect()->route('grades.index')->with('message', __('messages.delete', ['name' => 'Grades']));
        }

        return redirect()->back()->with('error', __('messages.somethingWrong'));
    }

}