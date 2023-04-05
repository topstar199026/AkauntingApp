<?php

namespace Modules\SalesPurchaseOrders\Models\PurchaseOrder;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\SalesPurchaseOrders\Database\Factories\PurchaseOrder as PurchaseOrderFactory;
use Modules\SalesPurchaseOrders\Models\SalesPurchaseOrderDocument;

class Model extends Document
{
    public const TYPE = 'purchase-order';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->addCloneableRelation('extra_param');
    }

    public function bills(): BelongsToMany
    {
        return $this->belongsToMany(Bill::class);
    }

    public function converted_bills()
    {
        return $this->morphMany(SalesPurchaseOrderDocument::class, 'item');
    }

    public function extra_param(): HasOne
    {
        return $this->hasOne(ExtraParameter::class, 'document_id')
                    ->withDefault(['expected_delivery_date' => null]);
    }

    public function scopePurchase(Builder $query): Builder
    {
        return $query->where($this->table . '.type', '=', self::TYPE);
    }

    public function scopeDelivery($query, $date)
    {
        return $query->join('sales_purchase_orders_purchase_extra_parameters', 'document_id', '=', "{$this->table}.id")->whereDate('expected_delivery_date', '=', $date);
    }

    public function scopeBilled($query)
    {
        return $query->where('status', 'billed');
    }

    public function scopeNotBilled($query)
    {
        return $query->where('status', '<>', 'billed');
    }

    public function getBilledAtAttribute($value): string
    {
        return $this->bills()->orderBy('created_at', 'desc')->first();
    }

    public function getStatusLabelAttribute(): string
    {
        $label = parent::getStatusLabelAttribute();

        return match ($this->status) {
            'issued' => 'status-success',
            'invoiced' => 'status-info',
            default => $label,
        };
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        try {
            $actions[] = [
                'title' => trans('general.show'),
                'icon' => 'visibility',
                'url' => route('sales-purchase-orders.purchase-orders.show', $this->id),
                'permission' => 'read-sales-purchase-orders-purchase-orders',
                'attributes' => [
                    'id' => 'index-more-actions-show-' . $this->id,
                ],
            ];
        } catch (\Exception $e) {}

        try {
            if (! $this->reconciled) {
                $actions[] = [
                    'title' => trans('general.edit'),
                    'icon' => 'edit',
                    'url' => route('sales-purchase-orders.purchase-orders.edit', $this->id),
                    'permission' => 'update-sales-purchase-orders-purchase-orders',
                    'attributes' => [
                        'id' => 'index-more-actions-edit-' . $this->id,
                    ],
                ];
            }
        } catch (\Exception $e) {}

        try {
            $actions[] = [
                'title' => trans('general.duplicate'),
                'icon' => 'file_copy',
                'url' => route('sales-purchase-orders.purchase-orders.duplicate', $this->id),
                'permission' => 'create-sales-purchase-orders-purchase-orders',
                'attributes' => [
                    'id' => 'index-more-actions-duplicate-' . $this->id,
                ],
            ];
        } catch (\Exception $e) {}

        try {
            $actions[] = [
                'title' => trans('general.print'),
                'icon' => 'print',
                'url' => route('sales-purchase-orders.purchase-orders.print', $this->id),
                'permission' => 'read-sales-purchase-orders-purchase-orders',
                'attributes' => [
                    'id' => 'index-more-actions-print-' . $this->id,
                    'target' => '_blank',
                ],
            ];
        } catch (\Exception $e) {}

        try {
            $actions[] = [
                'title' => trans('general.download_pdf'),
                'icon' => 'pdf',
                'url' => route('sales-purchase-orders.purchase-orders.pdf', $this->id),
                'permission' => 'read-sales-purchase-orders-purchase-orders',
                'attributes' => [
                    'id' => 'index-more-actions-pdf-' . $this->id,
                    'target' => '_blank',
                ],
            ];
        } catch (\Exception $e) {}

        $actions[] = [
            'type' => 'divider',
        ];

        try {
            $actions[] = [
                'type' => 'button',
                'title' => trans('invoices.send_mail'),
                'icon' => 'email',
                'url' => route('sales-purchase-orders.modals.purchase-orders.emails.create', $this->id),
                'permission' => 'read-sales-purchase-orders-purchase-orders',
                'attributes' => [
                    'id'        => 'index-more-actions-send-email-' . $this->id,
                    '@click'    => 'onEmail("' . route('sales-purchase-orders.modals.purchase-orders.emails.create', $this->id) . '")',
                ],
            ];
        } catch (\Exception $e) {}

        $actions[] = [
            'type' => 'divider',
        ];

        try {
            $actions[] = [
                'type' => 'delete',
                'icon' => 'delete',
                'title' => trans('general.delete'),
                'route' => 'sales-purchase-orders.purchase-orders.destroy',
                'permission' => 'delete-sales-purchase-orders-purchase-orders',
                'model' => $this,
            ];
        } catch (\Exception $e) {}


        return $actions;
    }

    protected static function newFactory(): Factory
    {
        return PurchaseOrderFactory::new();
    }
}
