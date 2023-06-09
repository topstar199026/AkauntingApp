<?php

namespace Modules\CreditDebitNotes\Models;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\CreditDebitNotes\Database\Factories\CreditNote as CreditNoteFactory;
use Modules\CreditDebitNotes\Traits\Actions;

class CreditNote extends Document
{
    use Actions;

    public const TYPE = 'credit-note';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->addCloneableRelation('details');
    }

    protected static function booted()
    {
        static::addGlobalScope(self::TYPE, function (Builder $builder) {
            $builder->where('type', self::TYPE);
        });
    }

    public function details(): HasOne
    {
        return $this->hasOne(CreditNoteDetails::class, 'document_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'invoice_id')
            ->invoice();
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Banking\Transaction', 'document_id')
            ->where('type', 'credit_note_refund');
    }

    public function credits_transactions()
    {
        return $this->hasMany('Modules\CreditDebitNotes\Models\CreditsTransaction', 'document_id')
            ->where('type', 'income');
    }

    public function getTemplatePathAttribute($value = null)
    {
        return $value ?: 'credit-debit-notes::credit_notes.print_' . setting('credit-debit-notes.credit_note.template', 'default');
    }

    public function getPaidAttribute()
    {
        return 0;
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->status == 'sent') {
            return 'status-success';
        }

        return parent::getStatusLabelAttribute();
    }

    public function getInvoiceIdAttribute(): ?int
    {
        return optional($this->details)->invoice_id;
    }

    public function getCreditCustomerAccountAttribute(): bool
    {
        return optional($this->details)->credit_customer_account ?? false;
    }

    public function getInvoiceNumberAttribute(): string
    {
        return optional($this->invoice)->document_number ?? '';
    }

    protected static function newFactory(): Factory
    {
        return CreditNoteFactory::new();
    }
}
