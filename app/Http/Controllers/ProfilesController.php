<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;

class ProfilesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  String  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'records' => Activity::feed($user)
        ]);
    }
}
