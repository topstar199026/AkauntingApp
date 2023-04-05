<?php

namespace App\Utilities;

use App\Models\Auth\User;
use App\Models\Common\Company;
use App\Models\Common\Contact;
use App\Models\Document\Document;
use Composer\InstalledVersions;
use Illuminate\Support\Facades\DB;

class Info
{
    public static function all()
    {
        return array_merge(static::versions(), [
            'api_key' => setting('apps.api_key'),
            'ip' => static::ip(),
            'companies' => Company::count(),
            'users' => User::count(),
            'invoices' => Document::invoice()->count(),
            'customers' => Contact::customer()->count(),
            'php_extensions' => static::phpExtensions(),
        ]);
    }

    public static function versions()
    {
        return [
            'akaunting' => version('short'),
            'laravel' => InstalledVersions::getPrettyVersion('laravel/framework'),
            'php' => static::phpVersion(),
            'mysql' => static::mysqlVersion(),
            'guzzle' => InstalledVersions::getPrettyVersion('guzzlehttp/guzzle'),
            'livewire' => InstalledVersions::getPrettyVersion('livewire/livewire'),
            'omnipay' => InstalledVersions::getPrettyVersion('league/omnipay'),
        ];
    }

    public static function phpVersion()
    {
        return phpversion();
    }

    public static function phpExtensions()
    {
        return get_loaded_extensions();
    }

    public static function mysqlVersion()
    {
        static $version;

        if (empty($version) && (config('database.default') === 'mysql')) {
            $version = DB::selectOne('select version() as mversion')->mversion;
        }

        if (isset($version)) {
            return $version;
        }

        return 'N/A';
    }

    public static function ip()
    {
        return request()->header('CF_CONNECTING_IP')
                ? request()->header('CF_CONNECTING_IP')
                : request()->ip();
    }
}
