<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\UserController;

class UserController extends Controller
{
    public function NewClient(Request $request){
        $user = User::where('user', '=', $request->input('user'))->first();
        
        if($user === null){  //ToDo List does not exist  
            $user = new user;
            $user->user = $request->user;
            $user->save();                          
            return redirect('/')->with('success', 'New To-Do Added Successfully!');
        }
        else{
            //task exists
            return redirect('/')->with('error', 'To-Do Already Exists.');
        }
    }
}
