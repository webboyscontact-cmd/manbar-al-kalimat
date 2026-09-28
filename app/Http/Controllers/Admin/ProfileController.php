<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('admin.profile.edit');
    }

    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,'.$admin->id],
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required_with' => 'الرجاء إدخال كلمة المرور الحالية لتغييرها.',
            'password.min' => 'يجب أن تتكون كلمة المرور الجديدة من 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ]);

        if (! empty($validated['password'])) {
            if (! Hash::check($validated['current_password'], $admin->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'كلمة المرور الحالية غير صحيحة.',
                ]);
            }
            $admin->password = Hash::make($validated['password']);
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->save();

        return back()->with('status', 'تم تحديث البيانات بنجاح.');
    }
}
