<?php

namespace App\Http\Services\Utilities;

use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class UtilitiesService {

    private $valueListForTop = ["first_name", "nid"];

    public function getContactUsData()
    {
        $contact = new ContactUs();
        $userId = getUserInfo()->hasRole("superadmin") || getUserInfo()->hasRole("admin") ? null : getUserInfo()->id;
        return $contact->getContacts($userId);
    }

    /**
     * @param mixed $data
     *
     * @return [type]
     */
    public function storeContactInfoAndSendMail($data)
    {
        try {
            $contact = new ContactUs();
            if($contact->createNewContactRequest($data)) {
                sendMailWithTemplate($data, 'admin.template.mail.contact', config('mail.from.address'));
            }
            return [Response::HTTP_OK, "Contact Support Mail Send Successfully"];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage()];
        }

    }

}
