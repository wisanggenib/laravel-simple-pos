<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function fetchData($name = "")
    {
        $users =
            DB::table('users')
            ->select('users.*', 'areas.area_name')
            ->join('areas', 'users.id_area', '=', 'areas.id')
            ->where('users.username', 'LIKE', "%$name%")
            ->paginate(1000);
        return response()->json([
            'users' => $users,
        ]);
    }

    public function fetchDetail($id)
    {
        $users =
            DB::table('users')
            ->join('areas', 'users.id_area', '=', 'areas.id')
            ->select('users.*', 'areas.area_name')
            ->where('users.id', $id)
            ->first();

        if ($users) {
            return response()->json([
                'status' => 200,
                'message' => 'success fetch',
                'data' => $users
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }

    public function updateData(Request $request, $id)
    {

        $userModel = Users::find($id);

        if ($userModel) {
            $userModel->id_area = $request->input('area_id');
            $userModel->email = $request->input('email');
            $userModel->username = $request->input('username');
            $userModel->fullname = $request->input('fullname');
            $userModel->role = $request->input('role');
            //handlign new password
            if ($request->input('password')) {
                $userModel->password = Hash::make($request->input('password'));
            }
            $userModel->update();
            if ($userModel) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success update',
                    'data' => $userModel
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'error update',
                    'data' => null
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }

    public function deleteData($id)
    {
        $user = Users::find($id);
        $user->delete();
        if ($user) {
            if ($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'success delete',
                    'data' => $user
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'data not found',
                'data' => null
            ]);
        }
    }

    //authentication
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            Auth::login($user);
            $request->session()->regenerate();


            return redirect()->intended('/admin/area');
        }

        return back()->withErrors([
            'email' => 'Username atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $userModel = new Users();
        $userModel->id_area = $request->input('area_id');
        $userModel->email = $request->input('email');
        $userModel->username = $request->input('username');
        $userModel->fullname = $request->input('fullname');
        $userModel->role = $request->input('role');
        $userModel->password = Hash::make($request->input('password'));
        $userModel->save();

        if ($userModel) {
            return response()->json([
                'status' => 200,
                'message' => 'success update',
                'data' => $userModel
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'success update',
                'data' => $userModel
            ]);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
