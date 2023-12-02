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

    public function filter(Request $request, NewsLetterService $newsLetter)
    {
        $from = $request->get('from') ? Carbon::parse($request->get('from'))->format('Y-m-d') : null;
        $to = $request->get('to') ? Carbon::parse($request->get('to'))->format('Y-m-d') : null;
        if(($from && !$to) || (!$from && $to)) {
            Session::put("error", "From and To date must be kept both filled or both empty");
            return redirect()->back();
        }
        $status = $request->get('status') ?? null;
        // $columns = $request->get('columns') ?? null;
        return $newsLetter->filterPaymentData($from, $to, $status);
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
        return redirect()->route('admin.payment');
    }

    public function update($userId, PaymentStoreRequest $request,PaymentService $newsLetter)
    {
        $data['payment_channel'] = $request->payment_channel;
        $data['amount'] = $request->amount;
        $data['trans_id'] = $request->trans_id;
        $data['image_path'] = $request->payment_image ?? null;
        $data['ip'] = $request->ip();
        [$status, $message] = $newsLetter->updatePaymentInfo($data, $userId);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return redirect()->route('admin.payment');
    }

    public function updateStatus($id, $status, PaymentService $newsLetter)
    {
        $data['status'] = $status;
        [$status, $message] = $newsLetter->updatePaymentStatus($data, $id);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return redirect()->route('admin.payment');
    }
}
