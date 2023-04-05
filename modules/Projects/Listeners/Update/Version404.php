<?php

namespace Modules\Projects\Listeners\Update;

use App\Abstracts\Listeners\Update as Listener;
use App\Events\Install\UpdateFinished;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Version404 extends Listener
{
    const ALIAS = 'projects';

    const VERSION = '4.0.4';

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle(UpdateFinished $event)
    {
        if ($this->skipThisUpdate($event)) {
            return;
        }

        $this->updateActivities();

        File::delete(base_path('modules/Projects/Traits/Activities.php'));
    }

    protected function updateActivities()
    {
        DB::transaction(function () {
            DB::table('projects')
                ->whereIn('description', ['projects::activities.created.revenue', 'projects::activities.created.payment'])
                ->delete();
        });
    }
}
