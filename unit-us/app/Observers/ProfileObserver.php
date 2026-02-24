<?php

namespace App\Observers;

use App\Models\Profile;

class ProfileObserver
{
    public function deleting(Profile $profile): void
    {
        $profile->pointTransactions()->delete();
        $profile->redemptions()->delete();
        $profile->events()->detach();
    }
}
