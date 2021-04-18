<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $search = request('name');

        $val = User::where('name', 'LIKE', "$search%")
            ->pluck('name')
            ->take(5);

        return $val->map(function ($name) {
            return ['value' => $name];
        });
    }
}
