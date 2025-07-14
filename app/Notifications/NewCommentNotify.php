<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public  $post, $comment, $commenter, $postOwner;
    public function __construct($post, $comment, $commenter, $postOwner)
    {

        $this->post = $post;
        $this->comment = $comment;
        $this->commenter = $commenter;
        $this->postOwner = $postOwner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array // Chanel is used to send  the notification ببعت ليها
    {
        return ['database', 'broadcast']; // send to database وفي كذا واحده من النوع via ممكن تشوفها في Documintation laravel
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }


    public function toArray(object $notifiable): array // toArray / toDataBase  , Broadcast => toArray /  toBroadcast
    {
        return [
            // انا بسجل data على هيءه Array => decode(json )= >عند الاستلام => Encode (Array) => Array

            // معلومات اللي عمل الكومنت
            'commenter_id' => $this->commenter->id,
            'commenter_name' => $this->commenter->username,
            'commenter_image' => $this->commenter->image_url,

            // معلومات صاحب البوست
            'post_owner_id' => $this->postOwner->id,
            'post_owner_name' => $this->postOwner->username,
            'post_owner_image' => $this->postOwner->image_url,

            'post_title' => $this->post->title,
            'comment' => $this->comment->comment,
            'url' => route('frontend.single.posts', $this->post->slug),
        ];
    }

    public function broadcastType(): string // to cutomize the notification type
    {
        return 'NewCommentNotify'; // class name
    }

    public function databaseType(object $notifiable): string
{
    return 'NewCommentNotify';
}

// علشان الإشعارات توصل Live، لازم تتأكد إنك عامل:

// إعدادات Pusher في .env مظبوطة.

// مشغّل laravel-echo من الـ JS.

// عامل Listen في الـ JS:


}
