<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? (object) [
            'name' => 'John Doe',
            'email' => 'customer@leafly.id',
            'phone' => '081234567890',
            'avatar' => null
        ];

        return view('customer.profile.index', compact('user'));
    }
}
