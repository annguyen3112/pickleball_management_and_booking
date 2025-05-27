<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function fetchCustomer()
    {
        $customers = User::query()->where('role', UserRole::Client)->get([
            'id',
            'name',
            'email',
            'phone',
            'role',
            'address',
        ]);

        return response()->json(['data' => $customers]);
    }

    public function storeCustomer(Request $request)
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
        $validated['role'] = UserRole::Client;
        $customer = User::create($validated);

        return response()->json(['message' => 'Thêm khách hàng thành công']);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $customer = User::find($id);

        if (!$customer) return to_route('client.index');

        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);

        return to_route('client.profile')->with('message', 'Cập nhật thông tin thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCustomer(string $id)
    {
        $customer = User::find($id);

        if (!$customer) {
            abort(404);
        }

        $customer->delete();

        return redirect()->back()->with('message', 'Xóa khách hàng thành công');
    }

    public function changePassword(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        $customer = User::find($id);

        if (!Hash::check($validated['old_password'], $customer->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Mật khẩu cũ không đúng']);
        }

        $customer->update(['password' => Hash::make($validated['new_password'])]);

        return redirect()->back()->with('message', 'Đổi mật khẩu thành công');
    }

    public function show($id)
    {
        $customer = User::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Không tìm thấy khách hàng']);
        }

        return response()->json(['data' => $customer]);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = User::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Không tìm thấy khách hàng']);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'nullable|string',
        ]);
        $customer->update($validated);

        return response()->json(['message' => 'Cập nhật thông tin khách hàng thành công']);
    }

    public function updateRoleCustomer(Request $request, $id)
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
