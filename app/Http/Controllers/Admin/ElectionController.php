<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Election\ElectionService;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    public function view(ElectionService $electionService)
    {
        $data = [];
        $data['title'] = "Election";
        $data['elections'] = $electionService->getElections();
        return view('admin.election.index', $data);
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
