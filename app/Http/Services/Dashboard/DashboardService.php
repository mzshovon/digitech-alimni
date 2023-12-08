<?php

namespace App\Http\Services\Dashboard;

use App\Http\CacheOps\VisitorManageFromCache;
use App\Http\Services\Utilities\UtilitiesService;
use App\Models\ContactUs;
use App\Models\MembershipDetail;
use App\Models\Payment;
use App\Models\User;

class DashboardService {

    private $valueListForTop = ["first_name", "nid"];

    public function __construct(private VisitorManageFromCache $visitorManageFromCache, private UtilitiesService $utilitiesService)
    {

    }

    public function getDashboardData()
    {
        $member = new User();
        return $member->getUsersList();
    }

    public function getMembersCount()
    {
        $member = new User();
        return $member->count();
    }
    public function getPaymentCount()
    {
        $payment = new Payment();
        return $payment->count();
    }
    public function getContactCount()
    {
        $contact = new ContactUs();
        return $contact->count();
    }

    public function getDashboardActivityData()
    {
        $countInfo = $this->visitorManageFromCache->getVisitorInfo();
        return json_encode($countInfo);
    }

}
