<?php

namespace App\Http\Services\User;

use App\Events\ActivityLogEvent;
use App\Exports\ExportExcel;
use App\Http\Enums\ModuleEnum;
use App\Http\Resources\UserResource;
use App\Models\MembershipDetail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserService {

    private $columnsValue = ["Name", "Membership ID", "Email", "Contact", "Payment", "Batch", "Blood Group", "Registered At"];

    public function __construct(private User $user, private MembershipDetail $membershipDetail){}

    public function getUsersInfo($batch, $payment, $blood_group)
    {
        return $this->user->getUsersList(null, [], null, null, $payment, $blood_group, $batch) ?? [];
    }

    public function getUserInfoById($userId)
    {
        return $this->user->getSingleUserByParam("id", $userId) ?? null;
    }

    public function getUserListByKeyword($keyword)
    {
        return $this->user->getUsersListByKeywordSearch($keyword) ?? [];
    }

    public function filterUsersData($from, $to, $payment, $blood_group, $batch)
    {
        $user = $this->user;
        $filteredData = $user->getUsersList(null, null, $from, $to, $payment, $blood_group, $batch);
        $resourceData = UserResource::collection($filteredData)->toArray($filteredData);
        $format = "xlsx";
        $file = "Users Data.$format";
        return Excel::download(new ExportExcel($resourceData, $this->columnsValue), $file);
    }

    public function assignMemberShipId($id, $membership_id, $email)
    {
        try {
            $update = $this->membershipDetail->updateMemberByParam("id", $id, ['membership_id' => $membership_id]);
            if($update) {
                $this->membershipIdProvidingMail($membership_id, $email);
                return ["success", "Membership ID assigned successfully!"];
            }
        } catch (QueryException | Exception $e) {
            return ["error", "Something Went Wrong. Error: ".$e->getMessage()];
        }
    }

    public function storeUserInfo($name, $email, $status)
    {
        try {
            $formatForStoreUser = [
                "name" => $name,
                "email" => $email,
                "password" => \bcrypt($email),
                "status" => $status,
            ];

            if ($this->user::create($formatForStoreUser)) {
                return ["success", "User Created Sucessfully!"];
            }

        } catch (QueryException | Exception $e) {
            return ["error", "Something Went Wrong. Error: ".$e->getMessage()];
        }
    }

    public function createMemberWithUserDetails($memberData, $userData)
    {
        try {
            $userData['password'] = bcrypt($userData['email']);
            // dd($userData);
            $createUser = $this->user->createUser($userData);
            if($createUser) {
                $userId = $createUser->id;
                $memberData['user_id'] = $userId;
                if($memberData['image_path']){
                    $dirName = storeOrUpdateImage("storage/img/profile/$userId/", $memberData['image_path'], 'profile');
                    $memberData['image_path'] = $dirName;
                } else {
                    unset($memberData['image_path']);
                }
                if($this->membershipDetail->createNewMember($memberData)) {
                    if($memberData['membership_id']) {
                        $this->membershipIdProvidingMail($memberData['membership_id'], $userData['email']);
                    }
                    return ["success", "Member created successfully!"];
                }
            }

        } catch (QueryException | Exception $e) {
            return ["error", "Something Went Wrong. Error: ".$e->getMessage()];
        }
    }

    public function updateUserInfoById(int $userId, $memberData, $userData)
    {
        try {
            if($memberData['image_path']){
                $dirName = storeOrUpdateImage("storage/img/profile/$userId/", $memberData['image_path'], 'profile');
                $memberData['image_path'] = $dirName;
            } else {
                unset($memberData['image_path']);
            }
            if ($this->user::updateUserByParam("id", $userId, $userData)) {
                if(!$memberData['membership_id']) {
                    unset($memberData['membership_id']);
                }
                $oldMembershipId = $this->membershipDetail::getSingleMemberByParam("user_id", $userId)->membership_id;
                if ($this->membershipDetail::updateMemberByParam("user_id", $userId, $memberData)) {
                    if(array_key_exists('membership_id', $memberData) && $memberData['membership_id'] != $oldMembershipId) {
                        $this->membershipIdProvidingMail($memberData['membership_id'], $userData['email']);
                    }
                    return ["success", "Profile Info Updated Sucessfully!"];
                }
            }

        } catch (QueryException | Exception $e) {
            return ["error", "Something Went Wrong. Error: ".$e->getMessage()];
        }
    }

    // public function deleteUserById(int $userId)
    // {
    //     try {
    //         $deleteUserParam = 'id';
    //         $userInfo = $this->user::getSingleUserByParam($deleteUserParam, $userId);
    //         if($this->user::deleteUserByParam($deleteUserParam, $userId)) {
    //             event(new ActivityLogEvent(ModuleEnum::UserDelete->value, "Delete user by $userId with param $deleteUserParam", "User named $userInfo->name deleted", "user-delete"));
    //             return ["success", "User Deleted Sucessfully!"];
    //         }

    //     } catch (QueryException | Exception $e) {
    //         return ["error", "Something Went Wrong. Error: ".$e->getMessage()];
    //     }
    // }

    private function membershipIdProvidingMail($membership_id, $email) : void
    {
        $data['subject'] = "New Membership ID $membership_id is provided";
        $data['membership_id'] = $membership_id;
        event(sendMailWithTemplate($data, "admin.template.mail.membership", $email));
    }

}
