<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        // Shop data from middleware
        $shop = $request->shop;
        if($shop){
            return view('auth.login', [
                'title' => 'Login',
                'shop' => $shop, // Pass shop data to the view
            ]);
        }else{
            return view('auth.supper_login', [
                'title' => 'Supper Admin Login',
            ]);
        }

    }

    public function authenticate(Request $request)
    {
        // Shop data from middleware
        $shop = $request->shop;

        // Validate credentials
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if($shop){
            // Check if the user belongs to the shop
            $user = User::where('email', $credentials['email'])->where('shop_id', $shop->id)->first();
        }else{
            $user = User::where('email', $credentials['email'])->where('is_super_admin', 1)->first();
        }


        if ($user && Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if($shop){
                Alert::success('Success', 'Login success!');
                return redirect()->intended($shop->name . '/admin/dashboard');
            }else{
                Alert::success('Success', 'Login success!');
                return redirect()->intended('/admin/dashboard');
            }
        } else {
            if($shop){
                Alert::error('Error', 'Login failed!');
                return redirect($shop->name . '/admin/');
            }else{
                Alert::error('Error', 'Login failed!');
                return redirect('/admin/');
            }

        }
    }

    public function register(Request $request)
    {
        // Shop data from middleware
        $shop = $request->shop;

        return view('auth.register', [
            'title' => 'Register',
            'shop' => $shop, // Pass shop data to the view
        ]);
    }

    public function process(Request $request)
    {
        // Shop data from middleware
        $shop = $request->shop;

        // Validate request
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'passwordConfirm' => 'required|same:password'
        ]);

        // Hash password
        $validated['password'] = Hash::make($request['password']);
        $validated['shop_id'] = $shop->id; // Assign shop ID to the user

        // Create the user
        $user = User::create($validated);

        Alert::success('Success', 'Register user has been successfully!');
        return redirect($shop->name . '/admin/');
    }

    public function logout(Request $request)
    {
        $shop = $request->shop;

        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if($shop){
            Alert::success('Success', 'Log out success!');
            return redirect($request->shop->name . '/admin/'); // Redirect to the shop's admin login
        }else{
            Alert::success('Success', 'Log out success!');
            return redirect('/admin/'); // Redirect to the shop's admin login
        }

    }
}
