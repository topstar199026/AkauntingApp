<?php

namespace Modules\Leaves\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Employees\Models\Employee;

class Allowance extends Model
{
    use HasFactory;

    public const TYPE_ALLOWED = 'allowed';
    public const TYPE_USED = 'used';

    protected $table = 'leaves_allowances';

    protected $fillable = [
        'company_id',
        'entitlement_id',
        'employee_id',
        'start_date',
        'end_date',
        'type',
        'days',
    ];

    public function entitlement(): BelongsTo
    {
        return $this->belongsTo(Entitlement::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeUsed($query)
    {
        return $query->where('type', self::TYPE_USED);
    }

    protected static function newFactory(): Factory
    {
        return \Modules\Leaves\Database\Factories\Allowance::new();
    }
}
