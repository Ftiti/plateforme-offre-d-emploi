<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\JobApplication;
use App\Models\Profile;
use App\Models\User;
use App\Models\JobOffer;
use App\Mail\NewJobApplicationNotification;
class JobApplicationController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'user_id' => 'required|exists:users,id',
        'job_offer_id' => 'required|exists:job_offers,id',
    ]);

    $application = JobApplication::create($data);

    $user = User::findOrFail($request->user_id);
    $profile = Profile::where('user_id', $user->id)->firstOrFail();

    $jobOffer = JobOffer::findOrFail($request->job_offer_id);
    Mail::to('fadhelfteiti@gmail.com')->send(new NewJobApplicationNotification($user, $jobOffer, $profile));

    return response()->json($application, 201);
}

    public function list()
    {
        $jobApplications = JobApplication::with('user.profile')->get();
        return response()->json($jobApplications);
    }

}

