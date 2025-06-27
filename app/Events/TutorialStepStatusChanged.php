<?php

// ====================================================================
// LANGKAH 1: PERBARUI EVENT UNTUK MEMBAWA STATUS BARU
// Lokasi: app/Events/TutorialStepStatusChanged.php
// (Kode ini seharusnya sudah benar)
// ====================================================================

namespace App\Events;

use App\Models\TutorialDetail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TutorialStepStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TutorialDetail $detail;
    public string $newStatus;

    public function __construct(TutorialDetail $tutorialDetail, string $newStatus)
    {
        $this->detail = $tutorialDetail;
        $this->newStatus = $newStatus;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('tutorial.' . $this->detail->tutorial_id),
        ];
    }
}
