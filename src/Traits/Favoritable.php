<?php

namespace Smartopolis\Favorites\Traits;

use Smartopolis\Favorites\Models\Favorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait Favoritable
{
    /**
     * Fetch all favorites for the model.
     *
     * @return MorphMany
     */
    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /**
     * Scope a query to records favorited by the given user.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeFavorited($query): Builder
    {
        return $query->whereHas('favorites', function ($query) {
            $query->where('user_id', auth('api')->id());
        });
    }

    /**
     * Determine if the model is favorited by the given user.
     *
     * @return bool
     */
    public function isFavorited(): bool
    {
        return $this->favorites()
            ->where('user_id', auth('api')->id())
            ->exists();
    }

    /**
     * Have the authenticated user favorite the model.
     *
     * @return void
     */
    public function toggleFavorite()
    {
        if ($this->isFavorited()) {
            $this->favorites()
                ->where('user_id', auth()->id())
                ->delete();
        } else {
            $this->favorites()->save(
                new Favorite(['user_id' => auth('api')->id()])
            );
        }
    }

    /**
     * Returns model favorited attribute.
     *
     * @return bool
     */
    public function getFavoritedAttribute(): bool
    {
        return self::isFavorited();
    }
}
