<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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

    public function addAvatar(){
        return view('add_avatar');
    }
    public function storeAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // dd(public_path());
        $imageName = time().'.'.$request->avatar->extension(); 
        $path = $request->file('avatar')->storeAs('avatar', $imageName, 'public');
        $user = User::find(Auth::id());
        $user->avatar = $path;
        $user->save();
        /* Store $imageName name in DATABASE from HERE */
        // return back()->with('success','You have successfully upload image.')->with('image',$imageName); 
        return redirect('/');
    }

    public function userList()
    {
        $users = User::all();
        return view('user-list', compact('users'));
    }

    public function assignExhibitor(Request $request){
        $this->validate($request, [
            'user_id' => 'required|array',
            'user_id.*' => 'required|integer'
        ]);

        User::where('role', 1)->update(['role' => 0]);
        foreach($request->user_id as $key => $value){
            
            $user = User::find($key);
            $user->role = $value;
            $user->save();
        }


        return redirect('user-list')->with('success', 'Assign Successfull');
    }

    public function statusUpdate(Request $request)
    {
        $user = User::find(Auth::id());
        $user->online = $request->input('online');
        $user->save();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
