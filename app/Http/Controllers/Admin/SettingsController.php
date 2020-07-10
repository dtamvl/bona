<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => 'required|image',
        ]);
        $avatar = $request->file('avatar');
        $slug = Str::slug($request->name);
        $user = User::findOrFail(Auth::id());
        if (isset($avatar))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$avatar->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('profile'))
            {
               Storage::disk('public')->makeDirectory('profile');
           }
//            Delete old image form profile folder
           if (Storage::disk('public')->exists('profile/'.$user->avatar))
           {
            Storage::disk('public')->delete('profile/'.$user->avatar);
        }
        $profile = Image::make($avatar)->resize(500,500)->stream();
        Storage::disk('public')->put('profile/'.$imageName,$profile);
    } else {
        $imageName = $user->avatar;
    }
    $user->name = $request->name;
    $user->email = $request->email;
    $user->avatar = $imageName;
    $user->about = $request->about;
    $user->save();
    return redirect()->back()->with('success','Profile Successfully Updated');
}

public function updatePassword(Request $request)
{
    $this->validate($request,[
        'old_password' => 'required',
        'password' => 'required|confirmed',
    ]);

    $hashedPassword = Auth::user()->password;
    if (Hash::check($request->old_password,$hashedPassword))
    {
        if (!Hash::check($request->password,$hashedPassword))
        {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->with('success','Password Successfully Changed');
            Auth::logout();
        } else {
            return redirect()->back()->with('error','New password cannot be the same as old password');
        }
    } else {
        return redirect()->back()->with('error','Current password not match');
    }

}
}
