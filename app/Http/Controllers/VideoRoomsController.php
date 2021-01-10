<?php

namespace App\Http\Controllers;
require_once '../vendor/autoload.php';
use App\Models\User;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Illuminate\Http\Request;
use Twilio\Jwt\Grants\VideoGrant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VideoRoomsController extends Controller
{
    protected $sid;
    protected $token;
    protected $key;
    protected $secret;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->key = config('services.twilio.key');
        $this->secret = config('services.twilio.secret');
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->role == 1){
            $client = new Client($this->sid, $this->token);
            $exists = $client->video->v1->rooms->read(['uniqueName' => Auth::user()->email]);
            
            if (empty($exists)) {
                $client->video->rooms->create([
                    'uniqueName' => Auth::user()->email,
                    'type' => 'group',
                    'recordParticipantsOnConnect' => false
                ]);
            } 
        }
        $rooms = [];
        try{
            $client = new Client($this->sid, $this->token);
            $allRooms = $client->video->v1->rooms->read([], 20);
            
            $rooms = array_map(function($room) {
                if(Auth::check() && $room->uniqueName == Auth::user()->email){
                    // $room_map = array(
                    //     'name'  => Auth::user()->name,
                    //     'avatar' => Auth::user()->avatar,
                    //     'room'  => $room->uniqueName,
                    // );
                    // return $room_map;
                } else {
                    $user = User::where('email', $room->uniqueName)->first();
                    $user->sid = $room->sid;
                    $user->save();

                    // if ($user->online == 1) {
                        $room_map = array(
                            'name'  => $user->name,
                            'avatar' => $user->avatar,
                            'room'  => $room->uniqueName,
                            'is_online'  => $user->online,
                            'company'  => $user->company,
                            'sector'  => $user->sector,
                        );
                        return $room_map;
                    // }
                }
            }, $allRooms);
            
        } catch (\Exception $e) {
            // echo "Error: " . $e->getMessage();
        }
        return view('index', ['rooms' => $rooms]);
    }

    public function createRoom(Request $request)
    {
        $client = new Client($this->sid, $this->token);

        $exists = $client->video->v1->rooms->read([ 'uniqueName' => $request->roomName]);

        if (empty($exists)) {
            $client->video->rooms->create([
                'uniqueName' => $request->roomName,
                'type' => 'group',
                'recordParticipantsOnConnect' => false
            ]);
        } 
        return Redirect::to(url('room/join/'.$request->roomName));
        // return redirect()->action('VideoRoomsController@joinRoom', [
        //     'roomName' => $request->roomName
        // ]);
    }

    public function joinRoom($roomName)
    {
        // A unique identifier for this user
        $identity = Auth::user()->email;
        // $identity = rand(3,1000);

        Log::debug("joined with identity: $identity");
        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);
        
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        
        $token->addGrant($videoGrant);
        // dd($token, $token->toJWT(), $videoGrant, $roomName);

        return view('room', [ 'accessToken' => $token->toJWT(), 'roomName' => $roomName ]);
    }

    public function myRoom(){
        // A unique identifier for this user
        $identity = Auth::user()->email;
        // $identity = rand(3,1000);

        $client = new Client($this->sid, $this->token);
        $exists = $client->video->v1->rooms(Auth::user()->email);
        if (empty($exists)) {
            $room = $client->video->v1->rooms->create([
                'uniqueName' => Auth::user()->email.'1',
                'type' => 'group',
                'recordParticipantsOnConnect' => false
            ]);

            $user = User::where('email', Auth::user()->email)->first();
            $user->sid = $room->sid;
            $user->online = 1;
            $user->save();
        }

        $user = Auth::user();
        $user->online = 1;
        $user->save();

        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);
        
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom(Auth::user()->email);
        
        $token->addGrant($videoGrant);

        

        return view('my_room', [ 'accessToken' => $token->toJWT(), 'roomName' => Auth::user()->email ]);
    }

    public function closeMyRoom(){

        $client = new Client($this->sid, $this->token);

        $exists = $client->video->v1->rooms(Auth::user()->email)->update("completed");

        
        $user = Auth::user();
        $user->online = 0;
        $user->save();
        return redirect('/');
    }

    
}
