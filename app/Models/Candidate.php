<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Candidate extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'birth',
        'city',
        'country',
        'gender'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(JobPost::class, 'job_applications', 'candidate_id');
    }

    // public function jobPosts(): BelongsToMany
    // {
    //     return $this->belongsToMany(JobApplication::class, 'job_')
    // }
}
