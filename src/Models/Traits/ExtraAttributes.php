<?php
namespace Spatie\UptimeMonitor\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

trait ExtraAttributes
{
    use SoftDeletes;
    /**
     *
     * @return string
     */
    public function getSchemeAttribute() : string
    {
        return parse_url($this->url, PHP_URL_SCHEME);
    }
    /**
     * 主机
     *
     * @return string
     */
    public function getHostAttribute() : string
    {
        return parse_url($this->url, PHP_URL_HOST);
    }

    /**
     * 是否有SSL加密
     *
     * @return bool
     */
    public function getIsSslAttribute() : bool
    {
        return Str::startsWith($this->url, ['https', 'ssl']);
    }

    /**
     * 端口号，默认值为 443
     *
     * @return int|null
     */
    public function getPortAttribute() : ?int
    {
        return parse_url($this->url, PHP_URL_PORT) ?? 443;
    }

    /**
     * 生成非数字开头的八位数字符串
     *
     * @return string
     */
    public function generateRandomString() : string
    {
        $firstChar = substr(str_shuffle(implode('', array_merge(range('a', 'z'), range('A', 'Z')))), 0, 1);

        return $firstChar.Str::random(7);
    }
}
