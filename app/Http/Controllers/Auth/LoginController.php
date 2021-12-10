<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CoreController;
use Illuminate\Http\Request;
use Sentinel;

class LoginController extends CoreController
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
     * $2y$10$z9ijxUkwK8Htdttefsm/nOcv6lBFjeSvyHO7XLtqW.AKETES3c/Cm
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($user = Sentinel::check())
        {
            return redirect()->route('admin.dashboard');
            /*if($user->inRole('admin'))
            {
            }*/
        }

        return view('auth.admin.login');
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
        $data = $request->all();

        try {
            if(Sentinel::authenticate($data))
            {
                $user = Sentinel::getUser();
                // $session_id = \Session::getId();
                // $user_id = $user->id;

                return redirect()->route('admin.dashboard');
            }
            else
            {
                return redirect()->back()->withErrors('Please enter valid credentials.')->withInput();
            }
        }
        catch (ThrottlingException $e){
            $delay = $e->getDelay();

            return redirect()->back()->withErrors(__('auth.throttle', ['seconds' => $delay]))->withInput();
        }
        catch (Exception $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * logout of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        if($user = Sentinel::check())
        {
            Sentinel::logout();
            return redirect()->route('admin.login');
        }
        
        abort(404);
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
