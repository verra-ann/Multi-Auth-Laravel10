<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function Index(){
        return view('admin.admin_login');
    }// end method

    public function Dashboard(){
        return view('admin.index');
    }// End Method

    public function Login(Request $request){
        //dd($request->all());   <-----TO CHECK
        $check = $request->all();
        if(Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password'] ]))
        {
            return redirect()->route('admin.dashboard')->with('success', 'Admin Login Successfully!');
        }
        else{
            return back()->with('error', 'Invalid Email or Password.');
        }
    } //End Method

    public function AdminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('login_from')->with('success', 'Admin Logout Successfully!');
    } //End Method

    public function AdminRegister(){
        return view('admin.admin_register');
    } //End Method

    public function AdminRegisterCreate(Request $request){
        //dd($request->all());   //<-----TO CHECK

        Admin::insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);
        return redirect()->route('login_from')->with('success', 'Admin Created Successfully!');
    } //End Method

    public function createNewUser(Request $request){
        //dd($request->all());   //<-----TO CHECK
        Seller::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);
        //return redirect()->route('admin.newUser')->with('success', 'New User Created Successfully!');
        return redirect()->route('admin.newUser')->with('success', 'New User Created Successfully!');
    } //End Method

    public function clientList(Request $id){
        $sellers = Seller::all();
        //dd($sellers);
        return view('admin.client_list', compact('sellers'));
    } // End Method

    public function deleteClient($id){
        $sellers = Seller::find($id)->delete();
        return redirect()->route('admin.deleteClient')->with('success', 'User Deleted Successfully!');
        //return view('admin.clientList')->with('success', 'User Deleted Successfully!');
    } // End Method
}
