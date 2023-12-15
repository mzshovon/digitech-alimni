<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Services\Payment\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function view(PaymentService $paymentService)
    {
        $data['title'] = "Payment";
        $data['payments'] = $paymentService->getPaymentData();
        return view("admin.payment.index", $data);
    }

    public function charge(PaymentService $paymentService)
    {
        $data['title'] = "Stripe Payment";
        return view("admin.payment.charge", $data);
    }

    public function stripePayment(Request $request, PaymentService $paymentService)
    {
        // dd(config('app.stripe_key'));
        $amount = $request->amount ?? 1000;
        $currency = "USD";
        $source = $request->stripeToken;
        $description = "From Shovon & Team";
        [$status, $message] = $paymentService->storeStripePaymentInfo($amount, $currency, $source, $description);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return back();
    }

    public function filter(Request $request, PaymentService $paymentService)
    {
        $from = $request->get('from') ? Carbon::parse($request->get('from'))->format('Y-m-d') : null;
        $to = $request->get('to') ? Carbon::parse($request->get('to'))->format('Y-m-d') : null;
        if(($from && !$to) || (!$from && $to)) {
            Session::put("error", "From and To date must be kept both filled or both empty");
            return redirect()->back();
        }
        $status = $request->get('status') ?? null;
        // $columns = $request->get('columns') ?? null;
        return $paymentService->filterPaymentData($from, $to, $status);
    }

    public function store(PaymentStoreRequest $request,PaymentService $paymentService)
    {
        $data['user_id'] = getUserInfo()->id;
        $data['payment_channel'] = $request->payment_channel;
        $data['amount'] = $request->amount;
        $data['trans_id'] = $request->trans_id;
        $data['image_path'] = $request->payment_image ?? null;
        $data['ip'] = $request->ip();
        [$status, $message] = $paymentService->storePaymentInfo($data);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return redirect()->route('admin.payment');
    }

    public function update($userId, PaymentStoreRequest $request,PaymentService $paymentService)
    {
        $data['payment_channel'] = $request->payment_channel;
        $data['amount'] = $request->amount;
        $data['trans_id'] = $request->trans_id;
        $data['image_path'] = $request->payment_image ?? null;
        $data['ip'] = $request->ip();
        [$status, $message] = $paymentService->updatePaymentInfo($data, $userId);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return redirect()->route('admin.payment');
    }

    public function updateStatus($id, $status, PaymentService $paymentService)
    {
        $data['status'] = $status;
        [$status, $message] = $paymentService->updatePaymentStatus($data, $id);
        Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
        return redirect()->route('admin.payment');
    }
}
