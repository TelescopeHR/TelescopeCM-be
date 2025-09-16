<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CreatedByObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function created(Model $model)
    {
        if (Auth::user()) {
            $model->createdBy()->associate(Auth::user());
            $model->save();
        }
    }
}
