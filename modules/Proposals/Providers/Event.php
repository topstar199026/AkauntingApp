<?php

namespace Modules\Proposals\Providers;

use App\Events\Install\UpdateFinished;
use App\Events\Module\Installed;
use App\Events\Menu\AdminCreated;
use App\Events\Menu\PortalCreated;
use Modules\Proposals\Listeners\InstallModule;
use Modules\Proposals\Listeners\AddAdminMenu;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Proposals\Listeners\Update\Version205;
use Modules\Proposals\Listeners\AddPortalMenu;

class Event extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AdminCreated::class => [
            AddAdminMenu::class,
        ],
        PortalCreated::class => [
            AddPortalMenu::class,
        ],
        Installed::class => [
            InstallModule::class,
        ],
        UpdateFinished::class => [
            Version205::class,
        ]
    ];
}
