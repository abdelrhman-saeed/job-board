<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;


class JobPost extends Model
{
    /** @use HasFactory<\Database\Factories\JobPostFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'location',
        'min_salary',
        'max_salary',
        'is_remote',
        'published_at'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany(Candidate::class);
    }


    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (is_a(request()->user(), Company::class)) {
            $query = $query->where('company_id', request()->user()->id);
        }

        return $query
            ->when(
                $filters['title'] ?? false,
                fn($q, $title) =>
                $q->where('title', 'like', "%$title%")
            )
            ->when(
                $filters['location'] ?? false,
                fn($q, $location) =>
                $q->where('location', 'like', "%$location%")
            )
            ->when(
                isset($filters['is_remote']),
                fn($q) =>
                $q->where('is_remote', (bool) $filters['is_remote'])
            )
            ->when(
                $filters['description'] ?? false,
                fn($q, $description) =>
                $q->where(
                    fn($q) =>
                    $q->where('title', 'like', "%$description%")
                        ->orWhere('description', 'like', "%$description%")
                )
            );
    }
}
