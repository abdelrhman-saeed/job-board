<?php

namespace App\Http\Controllers;

use App\Models\{JobApplication, JobPost};
use Illuminate\Http\Request;
use App\Jobs\ProcessJobPostApplication;

class JobApplicationController extends Controller
{

    public function apply(Request $request, int $id)
    {
        /**
         * @var \App\Models\Candidate
         */
        $candidate = auth()->user();

        if ($candidate->jobs()->where("job_post_id", $id)->exists()) {
            return response()->json(['message' => 'you already applied!'], 403);
        }

        $request->validate([
            'resume_url'        => 'required|file|mimes:pdf,doc,docx|max:10240',
            'cover_letter_url'  => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $resumePath = $request->file('resume_url')
            ->store('temp/resumes', 'public');

        $coverLetterPath = $request->file('cover_letter_url')
            ->store('temp/cover_letters', 'public');

        ProcessJobPostApplication::dispatch($resumePath, $coverLetterPath, $id, auth()->user());
    }

}
