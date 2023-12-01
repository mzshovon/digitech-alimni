<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UpdateUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\MembershipUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Services\User\UserService;
use App\Models\Role;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function getUsers(UserService $userService){
        try {
            $data['users'] = $userService->getUsersInfo();
            // dd($data['users']);
            $data['title'] = "Members List";
            $data['roles'] = Role::all();
            return view('admin.user.index', $data);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function filter(Request $request, UserService $userService)
    {
        $from = $request->get('from') ? Carbon::parse($request->get('from'))->format('Y-m-d') : null;
        $to = $request->get('to') ? Carbon::parse($request->get('to'))->format('Y-m-d') : null;
        if(($from && !$to) || (!$from && $to)) {
            Session::put("error", "From and To date must be kept both filled or both empty");
            return redirect()->back();
        }
        $payment = $request->get('payment') ?? null;
        $batch = $request->get('batch') ?? null;
        $blood_group = $request->get('blood_group') ?? null;
        return $userService->filterUsersData($from, $to, $payment, $blood_group, $batch);
    }

    public function createUser(){
        try {
            $data['title'] = "Add Member";
            return  view('admin.user.create', $data);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function storeUser(CreateUserRequest $request, UserService $userService){
        try {
            $memberData['first_name'] = $request->first_name;
            $memberData['last_name'] = $request->last_name;
            $userData['name'] = $request->first_name . " " . $request->last_name;
            $userData['email'] = $request->email;
            $userData['contact'] = $request->contact;
            $memberData['nid'] = $request->nid;
            $memberData['dob'] = $request->dob;
            $memberData['address'] = $request->address;
            $memberData['blood_group'] = $request->blood_group;
            $memberData['batch'] = $request->batch;
            $memberData['payment'] = $request->payment;
            $memberData['employeer_name'] = $request->employeer_name;
            $memberData['designation'] = $request->designation;
            $memberData['employeer_address'] = $request->employeer_address;
            $memberData['reference'] = $request->reference;
            $memberData['reference_number'] = $request->reference_number;
            $memberData['image_path'] = $request->profile_image ?? null;
            $memberData['membership_id'] = $request->membership_id ?? null;
            // dd($userData, $memberData);
            [$status, $message] = $userService->createMemberWithUserDetails($memberData, $userData);
            Session::put($status, $message);
            return redirect()->route('admin.createUser');

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function editUser($userId, UserService $userService){
        try {
            $data['title'] = auth()->user()->hasRole('user') ? "Member Details" : "Update Member Details";
            $data['user'] = $userService->getUserInfoById($userId);
            if(!$data['user']) {
                Session::put("error", "No user found for this id!");
                return redirect()->route('admin.usersList');
            }
            return view('admin.user.edit', $data);

        } catch (\Throwable $th) {
            return back()->with(500, $th->getMessage());
        }
    }

    // public function deleteUser($userId){
    //     try {
    //         $data = [];
    //         [$data['statusName'], $data['message']] = $this->repo->deleteUserById($userId);
    //         return $this->success($data);

    //     } catch (\Exception $e) {
    //         return $this->error("Something went wrong with error ".$e, null, $e->getCode());
    //     }
    // }

    public function assignMembershipId(MembershipUpdateRequest $request, UserService $userService) {
        $id = $request->user_id;
        $email = $request->user_email;
        $membership_id = $request->membership_id;
        [$message, $status] = $userService->assignMemberShipId($id, $membership_id, $email);
        Session::put($message, $status);
        return redirect()->route('admin.usersList');

    }

    public function profile()
    {
        $data['title'] = "User Profile";
        return view("admin.profile.index", $data);
    }

    public function profileUpdate(ProfileUpdateRequest $request, UserService $userService)
    {
        $userId= $request->id;
        $updateType= $request->type ?? "profile";
        $memberData['first_name'] = $request->first_name;
        $memberData['last_name'] = $request->last_name;
        $userData['name'] = $request->first_name . " " . $request->last_name;
        $userData['email'] = $request->email;
        $userData['contact'] = $request->contact;
        $memberData['nid'] = $request->nid;
        $memberData['dob'] = $request->dob;
        $memberData['address'] = $request->address;
        $memberData['blood_group'] = $request->blood_group;
        $memberData['batch'] = $request->batch;
        $memberData['payment'] = $request->payment;
        $memberData['employeer_name'] = $request->employeer_name;
        $memberData['designation'] = $request->designation;
        $memberData['employeer_address'] = $request->employeer_address;
        $memberData['reference'] = $request->reference;
        $memberData['reference_number'] = $request->reference_number;
        $memberData['membership_id'] = $request->membership_id ?? null;
        $memberData['image_path'] = $request->profile_image ?? null;
        [$message, $status] = $userService->updateUserInfoById($userId, $memberData, $userData);
        Session::put($message, $status);
        if($updateType == "updateMember") {
            return redirect()->back();
        }
        return redirect("/admin/user-profile");
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        Auth::logout();
        return redirect('/login');
    }
}
