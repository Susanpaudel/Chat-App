<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload_image(Request $request){
        $request->validate([
          'avatar'=>'nullable|image|mimes:jpeg,jpg,png|max:90000',
        ]);
        $path = public_path() . '/storage/user/';
        $folderPath = 'public/user/';
        if (!file_exists($path)) {
            Storage::makeDirectory($folderPath, 0755, true, true);
            chmod($path, 0755);
        }
        $user=User::find(auth()->user()->id);
        if(!$user){
            return back()->with('error','User not found!!');
        }
        if ($request->hasFile('avatar')) {
            $oldImage=$user->avatar;
            $image = $request->file('avatar');
            $filename = time() . '.' . $image->extension();
            $image->storeAs($folderPath, $filename);
            $user->avatar = $filename;
            Storage::delete('public/user/'.$oldImage);
        }
        $user->save();
        if($user){
            return back()->with('success','User Profile Image Updated!!');

        }
        return back()->with('error','Something went wrong!');

    }
}
