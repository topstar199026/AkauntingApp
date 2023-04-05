<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    <ul class="text-sm space-y-3 my-3">
        @foreach($transactions as $transaction)
            <li class="flex flex-items justify-between">
                <div class="w-1/3">@date($transaction->paid_at)</div>
                <div class="w-1/3">{{ $transaction->category->name }}</div>
                <div class="w-1/3">@money($transaction->amount, $transaction->currency_code, true)</div>
            </li>
        @endforeach
    </ul>
</div>
