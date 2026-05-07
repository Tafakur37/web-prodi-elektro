<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $submission_id;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $submission_id, $type = 'info')
    {
        $this->title = $title;
        $this->message = $message;
        $this->submission_id = $submission_id;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'submission_id' => $this->submission_id,
            'type' => $this->type,
        ];
    }
}
