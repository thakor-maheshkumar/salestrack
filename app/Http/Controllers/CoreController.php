<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class CoreController extends Controller
{
    protected $user_table, $admin_roles;

    /**
     * Create the constructor
     *
     */
    public function __construct()
    {   
        $this->user_table = 'users';
        $this->admin_roles = ['admin'];

        $this->access_permissions = [
            'create' => 'Create',
            'edit' => 'Edit',
            'view' => 'View',
            /*'all' => 'All',
            'none' => 'None'*/
        ];

        $modules_menu = \App\Models\Module::where(['is_default_module' => 0, 'type' => 1])->active()->get();
        \View::share(['modules_menu' => $modules_menu]);
    }
    
    /**
     * Get the module of company.
     */
    public function getModule($module_name)
    {
        return \App\Models\Module::where('slug', $module_name)->first();
    }

    /**
     * Delete the multiple post files from server.
     *
     * @param  [array] or [string]
     * @return  void
     */
    public function deleteFiles($oldFile)
    {
        if (is_array($oldFile))
        {
            foreach ($oldFile as $key => $file)
            {
                if(Storage::exists($file))
                {
                    Storage::delete($file);
                }
            }
        }
        else
        {
            if(Storage::exists($oldFile))
            {
                Storage::delete($oldFile);
            }
        }

        return true;
    }
    
}
