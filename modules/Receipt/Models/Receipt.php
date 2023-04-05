<?php

namespace Modules\Receipt\Models;

use App\Abstracts\Model;
use App\Traits\Media;
use App\Traits\Transactions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, Media, SoftDeletes, Transactions;

    protected $table = 'receipts';

    protected $fillable = [
        'company_id',
        'date',
        'create_date',
        'merchant',
        'total_amount',
        'tax_amount',
        'category_id',
        'payment_id',
        'payment_method',
        'statuses',
        'image',
        'currency_code',
        'contact_id'
    ];

    public $sortable = ['merchant', 'date', 'create_date', 'category_id', 'total_amount', 'statuses', 'contact_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\Models\Common\Contact')->withDefault(['name' => trans('general.na')]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Setting\Category')->withDefault(['name' => trans('general.na')]);
    }

    /**
     * Get the current balance.
     *
     * @return string
     */
    public function getAttachmentAttribute($value = null)
    {
        if (!empty($value) && !$this->hasMedia('receipts')) {
            return $value;
        } elseif (!$this->hasMedia('receipts')) {
            return false;
        }

        return $this->getMedia('receipts')->all();
    }

    /**
     * Get the line actions.
     *
     * @return array
     */
    public function getLineActionsAttribute()
    {
        $actions = [];

        $actions[] = [
            'title' => trans('general.edit'),
            'icon' => 'edit',
            'url' => route('receipt.edit', $this->id),
            'permission' => 'update-receipt-receipts',

        ];

        $actions[] = [
            'title' => trans('receipt::general.title'),
            'type' => 'delete',
            'icon' => 'delete',
            'route' => 'receipt.destroy',
            'permission' => 'delete-receipt-receipts',
            'model' => $this,
        ];

        return $actions;
    }
}
