<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{

    public function index()
    {
        $user = User::with('roles')->get();
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'data' => $user,
                'api_token' => $token

            ]);
        }
        throw ValidationException::withMessages([
            'username' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'selectedRole' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $selectedRole = Role::findById($request->selectedRole);
        $user->assignRole($selectedRole);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }

    public function getDataUser($id)
    {
        $user = User::with('roles')->where('id', $id)->first();
        return response()->json($user);
    }

    public function editUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'selectedRole' => 'required',
        ]);

        $user = User::where('id', $id)->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        $selectedRole = Role::findById($request->selectedRole);
        $user = User::find($id);
        $user->syncRoles($selectedRole);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }

    public function logoutUser()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function show($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return response()->json($user);
    }

    public function getDataPermission()
    {
        $users = User::with('roles.permissions')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $users
        ]);
    }

    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $data
        ]);
    }
}
