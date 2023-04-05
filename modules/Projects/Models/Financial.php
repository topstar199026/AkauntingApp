<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Builder;

class Financial extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_financials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['company_id', 'project_id', 'financialable_id', 'financialable_type'];

    public function financialable()
    {
        return $this->morphTo();
    }

    public function project()
    {
        return $this->belongsTo('Modules\Projects\Models\Project');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Banking\Transaction', 'financialable_id');
    }

    public function scopeType(Builder $query, string $class): Builder
    {
        return $query->where('financialable_type', $class);
    }
}
