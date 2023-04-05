<?php

namespace Modules\CreditDebitNotes\Models;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\CreditDebitNotes\Database\Factories\DebitNote as DebitNoteFactory;
use Modules\CreditDebitNotes\Traits\Actions;

class DebitNote extends Document
{
    use Actions;

    public const TYPE = 'debit-note';

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
        return $this->hasOne(DebitNoteDetails::class, 'document_id');
    }

    public function bill(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'bill_id')
            ->bill();
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Banking\Transaction', 'document_id')->where('type', 'debit_note_refund');
    }

    public function getTemplatePathAttribute($value = null)
    {
        return $value ?: 'credit-debit-notes::debit_notes.print';
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

    public function getBillIdAttribute(): ?int
    {
        return optional($this->details)->bill_id;
    }

    public function getBillNumberAttribute(): string
    {
        return optional($this->bill)->document_number ?? '';
    }

    protected static function newFactory(): Factory
    {
        return DebitNoteFactory::new();
    }
}
