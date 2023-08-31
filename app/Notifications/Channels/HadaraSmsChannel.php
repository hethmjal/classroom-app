<?php

namespace App\Notifications\Channels;

use App\Services\HadaraSms;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class HadaraSmsChannel 
{
    public function send(object $notifiable, Notification $notificaion)
    {
        $service= new HadaraSms(config('services.hadara.key'));
        $service->send($notifiable->routeNotificationForHadara(),$notificaion->toHadara($notifiable));
    }
}