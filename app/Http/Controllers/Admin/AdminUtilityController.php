<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminUtilities\AdminUtilitiesService;
use App\Repositories\AdminUtilityServiceReporsitoryInterface;
use Illuminate\Http\Request;

class AdminUtilityController extends Controller
{
    public function getActivityLogs(Request $request, AdminUtilitiesService $adminUtilitiesService){
        try {
            $requestType = $request->requestType ?? null;
            $data = $adminUtilitiesService->getActivityLogData();
            return response()->json($data);

        } catch (\Throwable $th) {
            return $th;
        }
    }
}
