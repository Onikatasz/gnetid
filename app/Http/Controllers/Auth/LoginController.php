<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ValidatesRequests;
    public function showLoginForm()
    {
        // Check if the user is already logged in
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Attempt to log the user in
        $credentials = $request->only('username', 'password');
        $remember = $request->input('remember', false); // Default to false if 'remember' is not provided
    
        if (Auth::attempt($credentials, $remember)) {
            // Redirect to the dashboard upon successful login
            return redirect()->route('dashboard');
        }
    
        // Redirect back to the login with the form data and error message
        return back()->withInput($request->only('username', 'remember'))->withErrors([
            'username' => 'Invalid username or password.',
        ]);
    }
}
