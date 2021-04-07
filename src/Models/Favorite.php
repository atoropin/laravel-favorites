<?php

namespace Rir\Favorites\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * App\Models\Favorite
 *
 * @property int $id
 * @property int $user_id
 * @property string $favoritable_type
 * @property int $favoritable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $favoritable
 * @property-read User $user
 * @method static Builder|Favorite whereId($value)
 * @method static Builder|Favorite whereFavoritableId($value)
 * @method static Builder|Favorite whereFavoritableType($value)
 * @method static Builder|Favorite whereUpdatedAt($value)
 * @method static Builder|Favorite whereUserId($value)
 * @mixin Eloquent
 */
class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'favoritable_id',
        'favoritable_type'
    ];

    /**
     * The model that gets favorited.
     */
    public function favoritable(): Relation
    {
        return $this->morphTo();
    }

    /**
     * The user who favorited something.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
