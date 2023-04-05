<?php

namespace Modules\SalesPurchaseOrders\Listeners\Update\V20;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished as Event;
use App\Traits\Jobs;
use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class Version200 extends Listener
{
    use Permissions;
    use Jobs;

    public const ALIAS = 'sales-purchase-orders';

    public const VERSION = '2.0.0';

    /**
     * Handle the event.
     *
     * @param  $event
     *
     * @return void
     */
    public function handle(Event $event): void
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        Log::channel('stderr')->info('Starting the Estimates 3.0 update...');

        $this->updateDatabase();
        $this->updatePermissions();
        $this->deleteOldFiles();

        Log::channel('stderr')->info('Estimates 3.0 update finished.');
    }

    protected function updateDatabase()
    {
        Log::channel('stderr')->info('Updating database...');

        Artisan::call('module:migrate', ['alias' => self::ALIAS, '--force' => true]);

        Log::channel('stderr')->info('Database updated.');
    }

    public function updatePermissions()
    {
        Log::channel('stderr')->info('Updating permissions...');

        $rows = [
            'accountant' => [
                'sales-purchase-orders-sales-orders'    => 'r',
                'sales-purchase-orders-purchase-orders' => 'r',
            ],
        ];

        Log::channel('stderr')->info('Attaching new permissions...');

        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsByRoleNames($rows);

        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            'sales-purchase-orders-settings-sales-order'    => 'r,u',
            'sales-purchase-orders-settings-purchase-order' => 'r,u',
        ]);

        Log::channel('stderr')->info('Permissions updated.');
    }

    protected function deleteOldFiles()
    {
        $files = [
            'Http/Controllers/Modals/PurchaseOrderTemplate.php',
            'Http/Controllers/Modals/SalesOrderTemplate.php',
            'Http/ViewComposers/ShowDeliveryDateFieldHeader.php',
            'Http/ViewComposers/ShowSalesPurchaseOrdersButtons.php',
            'Http/ViewComposers/ShowShipmentDateFieldHeader.php',
            'Resources/views/fields/show_expected_delivery_date_header.blade.php',
            'Resources/views/fields/show_expected_shipment_date_header.blade.php',
        ];

        $directories = [
            'Resources/views/modals/settings',
            'Resources/views/modals/partials',
        ];

        foreach ($files as $file) {
            File::delete(base_path('modules/Estimates/'.$file));
        }

        foreach ($directories as $directory) {
            File::deleteDirectory(base_path('modules/Estimates/'.$directory));
        }
    }
}
