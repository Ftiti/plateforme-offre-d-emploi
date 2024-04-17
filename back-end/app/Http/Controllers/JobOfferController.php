<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index()
    {
        return JobOffer::all();
    }

    public function store(Request $request)
    {
        $jobOffer = JobOffer::create($request->all());
        return response()->json($jobOffer, 201);
    }

    public function show(JobOffer $jobOffer)
    {
        return $jobOffer;
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        $jobOffer->update($request->all());
        return response()->json($jobOffer, 200);
    }

    public function destroy(JobOffer $jobOffer)
    {
        $jobOffer->delete();
        return response()->json(null, 204);
    }
}
