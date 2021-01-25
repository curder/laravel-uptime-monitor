<?php

namespace Spatie\UptimeMonitor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * 离线历史记录
 *
 * Class OfflineHistory
 *
 * @property integer website_id
 * @property string reason
 * @property string started_at
 * @property string ended_at
 * @property string offline_history_extras
 * @property string duration_time
 *
 * @property Monitor monitor
 *
 * @package App\Models
 */
class UptimeOfflineHistory extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    public $fillable = [
        'monitor_id', 'reason', 'started_at', 'ended_at', 'duration_time',
    ];

    /**
     * @return BelongsTo
     */
    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class, 'monitor_id');
    }
}
