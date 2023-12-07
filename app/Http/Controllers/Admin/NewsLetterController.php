<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Services\Payment\PaymentService;
use App\Http\Services\Utilities\NewsLetterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class NewsLetterController extends Controller
{
    public function view(NewsLetterService $newsLetter)
    {
        $data['title'] = "Newsletter";
        $data['newsLetters'] = $newsLetter->getNewsLettertData();
        return view("admin.newsletter.index", $data);
    }

    public function create(NewsLetterService $newsLetter){
        try {
            $data['title'] = "Send Newsletter";
            $data['emails'] = $newsLetter->getAllEmails();
            return  view('admin.newsletter.create', $data);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function store(Request $request, NewsLetterService $newsLetter)
    {
        $members = $request->members ?? null;
        $batch = $request->batch ?? null;
        $emails = $request->emails ?? null;
        $start_period = $request->start_period ?? null;
        $end_period = $request->end_period ?? null;
        $template_name = $request->template_name ?? null;
        $news = $request->news;
        if(!$news) {
            Session::put("error", "Newsletter section mustn't be empty!");
            return redirect()->back();
        }
        [$status, $message] = $newsLetter->storeNewsLetterInfo($members, $batch, $emails, $start_period, $end_period, $template_name, $news);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return redirect()->route('admin.newsletter');
    }

}
