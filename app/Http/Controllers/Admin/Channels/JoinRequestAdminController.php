<?php

namespace App\Http\Controllers\Admin\Channels;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;
use Illuminate\Http\Request;

class JoinRequestAdminController extends Controller
{
    public function index()
    {
        $channels = JoinRequest::orderBy('id')->paginate(15);

        return view('admin.channels.index', compact('channels'));
    }
}
