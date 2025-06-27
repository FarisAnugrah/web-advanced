<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('tutorial.{tutorialId}', function ($user, $tutorialId) {
    return true;
});
