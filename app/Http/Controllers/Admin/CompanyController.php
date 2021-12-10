<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Company;
use App\Http\Requests\Admin\CompanyRequest;
use App\Http\Controllers\Admin\CustomModuleController;

class CompanyController extends CoreController
{
    protected $module_name;

    protected static $firm_types = [
        'Proprietorship' => 'Proprietorship',
        'Partnership' => 'Partnership',
        'LLP' => 'LLP',
        'Pvt' => 'Pvt',
        'Ltd' => 'Ltd',
        'Ltd' => 'Ltd'
    ]; 

    /**
     * Create the constructor
     *
     */
    public function __construct(CustomModuleController $customObj)
    {
        parent::__construct();
        
        $this->customObj = $customObj;
        $this->module_name = 'company';
    }

    /**
     * Get parent module data list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompanyParentDataList($module)
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
        $companies = Company::all();

        return view('admin.companies.index', ['companies' => $companies]);
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
            $parent_modules = $this->getCompanyParentDataList($module);

            $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();
            $company = Company::find(1);

            return view('admin.companies.create', ['countries' => $countries, 'parent_modules' => $parent_modules, 'module' => $module, 'firm_types' => static::$firm_types, 'company' => $company]);
        }

        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $post = $request->all();
        if($request->file('logo_image')){
            $path = $request->file('logo_image');
            $image = $path->getClientOriginalName();
            $path->move(public_path('images/post_images'), $image);
            $post['logo_image'] = $image;
        }

        if($post)
        {
            $company_id = isset($request->company_id) ? $request->company_id : 1;

            $company = Company::updateOrCreate([
                'id' => $company_id
            ],$post);

            //$company = new Company($post);
            //$company->save()

            if($company)
            {
                return redirect()->back()->with('message', __('messages.update', ['name' => 'Company']));
                //return redirect()->route('companies.index')->with('message', __('messages.update', ['name' => 'Company']));
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
            $company = Company::find($id);

            if($company)
            {
                $module = $this->getModule($this->module_name);

                if(!empty($module))
                {
                    $parent_modules = $this->getCompanyParentDataList($module);
                    $countries = \App\Models\Country::where('active', 1)->pluck('name', 'id')->toArray();

                    return view('admin.companies.edit', ['company' => $company, 'countries' => $countries, 'parent_modules' => $parent_modules, 'module' => $module, 'firm_types' => static::$firm_types]);
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
    public function update(CompanyRequest $request, $id)
    {
        if($id)
        {
            $post = $request->all();

            $company = Company::find($id);

            if($post && $company)
            {
                if($company->update($post))
                {
                    return redirect()->route('companies.index')->with('message', __('messages.update', ['name' => 'Company']));
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
