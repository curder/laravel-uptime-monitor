<?php

namespace Spatie\UptimeMonitor\Models;

use Spatie\Url\Url;
use Illuminate\Database\Eloquent\Model;
use Spatie\UptimeMonitor\Models\Enums\UptimeStatus;
use Spatie\UptimeMonitor\Exceptions\CannotSaveMonitor;
use Spatie\UptimeMonitor\Models\Traits\ExtraAttributes;
use Spatie\UptimeMonitor\Models\Enums\CertificateStatus;
use Spatie\UptimeMonitor\Models\Traits\SupportsUptimeCheck;
use Spatie\UptimeMonitor\Models\Presenters\MonitorPresenter;
use Spatie\UptimeMonitor\Models\Traits\SupportsCertificateCheck;

/**
 * Class Monitor
 *
 * @property string identifier
 * @property string alias
 * @property string url
 * @property string raw_url
 * @property boolean uptime_check_enabled
 * @property string look_for_string
 * @property string uptime_check_interval_in_minutes
 * @property string uptime_status
 * @property string uptime_check_failure_reason
 * @property string uptime_check_times_failed_in_a_row
 * @property string uptime_status_last_change_date
 * @property string uptime_last_check_date
 * @property string uptime_check_failed_event_fired_on_date
 * @property string uptime_check_method
 * @property string uptime_check_payload
 * @property string uptime_check_additional_headers
 * @property string uptime_check_response_checker
 * @property boolean certificate_check_enabled
 * @property string certificate_status
 * @property string certificate_expiration_date
 * @property string certificate_issuer
 * @property string certificate_signature_algorithm
 * @property string certificate_check_failure_reason
 * @property string deleted_at
 * @property string created_at
 * @property string updated_at
 *
 * @property string scheme
 * @property string host
 * @property boolean is_ssl
 * @property ?int port
 *
 * @package App\Models
 */
class Monitor extends Model
{
    use SupportsUptimeCheck;
    use SupportsCertificateCheck;
    use MonitorPresenter;
    use ExtraAttributes;

    protected $guarded = [];

    protected $appends = ['raw_url'];

    protected $dates = [
        'uptime_last_check_date',
        'uptime_status_last_change_date',
        'uptime_check_failed_event_fired_on_date',
        'certificate_expiration_date',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'uptime_check_enabled' => 'boolean',
        'certificate_check_enabled' => 'boolean',
    ];

    public function getUptimeCheckAdditionalHeadersAttribute($additionalHeaders): array
    {
        return $additionalHeaders
            ? json_decode($additionalHeaders, true)
            : [];
    }

    public function setUptimeCheckAdditionalHeadersAttribute(array $additionalHeaders): void
    {
        $this->attributes['uptime_check_additional_headers'] = json_encode($additionalHeaders);
    }

    public function scopeEnabled($query)
    {
        return $query
            ->where('uptime_check_enabled', true)
            ->orWhere('certificate_check_enabled', true);
    }

    public function getUrlAttribute(): ?Url
    {
        if (! isset($this->attributes['url'])) {
            return null;
        }

        return Url::fromString($this->attributes['url']);
    }

    public function getRawUrlAttribute(): string
    {
        return (string) $this->url;
    }

    public static function booted()
    {
        static::saving(function (self $monitor) {
            if (static::alreadyExists($monitor)) {
                throw CannotSaveMonitor::alreadyExists($monitor);
            }
        });
    }

    public function isHealthy(): bool
    {
        if ($this->uptime_check_enabled && in_array($this->uptime_status, [UptimeStatus::DOWN, UptimeStatus::NOT_YET_CHECKED])) {
            return false;
        }

        if ($this->certificate_check_enabled && $this->certificate_status === CertificateStatus::INVALID) {
            return false;
        }

        return true;
    }

    public function enable(): self
    {
        $this->uptime_check_enabled = true;

        if ($this->url->getScheme() === 'https') {
            $this->certificate_check_enabled = true;
        }

        $this->save();

        return $this;
    }

    public function disable(): self
    {
        $this->uptime_check_enabled = false;
        $this->certificate_check_enabled = false;

        $this->save();

        return $this;
    }

    protected static function alreadyExists(self $monitor): bool
    {
        $query = static::where('url', $monitor->url);

        if ($monitor->exists) {
            $query->where('id', '<>', $monitor->id);
        }

        return (bool) $query->first();
    }
}
