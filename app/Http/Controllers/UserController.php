<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\IdentityPaper;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function fetchEmploye()
    {
        $users = User::query()->where('role', UserRole::Employee)->get([
            'id',
            'name',
            'email',
            'phone',
            'role',
            'address',
        ]);

        return response()->json(['data' => $users]);
    }

    public function fetchOwner()
    {
        $owner = User::query()->where('role', UserRole::CourtOwner)->get([
            'id',
            'name',
            'email',
            'phone',
            'role',
            'address',
        ]);

        return response()->json(['data' => $owner]);
    }

    public function storeEmploye(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'nullable|string',
            'password' => 'required|string',
            'confirm_password' => 'same:password',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = UserRole::Employee;
        $user = User::create($validated);

        return response()->json(['message' => 'Thêm nhân viên thành công']);
    }

    public function storeOwner(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'nullable|string',
            'password' => 'required|string',
            'confirm_password' => 'same:password',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = UserRole::CourtOwner;
        $owner = User::create($validated);

        return response()->json(['message' => 'Thêm chủ sân thành công']);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::find($id);

        if (!$user) return to_route('client.index');

        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'nullable|string',
        ]);

        $user->update($validated);

        return to_route('client.profile')->with('message', 'Cập nhật thông tin thành công');
    }

    public function destroyEmploye(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        $papers = IdentityPaper::query()->where('user_id', $id)->get();

        if ($papers->count() > 0) {
            foreach ($papers as $paper) {
                Storage::disk('public')->delete($paper->image);
            }
        } 
        $user->delete();

        return redirect()->back()->with('message', 'Xóa nhân viên thành công');
    }

    public function destroyOwner(string $id)
    {
        $owner = User::find($id);

        if (!$owner) {
            abort(404);
        }

        $owner->delete();

        return redirect()->back()->with('message', 'Xóa chủ sân thành công');
    }

    public function changePassword(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        $user = User::find($id);

        if (!Hash::check($validated['old_password'], $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng']);
        }

        $user->update(['password' => Hash::make($validated['new_password'])]);

        return redirect()->back()->with('message', 'Đổi mật khẩu thành công');
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy nhân viên']);
        }

        return response()->json(['data' => $user]);
    }

    public function showOwner($id)
    {
        $owner = User::find($id);

        if (!$owner) {
            return response()->json(['message' => 'Không tìm thấy chủ sân']);
        }

        return response()->json(['data' => $owner]);
    }

    public function updateEmploye(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy nhân viên']);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'nullable|string',
        ]);
        $user->update($validated);

        return response()->json(['message' => 'Cập nhật thông tin nhân viên thành công']);
    }

    public function updateOwner(Request $request, $id)
    {
        $owner = User::find($id);

        if (!$owner) {
            return response()->json(['message' => 'Không tìm thấy chủ sân']);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'nullable|string',
        ]);
        $owner->update($validated);

        return response()->json(['message' => 'Cập nhật thông tin chủ sân thành công']);
    }

    public function updateRoleOwner(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roleMapping = [
            'Client' => UserRole::Client,
            'Employee' => UserRole::Employee,
            'CourtOwner' => UserRole::CourtOwner,
        ];

        if (!array_key_exists($request->role, $roleMapping)) {
            return response()->json(['error' => 'Vai trò không hợp lệ'], 400);
        }

        $user->role = $roleMapping[$request->role];
        $user->save();

        return response()->json(['message' => 'Cập nhật vai trò thành công']);
    }

    public function updateRoleEmploye(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roleMapping = [
            'Client' => UserRole::Client,
            'Employee' => UserRole::Employee,
            'CourtOwner' => UserRole::CourtOwner,
        ];

        if (!array_key_exists($request->role, $roleMapping)) {
            return response()->json(['error' => 'Vai trò không hợp lệ'], 400);
        }

        $user->role = $roleMapping[$request->role];
        $user->save();

        return response()->json(['message' => 'Cập nhật vai trò thành công']);
    }
}
