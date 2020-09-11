<?php


namespace App\Traits;


use App\User;

trait ModelTrait
{
    public function user()
    {
        return $this->belongsTo(User::class, 'entry_by', 'id');
    }

}
