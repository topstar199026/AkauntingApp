<div class="print-template">
    <div class="row border-bottom-1">
        <div class="col-58">
            <div class="text company" style="margin-top: 1rem;">
                <br>
                <div class="" style="font-size: .525rem; padding: 1.2rem 0;">AT Technologies GmbH • Bergisch Born 127• D-42897 Remscheid</div>
                @if ($hideContactInfo)
                    <strong>{{ trans($textContactInfo) }}</strong><br>
                @endif

                @stack('name_input_start')
                @if (!$hideContactName)
                    <strong>{{ $document->contact_name }}</strong><br>
                @endif
                @stack('name_input_end')
                @stack('address_input_start')
                @if (!$hideContactAddress)
                    <div>
                        @if ($document->contact->atg_name_suffix)
                            <span>{{ $document->contact->atg_name_suffix }}</span><br>
                        @endif

                        {!! nl2br($document->contact_address) !!} <br>

                        @if ($document->contact_zip_code && $document->contact_city)
                            {{ $document->contact_zip_code }}, {{ $document->contact_city }} <br>
                        @endif

                        @if ($document->contact_location != "")
                            @foreach(explode(',', $document->contact_location) as $info)
                                @if ($loop->last)
                                    {{$info}} <br>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endif
                @stack('address_input_end')<br><br><br>

                <!-- deliver to -->

                @if ($textDocumentSubheading)
                    <h5>
                        {{ trans_choice('general.at_subheading', 2) }}
{{--                            {{ $textDocumentSubheading }}--}}

                    </h5>

{{--                    @switch (Route::currentRouteName())--}}
{{--                        @case ('invoices-at-proforma.pdf')--}}
{{--                        <h3 class="text-dark font-bold">{{ trans_choice('general.at_proforma_title', 2) }}</h3>--}}
{{--                        @break--}}
{{--                        @case ('invoices-at-delivery-note.pdf')--}}
{{--                        <h3 class="text-dark font-bold">{{ trans_choice('general.at_deliverynote_title', 2) }}</h3>--}}
{{--                        @if (app()->getLocale() == "de-DE")--}}
{{--                            <p>Sehr geehrte Damen und Herren, </p>--}}
{{--                            <p>entsprechend Ihrem Auftrag liefern wir wie folgt aus:</p> <br>--}}
{{--                        @endif--}}
{{--                        @break--}}
{{--                    --}}
{{--                        @default--}}
{{--                        <div class="text text-dark">--}}
{{--                            @stack('title_input_start')--}}
{{--                            <h3 class="font-bold">--}}
{{--                                {{ $textDocumentTitle }}--}}
{{--                            </h3>--}}
{{--                            @stack('title_input_end')--}}
{{--                        </div>--}}
{{--                        <div class="text company">--}}
{{--                            @stack('notes_input_start')--}}
{{--                            @if ($document->notes)--}}
{{--                                --}}{{--  <strong>{{ trans_choice('general.notes', 2) }}</strong><br><br>  --}}
{{--                                {!! nl2br($document->notes) !!} <br><br>--}}
{{--                            @endif--}}
{{--                            @stack('notes_input_end')--}}
{{--                        </div>--}}
{{--                    @endswitch--}}
                @endif

                {{-- at customer shipping address start --}}
                @stack('ship_address_input_start')
                @if (!$hideContactAddress)
                    @if ($document->type != 'bill')
                        @if (($document->atg_shipping != '') and ($document->atg_shipping != $document->contact_address))
                            {!! nl2br($document->atg_shipping) !!}

                        @else
                            @if ($hideContactInfo)
                                <strong>{{ trans($textContactInfo) }}</strong><br>
                            @endif

                            @stack('name_input_start')
                            @if (!$hideContactName)
                                <strong>{{ $document->contact_name }}</strong><br>
                            @endif
                            @stack('name_input_end')

                            @stack('address_input_start')
                            @if (!$hideContactAddress)
                                <div>
                                    @if ($document->contact->atg_name_suffix)
                                        <span>{{ $document->contact->atg_name_suffix }}</span><br>
                                    @endif

                                    {!! nl2br($document->contact_address) !!} <br>

                                    @if ($document->contact_zip_code && $document->contact_city)
                                        {{ $document->contact_zip_code }}, {{ $document->contact_city }} <br>
                                    @endif

                                    @if ($document->contact_location != "")
                                        @foreach(explode(',', $document->contact_location) as $info)
                                            @if ($loop->last)
                                                {{$info}} <br>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                            @stack('address_input_end')
                        @endif
                    @else
                        {{-- at if bill set company adress--}}
                        @if (($document->atg_shipping != '') and ($document->atg_shipping != $document->contact_address))
                            {!! nl2br($document->atg_shipping) !!}
                        @else
                            @stack('company_details_start')
                            @if (!$hideCompanyDetails)
                                @if (!$hideCompanyName)
                                    <p>{{ setting('company.name') }}</p>
                                @endif

                                @if (!$hideCompanyAddress)
                                    {{--                            {!! nl2br(setting('company.address')) !!}<br>--}}
                                    <span>Bergisch Born 123-127</span><br>
                                    <span>42897 Remscheid, Germany</span><br>
                                @endif

                            @endif
                            @stack('company_details_end')
                        @endif
                        {{-- at if bill set company adress end --}}
                    @endif
                @endif
                @stack('ship_address_input_end')<br><br><br>
                {{-- at customer shipping address start --}}

            </div>
        </div>

        <div class="col-42">
            <div class="text company at-format p-index-right">
                @stack('company_logo_start')
                @if (!$hideCompanyLogo)
                    @if (!empty($document->contact->logo) && !empty($document->contact->logo->id))
                        <img class="d-logo" src="{{ $logo }}" alt="{{ $document->contact_name }}"/>
                    @else
                        <img class="d-logo" src="{{ $logo }}" alt="{{ setting('company.name') }}"/>
                    @endif
                @endif
                @stack('company_logo_end')

                @stack('company_details_start')
                @if (!$hideCompanyDetails)
                    @if (!$hideCompanyName)
                        <h4 classe="font-semibold" style="margin-bottom: .2rem;">{{ setting('company.name') }}</h4>
                    @endif

                    @if (!$hideCompanyAddress)
                        {!! nl2br(setting('company.address')) !!}<br>
                    @endif

                    @if (!$hideCompanyPhone)
                        @if (setting('company.phone'))
                            Tel: {{ setting('company.phone') }} <br>
                            Fax: +49 2191 463 97-99 <br>
                        @endif
                    @endif

                    @if (!$hideCompanyEmail)
                        Email: {{ setting('company.email') }} | www.atg.eu.com <br><br>
                    @endif
                @endif
                @stack('company_details_end')

                @stack('issued_at_input_start')
                @if (!$hideIssuedAt)
                    <p style="line-height: 0.4; ">
                        <strong>
                            {{--                        {{ trans($textIssuedAt) }}:--}}
                            {{ trans_choice('general.at_doc_issued_at', 2) }}
                        </strong>
                        <span class="float-right">@date($document->issued_at)</span>
                    </p>
                @endif
                @stack('issued_at_input_end')
                {{-- atg customer number start --}}
                @stack('document_customer_number_input_start')
                @if ($document->contact->customer_nbr)
                    <p style="line-height: 0.4; ">
                        <strong>
                            {{ trans('invoices.customer_at_number') }}:
                        </strong>
                        <span class="float-right">{{ $document->contact->customer_nbr }}</span>
                    </p>
                @endif
                @stack('document_customer_number_input_start')
                {{-- atg customer number end --}}
                @stack('document_number_input_start')
                @if (!$hideDocumentNumber)
                    <p style="line-height: 0.4; ">
                        <strong>
                            @switch ($document->type)
                                @case ('sales-order')
                                {{ trans_choice('general.at_doc_sale_ord_title', 2) }}:
                                @break

                                @case('invoice' and (Route::currentRouteName() == 'invoices-at-delivery-note.pdf'))
                                {{ trans_choice('general.at_deliverynote_no', 2) }}:
                                @break

                                @case(('debit-note') and (Route::currentRouteName() == 'credit-debit-notes.debit-notes.pdf'))
                                {{ trans_choice('general.at_deliverynote_no', 2) }}:
                                @break

                                @default
                                {{ trans($textDocumentNumber) }}:
                            @endswitch

                        </strong>
                        <span class="float-right">{{ $document->document_number }}</span>
                    </p>
                @endif
                @stack('document_number_input_end')
                @stack('order_number_input_start')
                @if (!$hideOrderNumber)
                    @if ($document->order_number)
                        <p style="line-height: 0.4; ">
                            <strong>
                                {{ trans($textOrderNumber) }}:
                            </strong>
                            <span class="float-right text-right">{{ $document->order_number }}</span>
                        </p>
                    @endif
                @endif
                @stack('order_number_input_end')

                @stack('at_inv_project_nbr_start')
                @if ($document->at_inv_project_nbr)
                    <p style="line-height: 0.4; ">
                        <strong>
                            {{ trans_choice('general.at_inv_project_nbr', 2) }}:
                        </strong>
                        <span class="float-right text-right">{{ $document->at_inv_project_nbr }}</span>
                    </p>
                @endif
                @stack('at_inv_project_nbr_end')
            </div>
        </div>
    </div>

    <div class="row top-spacing">
        <div class="col-100">
            <div class="text p-index-left">
                @switch (Route::currentRouteName())
                    @case ('invoices-at-proforma.pdf')
                    <h3 class="text-dark font-bold">{{ trans_choice('general.at_proforma_title', 2) }}</h3>
                    @break
                    @case ('invoices-at-delivery-note.pdf')
                    <h3 class="text-dark font-bold">{{ trans_choice('general.at_deliverynote_title', 2) }}</h3>
                    @if (app()->getLocale() == "de-DE")
                        <p>Sehr geehrte Damen und Herren, </p>
                        <p>entsprechend Ihrem Auftrag liefern wir wie folgt aus:</p> <br>
                    @endif
                    @break
                    @case ('credit-debit-notes.debit-notes.pdf')
                    <h3 class="text-dark font-bold">{{ trans_choice('general.at_deliverynote_title', 2) }}</h3>
                    @if (app()->getLocale() == "de-DE")
                        @stack('notes_input_start')
                        <div class="text company">
                            @if ($document->notes)
                                {{--  <strong>{{ trans_choice('general.notes', 2) }}</strong><br><br>  --}}
                                {!! nl2br($document->notes) !!} <br><br>
                            @else
                                <p>Sehr geehrte Damen und Herren, </p>
                                <p>entsprechend Ihrem Auftrag liefern wir wie folgt aus:</p> <br>
                            @endif
                        </div>
                        @stack('notes_input_end')

                    @endif
                    @break
                    @case ('credit-debit-notes.debit-notes.show')
                    <h3 class="text-dark font-bold">{{ trans_choice('general.at_deliverynote_title', 2) }}</h3>
                    @stack('notes_input_start')
                    <div class="text company">
                        @if ($document->notes)
                            {{--  <strong>{{ trans_choice('general.notes', 2) }}</strong><br><br>  --}}
                            {!! nl2br($document->notes) !!} <br><br>
                        @else
                            <p>Sehr geehrte Damen und Herren, </p>
                            <p>entsprechend Ihrem Auftrag liefern wir wie folgt aus:</p> <br>
                        @endif
                    </div>
                    @stack('notes_input_end')
                    @break

                    @default
                    <div class="text text-dark">
                        @stack('title_input_start')
                        <h3 class="font-bold">
                            {{ trans_choice('general.at_heading', 2) }}
{{--                            {{ $textDocumentTitle }}--}}
                        </h3>
                        @stack('title_input_end')
                    </div>
                    <div class="text company">
                        @stack('notes_input_start')
                        @if ($document->notes)
                            {{--  <strong>{{ trans_choice('general.notes', 2) }}</strong><br><br>  --}}
                            {!! nl2br($document->notes) !!} <br><br>
                        @endif
                        @stack('notes_input_end')
                    </div>
                @endswitch

            </div>
        </div>
    </div>

    @if (! $hideItems)
        <div class="row">
            <div class="col-100">
                <div class="text extra-spacing">
                    <table class="lines lines-radius-border">
                        <thead style="background-color:{{ $backgroundColor }} !important; -webkit-print-color-adjust: exact;">
                        <tr>
                            @stack('atloop_th_start')
                            <th class="at-item-loop text-left text-white">
                                {{ trans('invoices.article_at_pos') }}
                            </th>
                            @stack('atloop_th_end')


                            @stack('atitem_nbr_th_start')
                            <th class="at-item-nbr text-left text-white">
                                {{ trans('invoices.article_at_number') }}
                            </th>
                            @stack('atitem_nbr_th_end')


                            @stack('name_th_start')
                            @if (!$hideItems || (!$hideName && !$hideDescription))
                                <th class="item text-left text-white">{{ (trans_choice($textItems, 2) != $textItems) ? trans_choice($textItems, 2) : trans($textItems) }}</th>
                            @endif
                            @stack('name_th_end')

                            @stack('quantity_th_start')
                            @if (!$hideQuantity)
                                <th class="quantity text-white">{{ trans($textQuantity) }}</th>
                            @endif
                            @stack('quantity_th_end')

                            @stack('atunit_th_start')
                            <th class="at-item-unit text-left text-white">
                                {{ trans('invoices.article_at_unit') }}
                            </th>
                            @stack('atunit_th_end')
                            {{--                        {{ dd(Route::currentRouteName()) }}--}}
                            @if ((Route::currentRouteName() != 'invoices-at-delivery-note.pdf') AND (Route::currentRouteName() != 'credit-debit-notes.debit-notes.pdf'))
                                @stack('price_th_start')
                                @if (!$hidePrice)
                                    <th class="price text-white">
                                        @if (trans($textPrice) === 'Preis')
                                            <span>Einzelpreis</span>
                                        @else
                                            {{ trans($textPrice) }}
                                        @endif
                                    </th>
                                @endif
                                @stack('price_th_end')

                                @if (!$hideDiscount)
                                    @if (in_array(setting('localisation.discount_location', 'total'), ['item', 'both']))
                                        @stack('discount_td_start')
                                        <th class="discount text-white">
                                            @php
                                                $at_line_discount = 0.0
                                            @endphp
                                            @foreach ($document->totals_sorted as $total)
                                                @if (($total->code === 'item_discount') and ($total->amount != 0.0))
                                                    @php
                                                        $at_line_discount = 'at has discount'
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if ($at_line_discount === 'at has discount')
                                                {{ trans('invoices.discount') }}
                                            @endif
                                        </th>
                                        @stack('discount_td_end')
                                    @endif
                                @endif

                                @stack('total_th_start')
                                @if (!$hideAmount)
                                    <th class="total text-white">
                                        @if (trans($textAmount) === 'Betrag')
                                            <span>Gesamt</span>
                                        @else
                                            {{ trans($textAmount) }}
                                        @endif
                                    </th>
                                @endif
                                @stack('total_th_end')
{{--                            @else--}}
{{--                                @stack('name_th_start')--}}
{{--                                @if (!$hideItems || (!$hideName && !$hideDescription))--}}
{{--                                    <th class="item-credit-note text-left text-white">{{ (trans_choice($textItems, 2) != $textItems) ? trans_choice($textItems, 2) : trans($textItems) }}</th>--}}
{{--                            @endif--}}
                            @stack('name_th_end')
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                                @if ($document->items->count())
                                    @foreach($document->items as $item)
                                        {{-- AT -Item inline  custom start --}}
                                        <x-documents.template.line-item
                                            type="{{ $type }}"
                                            :item="$item"
                                            :document="$document"
                                            hide-items="{{ $hideItems }}"
                                            hide-name="{{ $hideName }}"
                                            hide-description="{{ $hideDescription }}"
                                            hide-quantity="{{ $hideQuantity }}"
                                            hide-price="{{ $hidePrice }}"
                                            hide-discount="{{ $hideDiscount }}"
                                            hide-amount="{{ $hideAmount }}"
                                        />

                                        <tr>
                                            @stack('atloop_th_start')
                                            <td class="at-item-loop"> {{ $loop->iteration}} </td>
                                            @stack('atloop_th_end')

                                            @stack('atitem_nbr_th_start')
                                            @if (!$hideItems || (!$hideName))
                                                <td class="at-item-nbr">
                                                    @if (!$hideName)
                                                        {{ $item->name }}
                                                    @endif
                                                </td>
                                            @endif
                                            @stack('atitem_nbr_th_end')

                                            @stack('name_td_start')
                                            @if (!$hideItems || (!$hideName && !$hideDescription))
                                                <td class="item">
                                                    @if (!$hideDescription)
                                                        @if (!empty($item->description))
                                                            <small>{!! \Illuminate\Support\Str::limit($item->description, 1500) !!}</small>
                                                        @endif
                                                    @endif

                                                </td>
                                            @endif
                                            @stack('name_td_end')

                                            @stack('quantity_td_start')
                                            @if (!$hideQuantity)
                                                <td class="quantity">{{ $item->quantity }}</td>
                                            @endif
                                            @stack('quantity_td_end')

                                            @stack('atunit_td_start')
                                            <td class="at-item-unit">
                                                @stack('item_custom_fields')
                                                @stack('item_custom_fields_' . $item->id)
                                            </td>
                                            @stack('atunit_td_end')

                                            @if ((Route::currentRouteName() != 'invoices-at-delivery-note.pdf') AND (Route::currentRouteName() != 'credit-debit-notes.debit-notes.pdf'))
                                                @stack('price_td_start')
                                                @if (!$hidePrice)
                                                    <td class="price">@money($item->price, $document->currency_code, true)</td>
                                                @endif
                                                @stack('price_td_end')

                                                @if (!$hideDiscount)
                                                    @if (in_array(setting('localisation.discount_location', 'total'), ['item', 'both']))
                                                        @stack('discount_td_start')
                                                        @if ($item->discount_type === 'percentage')
                                                            <td class="discount">
                                                                @if ($item->discount_rate != 0.0)
                                                                    {{ $item->discount }}
                                                                @endif
                                                            </td>
                                                        @else
                                                            <td class="discount">@money($item->discount, $document->currency_code, true)</td>
                                                        @endif
                                                        @stack('discount_td_end')
                                                    @endif
                                                @endif

                                                @stack('total_td_start')
                                                @if (!$hideAmount)
                                                    <td class="total">@money($item->total, $document->currency_code, true)</td>
                                                @endif
                                                @stack('total_td_end')
                                            @endif
                                        </tr>
                                    @endforeach
                                    {{-- AT -Item inline  custom end --}}
                            @else
                                <tr>
                                    <td colspan="5" class="text text-center empty-items">
                                        {{ trans('documents.empty_items') }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    @if ((Route::currentRouteName() != 'invoices-at-delivery-note.pdf') AND (Route::currentRouteName() != 'credit-debit-notes.debit-notes.pdf'))
        <div class="row mt-5 clearfix">
            <div class="col-60">
                <div class="text p-index-left">
{{--                    @stack('notes_input_start')--}}
{{--                        @if ($document->notes)--}}
{{--                            <p class="font-semibold">--}}
{{--                                {{ trans_choice('general.notes', 2) }}--}}
{{--                            </p>--}}

{{--                            {!! nl2br($document->notes) !!}--}}
{{--                        @endif--}}
{{--                    @stack('notes_input_end')--}}
                </div>
            </div>

            <div class="col-40 float-right text-right">
                @foreach ($document->totals_sorted as $total)
                    @if ($total->code != 'total')
                        @stack($total->code . '_total_tr_start')
                        <div class="text border-top-1 py-1">
                            <span class="float-left font-semibold">
                                {{ trans($total->title) }}:
                            </span>

                            <span>
                                <x-money :amount="$total->amount" :currency="$document->currency_code" convert />
                            </span>
                        </div>
                        @stack($total->code . '_total_tr_end')
                    @else
                        @if ($document->paid)
                            @stack('paid_total_tr_start')
                            <div class="text border-top-1 py-1">
                                <span class="float-left font-semibold">
                                    {{ trans('invoices.paid') }}:
                                </span>

                                <span>
                                    - <x-money :amount="$document->paid" :currency="$document->currency_code" convert />
                                </span>
                            </div>
                            @stack('paid_total_tr_end')
                        @endif

                        @stack('grand_total_tr_start')
                        <div class="text border-top-1 py-1">
                            <span class="float-left font-semibold">
                                {{ trans($total->name) }}:
                            </span>

                            <span>
                                <x-money :amount="$document->amount_due" :currency="$document->currency_code" convert />
                            </span>
                        </div>
                        @stack('grand_total_tr_end')
                    @endif
                @endforeach
            </div>
        </div>

        @if (! $hideFooter)
            @if ($document->footer)
            @stack('footer_input_start')
                <div class="row mt-4">
                    <div class="col-100 text-left">
                        <div class="text">
                            <span class="font-bold">
                                {!! nl2br($document->footer) !!}
                            </span>
                        </div>
                    </div>
                </div>
            @stack('footer_input_end')
            @endif
        @endif
    @endif

    {{-- AT - custom footer --}}
    <div class="row mt-2 text-at-footer-print col-100">
        <div class="col-at-23 pr-1">
            <p><b>AT Technologies GmbH</b>
                <br>Dabringhauser Str. 6a 42929<br>Wermelskrichen<br>Germany</p>
        </div>

        <div class="col-at-23">
            <p><b>Geschäftsführer:</b><br>Tolga Halici<br>Asim Acar
                <br>HRB 54529 AG Köln</p>
        </div>

        <div class="col-at-23">
            <p><b>Ncage:</b> DN821<br><b>St-Nr:</b> 230 / 5700/ 1693<br><b>Ust-Id:</b> DE2382 71 003</p>
        </div>

        <div class="col-at-25 ">
            @switch($document->atg_footer_account)
                @case(2)
                <p><b>Bankverbindungen</b><br><span>NATIONAL-BANK</span><br>
                    <b>IBAN:</b><span> DE02 3602 0030 0007 0683 95</span> <br><b>BIC/Swift:</b> NBAGDE3E </p>
                @break

                @case(3)
                <p><b>Bankverbindungen</b><br><span>Volksbank Remscheid Solingen</span><br>
                    <b>IBAN:</b><span> DE66 3406 0094 0107 1185 40</span> <br><b>BIC/Swift:</b> VBRSDE33XXX </p>
                @break

                @case(4)
                <p><b>Bankverbindungen</b><br><span>Sparkasse Remscheid</span><br>
                    <b>IBAN:</b><span> DE43 3405 0000 0000 1314 58</span> <br><b>BIC/Swift:</b> WELADEDRXXX </p>
                @break

                @case(5)
                <p><b>Bankverbindungen</b><br><span>Sparkasse Remscheid</span><br>
                    <b>IBAN:</b><span> DE95 3405 0000 0000 1323 65</span> <br><b>BIC/Swift:</b> WELADEDRXXX </p>
                @break

                @case(6)
                <p><b>Bankverbindungen</b><br><span>Deutsche Bank</span><br>
                    <b>IBAN:</b><span> DE50 3507 0024 0555 9299 00</span> <br><b>BIC/Swift:</b> DEUTDEDB350 </p>
                @break

                @default
                <p><b>Bankverbindungen</b><br><span>Volksbank Remscheid Solingen</span><br>
                    <b>IBAN:</b><span> DE66 3406 0094 0107 1185 49</span> <br><b>BIC/Swift:</b> VBRSDE33XXX </p>
            @endswitch

        </div>
    </div>
</div>
