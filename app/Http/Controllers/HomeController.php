<?php

namespace App\Http\Controllers;

use App\Events\ChatBroadCast;
use App\Events\ChatEvent;
use App\Models\Chat;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::otherUsers();
        return view('index', compact('users'));
    }

    public function get_user($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response([
                'status' => false,
                'result' => 'User not found'
            ]);
        }

        // $session = Session::where(function ($q) use ($id) {
        //     $q
        //         ->orWhere(['user_1_id' => auth()->id(), 'user_2_id' => $id])
        //         ->orWhere(['user_2_id' => auth()->id(), 'user_1_id' => $id]);
        // })->first();

        $session = Session::query()
            ->where(function ($query) use ($id) {
                $query->where('user_1_id', auth()->id())
                    ->where('user_2_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('user_1_id', $id)
                    ->where('user_2_id', auth()->id());
            })
            ->first();


        if (is_null($session)) {
            $session = Session::create([
                'id' => Str::random(36),
                'user_1_id' => auth()->id(),
                'user_2_id' => $id,
            ]);
        }

        $view = view('includes.chat_user', ['user' => $user])->render();
        return response([
            'status' => true,
            'result' => $view,
        ]);
    }

    public function send_message(Request $request)
    {
        $data = $request->all();
        $data['from_id'] = auth()->id();
        Chat::create($data);
        broadcast(new ChatBroadCast($data['session_id'], $data['message']))->toOthers();
        // broadcast(new ChatEvent($data['session_id'], $data['message']));
        return view('includes.send', ['message' => $data['message']])->render();
    }

    public function receive(Request $request)
    {
        return view('includes.reveive', ['message' => $request->get('message')])->render();
    }
}
