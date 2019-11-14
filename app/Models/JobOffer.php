<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOffer extends Model
{
    /**
     * @var string
     */
    protected $table = 'job_offers';
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'email',
        'isSpam',
        'isPublished',
        'valid_until'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopePublished(Builder $query)
    {
        $query->where('isPublished', '=', 1);
    }

    public function scopeUnPublished(Builder $query)
    {
        $query->where('isPublished', '=', 0);
    }

    public function scopeIsSpam(Builder $query)
    {
        $query->where('isSpam', '=', 1);
    }

    public function scopeIsNotSpam(Builder $query)
    {
        $query->where('isSpam', '=', 0);
    }
}
