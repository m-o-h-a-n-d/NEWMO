<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewContactNotify extends Notification
{
    use Queueable;

    public $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user_name'      => $this->contact->name,
            'contact_title'  => $this->contact->title,
            'contact_time'   => date('Y-m-d h:i a'),
            'notification_type'=> 'notification',
            'link'  => route('admin.contacts.show', $this->contact->id),
        ];
    }

    // ✅ لازم تضيف دي عشان Laravel يرسل البيانات لـ Echo بشكل صحيح
  public function toBroadcast(object $notifiable)
{
    return new BroadcastMessage($this->toArray($notifiable));
}
}
