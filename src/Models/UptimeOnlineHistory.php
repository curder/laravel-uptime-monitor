<?php

namespace Spatie\UptimeMonitor\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 站点在线记录
 *
 * Class UptimeHistory
 *
 * @property string history_uuid
 * @property integer monitor_id
 * @property integer http_code
 * @property integer file_time
 * @property float total_time
 * @property float connect_time
 * @property float namelookup_time
 * @property float remote_server_handle_time
 * @property float redirect_time
 * @property string uptime_history_extras
 *
 * @package App\Models
 */
class UptimeOnlineHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'history_uuid', 'monitor_id', 'http_code', 'file_time', 'total_time', 'connect_time', 'namelookup_time',
        'remote_server_handle_time', 'redirect_time', 'uptime_history_extras',
    ];

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uptime_history_extras' => 'json',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'history_uuid';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Prevent Eloquent from overriding uuid with `lastInsertId`.
     *
     * @var bool
     */
    public $incrementing = false;
}
