<?php

namespace Modules\Projects\Http\ViewComposers;

use App\Traits\Modules;
use Illuminate\View\View;
use Modules\Projects\Models\Financial;

class ProjectShow
{
    use Modules;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if ($this->moduleIsDisabled('projects') || user()->cannot('read-projects-projects')) {
            return;
        }

        if ($view->getName() == 'components.documents.show.content') {
            $stack = 'children_end';

            $project = $this->getProject($view->offsetGet('document'));
        } else {
            $stack = 'transfer_end';

            $project = $this->getProject($view->offsetGet('transaction'));
        }

        if (! is_null($project)) {
            $view->getFactory()->startPush($stack, view('projects::partials.show-accordion', compact('project')));
        }
    }

    protected function getProject($model)
    {
        $financial = Financial::where('financialable_id', $model->id)
            ->where('financialable_type', get_class($model))
            ->first();

        if (! is_null($financial)) {
            return $financial->project;
        } else {
            return null;
        }
    }
}
