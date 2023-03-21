<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function Index(){
        return view('seller.seller_login');
    }// End Method

    public function SellerDashboard(){
        return view('seller.index');
    }// End Method

    public function SellerLogin(Request $request){
        //dd($request->all());
        $check = $request->all();
        if(Auth::guard('seller')->attempt(['email' => $check['email'], 'password' => $check['password'] ]))
        {
            return redirect()->route('seller.dashboard')->with('error', 'User Login Successfully!');
        }else{
            return back()->with('error', 'Invalid Email or Password.');
        }
    }

    public function SellerRegister(){
        return view('seller.seller_register');
    } //End Method

    public function SellerRegisterCreate(Request $request){
        //dd($request->all()); <-- TO CHECK

        Seller::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);
        return redirect()->route('seller_login_from')->with('success', 'Seller Created Successfully!');
    }

    public function SellerLogout(){
        Auth::guard('seller')->logout();
        return redirect()->route('seller_login_from')->with('success', 'Seller Logout Successfully!');
    } //End Method
}
