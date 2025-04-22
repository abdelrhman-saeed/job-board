<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_post_id',
        'candidate_id',
        'resume_url',
        'cover_letter_url',
    ];

    public function job(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(JobPost::class, 'job_post_id');
    }
}
