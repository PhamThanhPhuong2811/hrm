<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserNotification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Danh sách người dùng";
        $users = User::get();
        return view('backend.users', compact('title', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'username' => 'required|max:20',
            'email' => 'required|email',
            'password' => 'required|confirmed|max:200|min:5',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
            'role' => 'required|in:0,1',
            'gender' => 'required',
            
        ]);

        $imageName = null;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }

        // Tìm kiếm email trong bảng employees
        $employee = Employee::where('email', $request->email)->first();
        $employee_id = $employee ? $employee->id : null;

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $imageName,
            'role' => $request->role,
            'gender' => $request->gender,
            'employee_id' => $employee_id,  // Lưu employee_id nếu có
        ]);

        $user->notify(new NewUserNotification($user));
        $notification = notify('Thêm người dùng mới thành công');
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'username' => 'required|max:20',
            'email' => 'required|email',
            'password' => 'nullable|confirmed|max:200|min:5',
            'avatar' => 'nullable|file|image|mimes:jpg,jpeg,png,gif',
            'role' => 'required|in:0,1',
            'gender' => 'required',
        ]);

        $user = User::findOrFail($request->id);
        $imageName = $user->avatar;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }

        $password = $user->password;
        if ($request->password) {
            $password = Hash::make($request->password);
        }

        // Tìm kiếm email trong bảng employees
        $employee = Employee::where('email', $request->email)->first();
        $employee_id = $employee ? $employee->id : null;

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'avatar' => $imageName,
            'role' => $request->role,
            'gender' => $request->gender,
            'employee_id' => $employee_id,  // Cập nhật employee_id nếu có
        ]);

        $notification = notify('Cập nhật thông tin người dùng thành công');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->delete();
        $notification = notify('Xóa người dùng thành công');
        return back()->with($notification);
    }
}
