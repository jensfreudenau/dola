<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;


class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('admin.profiles.show', [
            'user' => $user,
            'activities' => Activity::feed($user)

        ]);
    }
}
