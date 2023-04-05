@if($users->isNotEmpty())
    <x-table>
        <x-table.thead>
            <x-table.tr>
                <x-table.th class="w-4/12 sm:w-4/12">
                    Name
                </x-table.th>

                <x-table.th class="w-8/12 sm:w-8/12">
                    Email
                </x-table.th>
            </x-table.tr>
        </x-table.thead>

        <x-table.tbody>
            @foreach($users as $user)
                <x-table.tr>
                    <x-table.td class="w-4/12 sm:w-4/12">
                        <x-link href="{{ route('users.edit', $user->user_id) }}" override="class" target="_blank">
                            {{ $user->user->name }}
                        </x-link>
                    </x-table.td>

                    <x-table.td class="w-8/12 sm:w-8/12">
                        {{ $user->user->email }}
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table>
@endif
