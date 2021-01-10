<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // dd(Auth::user()->role);
        if(Auth::user()->role == 1){
            $users = User::where('role', 0)->get();
        }elseif(Auth::user()->role == 0){
            $users = User::where('role', 1)->get();
        }

        

        return view('messages.index', compact('users'));
    }

    public function chat(Request $request, $ids)
    {
        $authUser = $request->user();
        $arr_ids = explode('-', $ids);
        if(Auth::id() == $arr_ids[0]){
            $otherUser = User::find($arr_ids[1]);
        }else{
            $otherUser = User::find($arr_ids[0]);
        }
        // dd($otherUser);
        if (Auth::user()->role == 1) {
            $users = User::where('role', 0)->get();
        } elseif (Auth::user()->role == 0) {
            $users = User::where('role', 1)->get();
        }

        $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_ACCOUNT_TOKEN'));



        // Fetch channel or create a new one if it doesn't exist
        try {
            $channel = $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))
            ->channels($ids)
                ->fetch();
        } catch (\Twilio\Exceptions\RestException $e) {
            $channel = $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))
            ->channels
                ->create([
                    'uniqueName' => $ids,
                    'friendlyName' => '',
                    'type' => 'private',
                ]);
        }

        // Add first user to the channel
        try {
             $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))
            ->channels($ids)
                ->members($authUser->email)
                ->fetch();
        } catch (\Twilio\Exceptions\RestException $e) {
             $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))
            ->channels($ids)
                ->members
                ->create($authUser->email);
        }

        // Add second user to the channel
        try {
            $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))
            ->channels($ids)
                ->members($otherUser->email)
                ->fetch();
        } catch (\Twilio\Exceptions\RestException $e) {
            $twilio->chat->v2->services(env('TWILIO_SERVICE_SID'))
            ->channels($ids)
                ->members
                ->create($otherUser->email);
        }

        

        return view('messages.chat', compact('users', 'otherUser'));
    }
}
