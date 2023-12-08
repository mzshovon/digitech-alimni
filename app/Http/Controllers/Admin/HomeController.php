<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Dashboard\DashboardService;
use App\Repositories\admin\HomeRepository;
use App\Repositories\HomeRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(DashboardService $dashboardService){
        $data['members'] = $dashboardService->getDashboardData();
        $data['memberCount'] = $dashboardService->getMembersCount();
        $data['paymentCount'] = $dashboardService->getPaymentCount();
        $data['contactCount'] = $dashboardService->getContactCount();
        $data['countInfo'] = $dashboardService->getDashboardActivityData();
        return view('admin.dashboard', $data);
    }
}
