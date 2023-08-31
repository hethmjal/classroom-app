<?php

namespace App\Notifications;

use App\Models\Classwork;
use App\Notifications\Channels\HadaraSmsChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;


class NewClassworkNotification extends Notification 
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Classwork $classwork)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Channels: mail, database, broadcast, vonage, slack
        return [/* HadaraSmsChannel::class, */'database','broadcast','mail',/* 'vonage' */];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__('New :type added !',['type' => $this->classwork->type->value]))
                    ->greeting(__("Hi :name",['name' => $notifiable->name]))
                    ->line(__(':name posted a new :type: :title',[
                        'name' => $this->classwork->user->name,
                        'type' => __($this->classwork->type->value),
                        'title' => $this->classwork->title,
                    ]))
                    ->action(__('Go to classwork'),
                     route('classrooms.classworks.show',[$this->classwork->classroom_id,$this->classwork->id]))
                    ->line('Thank you for using our application!')
                    //->view("view.index",compact("x","y","z"))
                    ;
    }


    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage($this->createMessage());
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {

        return new BroadcastMessage($this->createMessage());
    }

    
    public function toVonage(object $notifiable): VonageMessage
    {
        return (new VonageMessage)
                    ->content(__('New :type added !',['type' => $this->classwork->type->value]));
    }

    public function toHadara(object $notifiable): string
    {
        
        return __('New :type added !',['type' => $this->classwork->type->value]);
    }

    public function createMessage() 
    {
        $content =  __(':name posted a new :type: :title',[
            'name' => $this->classwork->user->name,
            'type' => __($this->classwork->type->value),
            'title' => $this->classwork->title,
        ]);

        return [
            'title' => __('New :type added !',['type' => $this->classwork->type->value]),
            'body' => $content,
            'image' => '',
            'link' => route('classrooms.classworks.show',[$this->classwork->classroom_id,$this->classwork->id]),
            'classwork' => $this->classwork,
        ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }


}
