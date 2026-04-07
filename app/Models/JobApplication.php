<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resume_id',
        'job_title',
        'company_name',
        'job_description',
        'tailored_resume',
        'cover_letter',
        'status',
        'match_score',
        'match_label',
    ];

    protected $casts = [
        'tailored_resume' => 'array',
        'match_score'     => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
