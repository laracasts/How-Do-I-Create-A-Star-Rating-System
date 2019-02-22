<?php

namespace App;

use InvalidArgumentException;

trait CanBeRated
{
    /**
     * Rate the article.
     *
     * @param int       $rating
     * @param User|null $user
     */
    public function rate($rating, $user = null)
    {
        if ($rating > 5 || $rating < 1) {
            throw new InvalidArgumentException('Ratings must be between 1-5.');
        }

        $userId = $user ? $user->id : auth()->id();

        $this->ratings()->updateOrCreate(['user_id' => $userId], compact('rating'));
    }

    /**
     * Fetch the average rating for the article.
     *
     * @return int
     */
    public function rating()
    {
        return $this->ratings()->avg('rating');
    }

    /**
     * Fetch the rating for the given user.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function ratingFor(User $user)
    {
        return $this->ratings()->where('user_id', $user->id)->value('rating');
    }

    /**
     * Get all ratings for the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}