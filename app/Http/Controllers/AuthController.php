<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
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
    public function store(LoginRequest $request)
    {       
        $username = strtoupper($request['username']);
        $password = $request['password'];
        $remember = $request->filled('remember');
    
        if (Auth::attempt(['username' => $username, 'password' => $password, 'activo' => 'SI'], $remember))
        {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        else if (Auth::attempt(['username' => $username, 'password' => $password, 'activo' => 'NO']))
            {
                Session::flash('message','El Usuario Se Encuentra Inactivo');
                return redirect("login")->withInput();
            }

        Session::flash('message','Los Datos Ingresados Son incorrectos');
        return redirect("login")->withInput();

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

    public function logout(Request $request)
    {
       
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();

        return Redirect('login');
    }

}
