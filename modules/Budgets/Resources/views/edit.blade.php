<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.edit', ['type' => trans_choice('budgets::general.budget',1)]) }}
    </x-slot>


    <x-slot name="buttons">
        <x-link href="{{ route('budgets.show', $budget) }}" kind="primary">
            {{ trans('budgets::general.budget_vs_actual') }}
        </x-link>
    </x-slot>

    <x-slot name="content">
        <div id="budgets-module">
            <edit-budget inline-template>
                <x-form.container class="relative lg:w-full z-10" override="class">
                    <x-form id="edit-budget" method="PATCH" :route="['budgets.update', $budget->id]" :model="$budget">
                        <x-form.section class="w-8/12 mb-14" override="class">
                            <x-slot name="body">
                                <x-form.group.text name="name" label="{{ trans('general.name') }}"  />

                                <x-form.group.select
                                    name="period"
                                    :label="trans_choice('budgets::general.period', 1)"
                                    :options="$periods"
                                />

                                <x-form.group.select
                                    name="financial_year"
                                    :label="trans('budgets::general.financial_year')"
                                    :options="$financial_years"
                                />
                            </x-slot>
                        </x-form.section>

                        <x-form.section>
                            <x-slot name="body">
                                <account-budget-fields
                                    path="{{ route('budgets.accounts.index') }}"
                                    :form="form"
                                    budgets_period_path="{{ route('budgets.period') }}"
                                    v-model="form.budgeted_amounts"
                                    :budgeted_amounts='@json($budget->budgetedAmounts)'
                                    class="sm:col-span-6"
                                >
                                    <template #accounts-text>
                                        {{ trans_choice('general.accounts', 2) }}
                                    </template>
                                    <template #total-text>
                                        {{ trans_choice('general.totals', 1) }}
                                    </template>
                                    <template #total-account-type-text="{type}">
                                        {{ trans_choice('general.totals', 1) }}
                                        <span v-text="type"></span>
                                    </template>
                                    <template #profit-loss-text>
                                        {{ trans_choice('general.totals', 1) }}
                                        {{ trans('budgets::general.profit_loss') }}
                                    </template>
                                </account-budget-fields>
                            </x-slot>
                        </x-form.section>

                        <x-form.section>
                            <x-slot name="foot">
                                <x-form.buttons :cancel="url()->previous()" />
                            </x-slot>
                        </x-form.section>
                    </x-form>
                </x-form.container>
            </edit-budget>
        </div>
    </x-slot>

    <x-script alias="budgets" file="budgets" />
</x-layouts.admin>
