<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\StatusEnum;
use App\Http\Requests\ElectionCreateRequest;
use App\Http\Services\Election\ElectionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ElectionController extends Controller
{
    public function view(ElectionService $electionService)
    {
        $data = [];
        $data['title'] = "Election";
        $data['elections'] = $electionService->getElections();
        return view('admin.election.index', $data);
    }

    public function store(ElectionCreateRequest $request, ElectionService $electionService)
    {
        try {
            $data['title'] = $request->title ?? null;
            $data['start_date'] = Carbon::parse($request->start_date)->format('d-m-Y') ?? null;
            $data['end_date'] = Carbon::parse($request->end_date)->format('d-m-Y') ?? null;
            $data['status'] = $request->status ?? StatusEnum::Paused;
            $positions = $request->positions ?? null;
            [$status, $message] = $electionService->storeElectionData($data, $positions);
            Session::put(($status == Response::HTTP_OK) ? "success" : "error", $message);
            return redirect()->route('admin.electionsList');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
