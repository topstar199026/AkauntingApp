<?php

namespace Modules\CreditDebitNotes\Traits;

trait Actions
{
    public function getLineActionsAttribute(): array
    {
        $actions = [];

        $alias = config('type.document.' . $this->type . '.alias');
        $group = config('type.document.' . $this->type . '.group');
        $prefix = config('type.document.' . $this->type . '.route.prefix');
        $permission_prefix = config('type.document.' . $this->type . '.permission.prefix');
        $translation_prefix = config('type.document.' . $this->type . '.translation.prefix');

        try {
            $actions[] = [
                'title'      => trans('general.show'),
                'icon'       => 'visibility',
                'url'        => route($alias . '.' . $prefix . '.show', $this->id),
                'permission' => 'read-' . $group . '-' . $permission_prefix,
            ];
        } catch (\Exception $e) {
        }

        try {
            if (!$this->reconciled) {
                $actions[] = [
                    'title'      => trans('general.edit'),
                    'icon'       => 'edit',
                    'url'        => route($alias . '.' . $prefix . '.edit', $this->id),
                    'permission' => 'update-' . $group . '-' . $permission_prefix,
                ];
            }
        } catch (\Exception $e) {
        }

        try {
            $actions[] = [
                'title'      => trans('general.duplicate'),
                'icon'       => 'file_copy',
                'url'        => route($alias . '.' . $prefix . '.duplicate', $this->id),
                'permission' => 'create-' . $group . '-' . $permission_prefix,
            ];
        } catch (\Exception $e) {
        }

        try {
            $actions[] = [
                'title'      => trans('general.print'),
                'icon'       => 'print',
                'url'        => route($alias . '.' . $prefix . '.print', $this->id),
                'permission' => 'read-' . $group . '-' . $permission_prefix,
                'attributes' => [
                    'target' => '_blank',
                ],
            ];
        } catch (\Exception $e) {
        }

        try {
            $actions[] = [
                'title'      => trans('general.download_pdf'),
                'icon'       => 'pdf',
                'url'        => route($alias . '.' . $prefix . '.pdf', $this->id),
                'permission' => 'read-' . $group . '-' . $permission_prefix,
                'attributes' => [
                    'target' => '_blank',
                ],
            ];
        } catch (\Exception $e) {
        }

        $actions[] = [
            'type' => 'divider',
        ];

        try {
            $actions[] = [
                'type'       => 'button',
                'title'      => trans('general.share_link'),
                'icon'       => 'share',
                'url'        => route($alias . '.' . 'modals.' . $prefix . '.share.create', $this->id),
                'permission' => 'read-' . $group . '-' . $permission_prefix,
                'attributes' => [
                    '@click' => 'onShareLink("' . route($alias . '.' . 'modals.' . $prefix . '.share.create', $this->id) . '")',
                ],
            ];
        } catch (\Exception $e) {
        }

        $actions[] = [
            'type' => 'divider',
        ];

        try {
            $actions[] = [
                'title'      => trans('general.cancel'),
                'icon'       => 'cancel',
                'url'        => route($alias . '.' . $prefix . '.cancelled', $this->id),
                'permission' => 'update-' . $group . '-' . $permission_prefix,
            ];
        } catch (\Exception $e) {
        }

        $actions[] = [
            'type' => 'divider',
        ];

        try {
            $actions[] = [
                'type'       => 'delete',
                'icon'       => 'delete',
                'title'      => $translation_prefix,
                'route'      => $alias . '.' . $prefix . '.destroy',
                'permission' => 'delete-' . $group . '-' . $permission_prefix,
                'model'      => $this,
            ];
        } catch (\Exception $e) {
        }

        return $actions;
    }
}
