<?php

namespace App\Http\Controllers\Backend;

use App\Models\Qa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use Cache;
use Illuminate\Validation\Rule;

class KQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.kq.index');
    }
}
