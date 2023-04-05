<?php

namespace Modules\Projects\Models;

use App\Abstracts\Model;

class ProjectUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_users';

    protected $fillable = ['company_id', 'project_id', 'user_id'];

    public function user()
    {
        return $this->hasOne('App\Models\Auth\User', 'id', 'user_id');
    }
}
