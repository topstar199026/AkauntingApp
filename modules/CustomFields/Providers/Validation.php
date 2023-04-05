<?php

namespace Modules\CustomFields\Providers;

use App\Traits\Modules;
use Illuminate\Support\ServiceProvider;
use Modules\CustomFields\Services\Validation as ServicesValidation;
use Modules\CustomFields\Traits\CustomFields;

class Validation extends ServiceProvider
{
    use CustomFields, Modules;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages, $attributes) {
            if (empty($code = $this->getCodeInRequest($this->app['request'])) || $this->moduleIsDisabled('custom-fields')) {
                return new ServicesValidation($translator, $data, $rules, $messages, $attributes);
            }

            $custom_fields = $this->getFieldsByLocation($code);

            if ($custom_fields->isEmpty()) {
                return new ServicesValidation($translator, $data, $rules, $messages, $attributes);
            }

            foreach ($custom_fields as $custom_field) {
                $rule = ! empty($custom_field->rule) ? $custom_field->rule : '';

                if (! request()->has('items') && $custom_field->sort === 'item_custom_fields') {
                    $rules['items.*.' . $custom_field->code] = $rule;
                }

                $rules[$custom_field->code] = $rule;
                $attributes[$custom_field->code] = $custom_field->name;
            }

            return new ServicesValidation($translator, $data, $rules, $messages, $attributes);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
