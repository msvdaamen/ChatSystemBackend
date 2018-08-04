<?php

namespace App\Http\Controllers;

use App\Events\NewFriend;
use App\Events\NotificationFriendRequest;
use App\Friend;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FriendsController extends Controller
{

    public function index(Request $request) {
        $friends = Friend::where('user_id', $request->user()->id)->where('accepted', 1)->with('friend')->get();
        return response($friends, Response::HTTP_OK);
    }

    public function pending(Request $request) {
        $friends = Friend::where('friend_id', $request->user()->id)->where('accepted', 0)->with('user')->get();
        return response($friends, Response::HTTP_OK);
    }

    public function add(Request $request) {
        if(Friend::where('user_id', $request->user()->id)->where('friend_id', $request->user_id)->where('accepted', '>=', 0)->count() == 0) {
            $friend = new Friend;
            $friend->user_id = $request->user()->id;
            $friend->friend_id = $request->user_id;
            $friend->accepted = 0;
            $friend->save();

            $newFriend = Friend::where('id', $friend->id)->with('user', 'friend')->first();

            event(new NotificationFriendRequest($newFriend));

            return response($newFriend, Response::HTTP_OK);
        }
        return response('already send', Response::HTTP_NOT_ACCEPTABLE);
    }

    public function confirm(Request $request) {

        if($request->confrim == 1) {

            Friend::where('id', $request->id)->update([
                'accepted' => 1
            ]);


            $friend = new Friend;
            $friend->user_id = $request->user()->id;
            $friend->friend_id = $request->user_id;
            $friend->accepted = 1;
            $friend->save();

            $newFriend = Friend::where('id', $request->id)->where('accepted', 1)->with('friend')->first();

            event(new NewFriend($newFriend));
            $newFriend = Friend::where('friend_id', $newFriend->user_id)->where('user_id', $newFriend->friend_id)->where('accepted', 1)->with('friend')->first();
            return response(['accepted' => 1, 'newFriend' => $newFriend], Response::HTTP_OK);
        }else {
            Friend::where('id', $request->id)->delete();
            return response(['accepted' => 0], Response::HTTP_OK);
        }

    }


    public function search(Request $request) {
        $users = User::where('name', 'like', '%' . $request->search . '%')->where('id', '!=', $request->user()->id)->get();
        return response($users, Response::HTTP_OK);
    }
}
