<?php
namespace Spatie\UptimeMonitor\Helpers;

use GuzzleHttp\TransferStats;
use Spatie\UptimeMonitor\Models\Monitor;

/**
 * Class StatsHandler
 *
 * @package \Spatie\UptimeMonitor\Helpers
 */
class StatsHandler
{
    /**
     * @var Monitor
     */
    protected $monitor;
    /**
     * StatsHandler constructor.
     *
     * @param  Monitor  $monitor
     */
    public function __construct(Monitor $monitor)
    {
        $this->monitor = $monitor;
    }
    /**
     * @param  \GuzzleHttp\TransferStats  $stats
     */
    public function __invoke(TransferStats $stats)
    {
        $this->monitor->uptime_extras = collect([
            'total_time'                => $stats->getHandlerStat('total_time'),
            'http_code'                 => $stats->getHandlerStat('http_code'),
            'namelookup_time'          => $stats->getHandlerStat('namelookup_time'),
            'connect_time'              => $stats->getHandlerStat('connect_time'),
            'redirect_time'             => $stats->getHandlerStat('redirect_time'),
            'file_time'                 => $stats->getHandlerStat('filetime'),
            'remote_server_handle_time' => $stats->getHandlerStat('starttransfer_time') - $stats->getHandlerStat('pretransfer_time'),
        ])->mapWithKeys(function ($value, $key) {
            // 整理数据格式
            if (in_array($key, ['total_time', 'namelookup_time', 'connect_time', 'remote_server_handle_time'], true)) {
                $value = number_format($value, 10);
            }

            return [$key => $value];
        })->toArray();
    }
}
