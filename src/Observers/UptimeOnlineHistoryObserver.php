<?php

namespace Spatie\UptimeMonitor\Observers;

use Illuminate\Support\Str;
use Spatie\UptimeMonitor\Models\UptimeOnlineHistory;

class UptimeOnlineHistoryObserver
{
    /**
     * Handle the Website "creating" event.
     *
     * @param  UptimeOnlineHistory  $uptimeHistory
     *
     * @return void
     */
    public function creating(UptimeOnlineHistory $uptimeHistory) : void
    {
        $uptimeHistory->history_uuid = Str::uuid();
    }

    /**
     * Handle the UptimeOnlineHistory "created" event.
     *
     * @param UptimeOnlineHistory  $uptimeOnlineHistory
     * @return void
     */
    public function created(UptimeOnlineHistory $uptimeOnlineHistory)
    {
        //
    }

    /**
     * Handle the UptimeOnlineHistory "updated" event.
     *
     * @param UptimeOnlineHistory  $uptimeOnlineHistory
     * @return void
     */
    public function updated(UptimeOnlineHistory $uptimeOnlineHistory)
    {
        //
    }

    /**
     * Handle the UptimeOnlineHistory "deleted" event.
     *
     * @param UptimeOnlineHistory  $uptimeOnlineHistory
     * @return void
     */
    public function deleted(UptimeOnlineHistory $uptimeOnlineHistory)
    {
        //
    }

    /**
     * Handle the UptimeOnlineHistory "restored" event.
     *
     * @param UptimeOnlineHistory  $uptimeOnlineHistory
     * @return void
     */
    public function restored(UptimeOnlineHistory $uptimeOnlineHistory)
    {
        //
    }

    /**
     * Handle the UptimeOnlineHistory "force deleted" event.
     *
     * @param UptimeOnlineHistory  $uptimeOnlineHistory
     * @return void
     */
    public function forceDeleted(UptimeOnlineHistory $uptimeOnlineHistory)
    {
        //
    }
}
