<?php

namespace Modules\Projects\View\Components;

use Modules\Projects\Abstracts\View\ProjectsComponent;

class Attachments extends ProjectsComponent
{
    const RELATION = 'attachments';

    public array $attachments = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(mixed $project = null) {
        // Project attachments
        $this->addAttachmentsFromModel($project);

        // Project tasks attachments
        $this->addAttachmentsFromModels($project->tasks);

        // Project document attachments
        $this->addAttachmentsFromModels($project->documents);

        // Project tranasction attachments
        $this->addAttachmentsFromModels($project->transactions);

        arsort($this->attachments);

        $this->project = $project;
    }

    protected function addAttachmentsFromModels($models): void
    {
        foreach ($models ?? [] as $model) {
            $this->addAttachmentsFromModel($model);
        }
    }

    protected function addAttachmentsFromModel($model): void
    {
        if (empty($model) || empty($model->attachment)) {
            return;
        }

        foreach ($model->attachment as $attachment) {
            $this->attachments[$attachment->id] = $attachment;
        }
    }
}
