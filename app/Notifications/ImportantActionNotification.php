<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportantActionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $action;
    protected $description;
    protected $performer;
    protected $performerRole;

    public function __construct($action, $description, $performer, $performerRole = 'system')
    {
        $this->action = $action;
        $this->description = $description;
        $this->performer = $performer;
        $this->performerRole = $performerRole;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'action' => $this->action,
            'description' => $this->description,
            'performer' => $this->performer,
            'performer_role' => $this->performerRole,
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
        ];
    }

    private function getIcon(): string
    {
        return match($this->action) {
            'Staff Account Created' => 'fa-user-plus',
            'Staff Account Deleted' => 'fa-user-minus',
            'Password Changed' => 'fa-key',
            'Deleted Staff Account' => 'fa-user-slash',
            default => 'fa-bell',
        };
    }

    private function getColor(): string
    {
        return match($this->action) {
            'Staff Account Created' => 'success',
            'Staff Account Deleted' => 'danger',
            'Deleted Staff Account' => 'danger',
            default => 'info',
        };
    }
}
