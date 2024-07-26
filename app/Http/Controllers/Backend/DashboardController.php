<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
//use App\Repositories\Backend\Order\OrderRepositoryContract;
//use App\Repositories\Backend\Product\ProductRepositoryContract;
//use App\Repositories\Backend\News\NewsRepositoryContract;
//use App\Repositories\Backend\User\UserRepositoryContract;
//use App\Repositories\Backend\Page\PageRepositoryContract;
use App\Libs\Common;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected $order;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        return view('admin.dashboard.index');
    }
}
