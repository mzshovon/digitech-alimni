<?php

namespace App\Http\Services\Utilities;

use App\Exports\ExportExcel;
use App\Http\Resources\NewsLetterResource;
use App\Models\NewsLetter;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class NewsLetterService {

    private $valueListForTop = ["first_name", "nid"];
    private $columnsValue = [];

    public function __construct(private NewsLetter $newsLetter, private User $user)
    {

    }

    public function getNewsLettertData()
    {
        $newsLetter = $this->newsLetter;
        $userId = (getUserInfo()->hasRole("superadmin") || getUserInfo()->hasRole("admin")) ? null : getUserInfo()->id;
        $data = $newsLetter->getNewsLetters($userId);
        $resourceData = NewsLetterResource::collection($data)->toArray($data);
        return $resourceData ?? [];
    }

    public function filterNewsLettertData($from, $to, $status)
    {
        $newsLetter = $this->newsLetter;
        $filteredData = $newsLetter->getNewsLetterts(null, null, $from, $to, $status);
        $resourceData = NewsLetterResource::collection($filteredData)->toArray($filteredData);
        $format = "xlsx";
        $file = "NewsLetter Data.$format";
        return Excel::download(new ExportExcel($resourceData, $this->columnsValue), $file);
    }

    public function getAllEmails()
    {
        $emails = $this->user->getUserValueList(['email']);
        return $emails;
    }

    /**
     * @param mixed $members
     * @param mixed $batch
     * @param mixed $emails
     * @param mixed $start_period
     * @param mixed $end_period
     * @param mixed $template_name
     * @param mixed $news
     *
     * @return [type]
     */
    public function storeNewsLetterInfo($members, $batch, $emails, $start_period, $end_period, $template_name, $news)
    {
        try {
            $user = $this->user;
            $newsLetter = $this->newsLetter;
            $userId = getUserInfo()->id;
            $getEmailList = $user->getUsersList(null, ['email'], null, null, $members, null, $batch, "DESC", "user");
            if(count($getEmailList)) {
                $emailList = array_column($getEmailList, 'email');
                dd($emailList);
                if($newsLetter->createNewNewsLetterRequest($data)) {
                    return [Response::HTTP_OK, "NewsLetter Request Updated Successfully. Admin will review and confirm your NewsLetter record soon."];
                }
            } else {
                return [Response::HTTP_NOT_FOUND, "No user email found"];
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
    public function updateNewsLetterInfo($data, $userId)
    {
        try {
            $newsLetter = $this->newsLetter;
            if($data['image_path']){
                $dirName = storeOrUpdateImage("storage/img/payment/$userId/", $data['image_path'], "payment", false);
                $data['image_path'] = $dirName;
            } else {
                unset($data['image_path']);
            }
            if(in_array($newsLetter->getSingleNewsLetterByParam('user_id', $userId)->status, ["approved", "declined"])) {
                return [Response::HTTP_BAD_REQUEST, "NewsLetter is already ".$newsLetter->getSingleNewsLetterByParam('user_id', $userId)->status."! You can't update it"];
            }
            if($newsLetter->updateNewsLetterRequest($data ,"user_id", $userId)) {
                return [Response::HTTP_OK, "NewsLetter Request Placed Successfully. Admin will review and confirm your payment status soon."];
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
    public function updateNewsLetterStatus($data, $id)
    {
        try {
            $newsLetter = $this->newsLetter;
            if($newsLetter->updateNewsLetterRequest($data ,"id", $id)) {
                return [Response::HTTP_OK, "NewsLetter status updated successfully"];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage()];
        }

    }

}
