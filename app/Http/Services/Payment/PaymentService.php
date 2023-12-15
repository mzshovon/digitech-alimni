<?php

namespace App\Http\Services\Payment;

use App\Exports\ExportExcel;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class PaymentService {

    private $valueListForTop = ["first_name", "nid"];
    private $columnsValue = ["Name", "Email", "Contact Number", "Payment Channel", "Transaction ID", "Amount", "Status", "Submitted At"];

    public function __construct(private Payment $payment)
    {

    }

    public function getPaymentData()
    {
        $payment = $this->payment;
        $userId = (getUserInfo()->hasRole("superadmin") || getUserInfo()->hasRole("admin")) ? null : getUserInfo()->id;
        return $payment->getPayments($userId) ?? [];
    }

    public function filterPaymentData($from, $to, $status)
    {
        $payment = $this->payment;
        $filteredData = $payment->getPayments(null, null, $from, $to, $status);
        $resourceData = PaymentResource::collection($filteredData)->toArray($filteredData);
        $format = "xlsx";
        $file = "Payment Data.$format";
        return Excel::download(new ExportExcel($resourceData, $this->columnsValue), $file);
    }

    /**
     * @param mixed $data
     *
     * @return [type]
     */
    public function storePaymentInfo($data)
    {
        try {
            $payment = $this->payment;
            $userId = getUserInfo()->id;
            if($data['image_path']){
                $dirName = storeOrUpdateImage("storage/img/payment/$userId/", $data['image_path'], "payment", false);
                $data['image_path'] = $dirName;
            } else {
                unset($data['image_path']);
            }
            if($payment->createNewPaymentRequest($data)) {
                return [Response::HTTP_OK, "Payment Request Updated Successfully. Admin will review and confirm your payment record soon."];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage()];
        }
    }

    /**
     * @param mixed $data
     *
     * @return [type]
     */
    public function storeStripePaymentInfo($amount, $currency, $source, $description)
    {
        try {
            $payment = $this->payment;
            Stripe::setApiKey(config('app.stripe_secret'));
            $details = \Stripe\Charge::create ([
                    "amount" => $amount,
                    "currency" => $currency,
                    "source" => $source,
                    "description" => $description,
            ]);
            if($details && $details->status == "succeeded") {
                $data['user_id'] = getUserInfo()->id;
                $data['payment_channel'] = $details->calculated_statement_descriptor;
                $data['amount'] = $amount;
                $data['trans_id'] = $details->balance_transaction;
                $data['status'] = $details->status;
                $data['ip'] = $_SERVER['REMOTE_ADDR'];
                $createPayment = $payment->createNewPaymentRequest($data);
                if($createPayment && $createPayment->id) {
                    Cache::put("stripe_payment_of_".$createPayment->id, json_encode($details));
                    return [Response::HTTP_OK, "Payment Request Placed Successfully. Admin will review and confirm your payment record soon."];
                }
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage()];
        }
    }
    /**
     * @param mixed $data
     *
     * @return [type]
     */
    public function updatePaymentInfo($data, $userId)
    {
        try {
            $payment = $this->payment;
            if($data['image_path']){
                $dirName = storeOrUpdateImage("storage/img/payment/$userId/", $data['image_path'], "payment", false);
                $data['image_path'] = $dirName;
            } else {
                unset($data['image_path']);
            }
            if(in_array($payment->getSinglePaymentByParam('user_id', $userId)->status, ["approved", "declined"])) {
                return [Response::HTTP_BAD_REQUEST, "Payment is already ".$payment->getSinglePaymentByParam('user_id', $userId)->status."! You can't update it"];
            }
            if($payment->updatePaymentRequest($data ,"user_id", $userId)) {
                return [Response::HTTP_OK, "Payment Request Placed Successfully. Admin will review and confirm your payment status soon."];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage()];
        }

    }
    /**
     * @param mixed $data
     *
     * @return [type]
     */
    public function updatePaymentStatus($data, $id)
    {
        try {
            $payment = $this->payment;
            if($payment->updatePaymentRequest($data ,"id", $id)) {
                return [Response::HTTP_OK, "Payment status updated successfully"];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage()];
        }

    }

}
