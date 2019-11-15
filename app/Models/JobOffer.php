<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class JobOffer
 * @package App\Models
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $email
 * @property string $state
 * @property Carbon $valid_until
 * @property Carbon $created_at
 * @property Carbon $updated_at

 */
class JobOffer extends Model
{
    public const SPAM = 'spam';
    public const PUBLISHED = 'published';
    public const NO_STATE = null;

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
        'state',
        'valid_until'
    ];

    protected $casts = [
        'valid_until' => 'datetime'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
