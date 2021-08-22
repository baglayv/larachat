<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userAuthId =  auth()->user()->id;

        #$usersList = User::whereNotIn('id', $userCurrentId)->get();

        // Выбираю в список всех юзеров, кроме авторизованного
        $usersList = User::where('id', '!=',$userAuthId)->get();
        
        return view('home', compact('usersList', 'userAuthId'));
        //return view('home', compact('userCurrentId'));
        //dd($userCurrentId);
        //dd($usersList);
    }


}
