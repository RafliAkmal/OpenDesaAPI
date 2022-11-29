<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create_user(Request $request){
        if (auth()->user()->id_role !== 1){
            return $this->unauthorizedResponse("Tidak memiliki izin untuk membuat akun");
        }

        $fields = $request->validate([
            'full_name' =>'required|string',
            'user' => 'required|string|alpha_dash',
            'password' => 'required|string|alpha_dash',
            'id_role' => 'required|integer',
        ]);

        $user = User::create([
            'full_name' => $fields['full_name'],
            'username' => $fields['user'],
            'password' => bcrypt($fields['password']),
            'id_role'=> $fields['id_role'],
        ]);

        $token = $user->createToken($user['username'])->plainTextToken;

        $user->remember_token = $token;
        $user->save();
        
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->successfulResponse($response, "Berhasil membuat akun");
    } 

    public function logout(){
        $token = auth()->user();
        $user = User::where('remember_token', $token['remember_token'])->first();
        
        if($user){
            $user['remember_token'] = null;
            $user->save();
            $user->tokens()->delete();
            
            return $this->successfulResponse($user, "Berhasil Logout");
        } 
    }

    public function profile(){
        return auth()->user();
    }

    public function user_information($username){
        $user = User::where('username', $username)->first();

        if (!$user){
            return $this->notFoundResponse("User dengan username " . $username . " tidak ditemukan");
        }

        $user_data = [
            "full_name" => $user->full_name,
            "username" => $user->username,
            "role" => $user->role->role_name
        ];

        return $this->successfulResponse($user_data, "Berhasil menemukan user");
    }

    public function change_role(Request $request){
        if (auth()->user()->id_role !== 1){
            return $this->unauthorizedResponse("Tidak memiliki izin untuk membuat akun");
        }

        $fields = $request->validate([
            'id_user' => 'required|integer',
            'id_role' => 'required|integer'
        ]);

        $user = User::where('id', $fields['id_user'])->first();
        $role = Role::where('id', $fields['id_role'])->first();

        if (!$user){
            return $this->notFoundResponse("User dengan id " . $fields['id_user'] . " tidak ditemukan");
        }

        if (!$role){
            return $this->notFoundResponse("Role dengan id " . $fields['id_role'] . " tidak ditemukan");
        }

        $user->id_role = $fields['id_role'];

        $user->save();

        $user_data = [
            "full_name" => $user->full_name,
            "username" => $user->username,
            "role" => $user->role->role_name
        ];

        return $this->successfulResponse($user_data, "Berhasil mengubah role user");
    }

    public function login(Request $request){
        $fields = $request->validate([
            'username' => 'required|string|alpha_dash',
            'password' => 'required|string|alpha_dash',
        ]);

        $user = User::where('username', $fields['username'])->first();

        if(!$user || !Hash::check($fields['password'], $user['password'])){
            return $this->unauthorizedResponse("Gagal login");
        }

        $token = $user->createToken($user['username'])->plainTextToken;

        $user['remember_token'] = $token;
        $user->save();

        return $this->successfulResponse($user, "Berhasil login");
    }
}