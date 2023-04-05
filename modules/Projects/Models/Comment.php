<?php

namespace Modules\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_comments';
    
    protected $fillable = ['company_id', 'project_id', 'discussion_id', 'comment', 'created_by'];

    public function discussion()
    {
        return $this->belongsTo('Modules\Projects\Models\Discussion');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Auth\User', 'created_by');
    }
}
