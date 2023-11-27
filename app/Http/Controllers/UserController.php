<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    public function signup(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least :min characters.',
            'password.letters' => 'The password must contain at least one letter.',
            'password.mixed_case' => 'The password must contain both uppercase and lowercase letters.',
            'password.numbers' => 'The password must contain at least one number.',
            'password.symbols' => 'The password must contain at least one symbol.',
            'password.uncompromised' => 'The password has been compromised and should be changed for security reasons.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'created_at' => now(),
        ];

        $data['password'] = Hash::make($data['password']);

        DB::table('users')->insert($data);
        return redirect('/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // dd("hi");
            $user = Auth::user();
            $userRoles = DB::table('role_users')
            ->whereIn('user_id', [$user->id])
            ->pluck('role_id');

            $roleNames = DB::table('roles')
            ->whereIn('id', $userRoles)
            ->pluck('role_name');

            return redirect('/home')->with('roleNames');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    public function create(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'roles' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect('/home')
                ->withErrors($validator)
                ->withInput();
        }

        // dd('hello');
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->email,
            'created_at' => now(),

        ];
        $data['password'] = Hash::make($data['password']);
        // dd($data);
        $userId = DB::table('users')->insertGetId($data);
        // dd($userId);
        $roles = $request->input('roles', []);
        // dd($roles);
        foreach ($roles as $role) {
            $roleId = DB::table('roles')->where('role_name', $role)->value('id');
            // dd($userId,$roleId);
            if ($roleId) {
                // dd('hi');
                DB::table('role_users')->insert([
                    'user_id' => $userId,
                    'role_id' => $roleId,
                ]);
                // dd('hello');
            }
        }
        return redirect('/home');

    }

    public function listing()
    {
        $users = DB::table('users')
        ->leftJoin('role_users', 'users.id', '=', 'role_users.user_id')
        ->leftJoin('roles', 'role_users.role_id', '=', 'roles.id')
        ->groupBy('users.id', 'users.name', 'users.email')
        ->select('users.id', 'users.name', 'users.email', DB::raw('GROUP_CONCAT(roles.role_name) AS user_roles'))
        ->orderBy('created_at','asc')->paginate(5);
        return view('users', ['userss' => $users]);

    }

    public function edit($id)
    {
        $user = DB::table('users')->find($id);

        return view('edit_user', compact('user'));
    }

    public function delete($id)
    {
        $user = Users::find($id);
        $user->delete();
        return redirect('/home');
    }

    public function update(Request $request, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('email'))
            ]);

        return redirect('/home');
    }

    public function create_role(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return redirect('/home')
            ->withErrors($validator)
            ->withInput();
        }

        $data = [
            'role_name' => $request->name,
        ];

        DB::table('roles')->insert($data);
        return redirect('/home');
    }

    public function role_listing(){
        $roles = DB::table('roles')->select('name')->get();
        // dd($roles);
        return view('home', ['roles' => $roles]);
    }

}
