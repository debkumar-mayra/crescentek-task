<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAuthController extends Controller
{
    function dashboard()  {
        return 'admin dashboard';
    }
}
