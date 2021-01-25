<?php

namespace Spatie\UptimeMonitor\Observers;

use Spatie\UptimeMonitor\Models\Monitor;

class MonitorObserver
{
    /**
     * Handle the Monitor "creating" event.
     *
     * @param  Monitor  $monitor
     * @return bool
     */
    public function creating(Monitor $monitor): bool
    {
        $monitor->identifier = $monitor->generateRandomString();
        $monitor->alias = $monitor->alias ?? parse_url($monitor->url, PHP_URL_HOST);

        // 如果创建已经存在但是被删除的资源
        if ($trashedMonitor = Monitor::onlyTrashed()->where('url', $monitor->url)->first()) {
            $trashedMonitor->restore();
            return false;
        }

        return true;
    }


    /**
     * Handle the Monitor "created" event.
     *
     * @param  Monitor  $monitor
     * @return void
     */
    public function created(Monitor $monitor) : void
    {
        //
    }

    /**
     * Handle the Monitor "updated" event.
     *
     * @param  Monitor  $monitor
     * @return void
     */
    public function updated(Monitor $monitor) : void
    {
        //
    }

    /**
     * Handle the Monitor "deleted" event.
     *
     * @param  Monitor  $monitor
     * @return void
     */
    public function deleted(Monitor $monitor) : void
    {
        //
    }

    /**
     * Handle the Monitor "restored" event.
     *
     * @param  Monitor  $monitor
     * @return void
     */
    public function restored(Monitor $monitor) : void
    {
        //
    }

    /**
     * Handle the Monitor "force deleted" event.
     *
     * @param  Monitor  $monitor
     * @return void
     */
    public function forceDeleted(Monitor $monitor) : void
    {
        //
    }
}
