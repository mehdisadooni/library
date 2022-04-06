<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function setAuthorAttribute($author)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => 'author',

        ]);
    }

    /**
     * @param $user
     * @return void
     */
    public function checkout($user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now()
        ]);
    }

    /**
     * @param $user
     * @return void
     * @throws \Exception
     */
    public function checkin($user)
    {
        $reservation = $this->reservations()
            ->where('user_id', $user->id)
            ->whereNotNull('checked_out_at')
            ->whereNull('checked_in_at')
            ->first();

        if (is_null($reservation)) {
            throw new \Exception();
        }

        $reservation->update([
            'checked_in_at' => now()
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
