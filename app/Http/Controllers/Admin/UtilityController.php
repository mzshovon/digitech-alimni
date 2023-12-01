<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Services\Utilities\UtilitiesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class UtilityController extends Controller
{
    public function contactUsView(UtilitiesService $utilitiesService)
    {
        $data['title'] = "Contact Us for support";
        $data['contacts'] = $utilitiesService->getContactUsData();
        return view("admin.contact.index", $data);
    }

    public function storeAndSendContactMessage(ContactUsRequest $request, UtilitiesService $utilitiesService)
    {
        $data['subject'] = $request->subject;
        $data['message'] = $request->message;
        $data['email'] = getUserInfo()->email;
        $data['user_id'] = getUserInfo()->id;
        $data['ip'] = $request->ip();
        [$status, $message] = $utilitiesService->storeContactInfoAndSendMail($data);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return redirect("/admin/contact");
    }
}
