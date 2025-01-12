<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class DownloadedVideoNotificationComponent extends Component
{
    public string $notifications;

//    #[On('echo:download-video,DownloadEvent')]
//    public function listenForMessage($data): void
//    {
//        $this->notifications = $data['message'];
//    }

    public function render()
    {
        return view('livewire.downloaded-video-notification-component');
    }
}
