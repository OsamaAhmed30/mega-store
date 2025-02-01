<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit(){
        $user = Auth::user();
        return view('dashboard.profile.edit',[
        'user'=>$user,'countries'=>Countries::getNames(),
        'locales'=>Languages::getNames()
    ]);
    }
    public function Update(Request $request){
        $user = $request->user();
        $request->validate([
            'first_name' => 'required|string|max:25',
            'last_name' => 'required|string|max:25',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'in:male,female',
            'country' => 'required|string|size:2',
        ]);
        $user->profile->fill($request->all())->save();
        $profile =$user->profile;
        
        return redirect()->route('dashboard.profile.show')->with('success','Nice! Profile Updated');
    }
    public function show(){
        $profile = Auth::guard('admin')->user();
        //return $profile;
       
        
        return view('dashboard.profile.show',compact('profile'));
    }
}
