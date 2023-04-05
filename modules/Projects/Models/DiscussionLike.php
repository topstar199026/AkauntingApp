<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;

class DiscussionLike extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_discussion_likes';
    
    protected $fillable = ['company_id', 'project_id', 'discussion_id', 'created_by'];
}
