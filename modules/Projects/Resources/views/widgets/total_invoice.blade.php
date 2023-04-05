<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} text-center">
    <a class="group">
        <div class="relative text-xl sm:text-6xl text-purple group-hover:text-purple-700 mb-2">
            {{ $invoiceTotalAmount }}
            <span class="w-8 absolute left-0 right-0 m-auto -bottom-1 bg-gray-200 transition-all group-hover:bg-gray-900" style="height: 1px;"></span>
        </div>

        <span class="font-light mt-3">
            {{ trans_choice('general.invoices', 2) }}
        </span>
    </a>
</div>
