<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Support\Str;

class NewAdminContactNotification extends Notification
{
    use Queueable;

    public $sender, $title, $mailId;

    public function __construct($sender, $title, $mailId)
    {
        $this->sender  = $sender;
        $this->title   = $title;
        $this->mailId  = $mailId;
    }

    public function via(object $notifiable): array
    {
        return ['mail','database', 'broadcast'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Message from ' . $this->sender->name)
            ->greeting('Hello!')
            ->line('You have received a new message from an admin.')
            ->line('**Sender Name:** ' . $this->sender->name)
            ->line('**Sender Email:** ' . $this->sender->email)
            ->line('**Sender Role:** ' . ($this->sender->authorization?->role ?? 'Unknown'))
            ->line('**Message Title:** ' . $this->title)
            ->action('View Message', route('admin.mails.show', $this->mailId))
            ->line('Thank you for using our system!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'sender_name'      => $this->sender->name,
            'sender_email'     => $this->sender->email,
            'sender_img'       => asset($this->sender->image),
            'sender_role'      => $this->sender->authorization?->role ?? 'Unknown',
            'title'            => Str::limit($this->title, 25),
            'notification_type'=> 'mail',
            'url'              => route('admin.mails.show', $this->mailId),
        ];
    }

    public function toBroadcast(object $notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
