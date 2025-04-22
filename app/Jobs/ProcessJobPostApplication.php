<?php

namespace App\Jobs;

use App\Models\Candidate;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessJobPostApplication implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $resumePath,
        protected string $coverLetterPath,
        protected int $jobPostID,
        protected Candidate $candidate
        ) {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Storage::disk('public')->move($this->resumePath, $this->resumePath = 'resumes/' . basename($this->resumePath));
        \Storage::disk('public')->move($this->coverLetterPath, $this->coverLetterPath = 'cover_letters/' . basename($this->coverLetterPath));

        $this->candidate->jobs()->attach($this->jobPostID, [
            'resume_url'        => $this->resumePath,
            'cover_letter_url'  => $this->coverLetterPath,
        ]);
    }

    public function failed(\Throwable $e): void {
        \Log::error('Job failed: ' . $e->getMessage());
    }
}
