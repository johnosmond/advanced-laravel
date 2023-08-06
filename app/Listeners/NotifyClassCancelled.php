<?php

namespace App\Listeners;

use App\Events\ClassCancelled;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyClassCancelled
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassCancelled $event): void
    {
        $scheduledClass = $event->scheduledClass;
        Log::info($scheduledClass);
    }
}
