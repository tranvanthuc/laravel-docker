<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Notifications\UserFollowed;
use App\Repositories\UserRepository;
use Auth;

class UsersController extends Controller
{
    protected $userRepo;
    
    public function __construct()
    {
        $this->userRepo = app(UserRepository::class);
    }

    public function index()
    {
        $users = $this->userRepo->findWhere([
            ['id' , '!=', Auth::id()]
        ])->sortByDesc('id');
        return view('users.index', compact('users'));
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function follow(User $user)
    {
        /** @var User $follower */
        $follower = auth()->user();
        if ($follower->id == $user->id) {
            return back()->withError("You can't follow yourself");
        }
        if (!$follower->isFollowing($user->id)) {
            $follower->follow($user->id);

            // sending a notification
            $user->notify(new UserFollowed($follower));

            return back()->withSuccess("You are now friends with {$user->name}");
        }
        return back()->withError("You are already following {$user->name}");
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();
        if ($follower->isFollowing($user->id)) {
            $follower->unfollow($user->id);
            return back()->withSuccess("You are no longer friends with {$user->name}");
        }
        return back()->withError("You are not following {$user->name}");
    }

    public function notifications()
    {
        return auth()->user()->unreadNotifications()->limit(5)->get()->toArray();
    }
}
