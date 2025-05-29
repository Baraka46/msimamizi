<x-app-layout>
    <h2 class="font-bold text-3xl text-gray-900 leading-tight mb-6">
        Ticket Details – Ref: {{ $ticket['reference'] }}
    </h2>
    
    <div class="py-4">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
            <table class="w-full text-sm divide-y divide-gray-100">
                @php $isEven = false; @endphp
                @foreach([
                    'reference' => 'Reference',
                    'issued_date' => 'Issued Date',
                    'operator' => 'Operator',
                    'vehicle' => 'Vehicle Plate',
                    'licence' => 'Licence',
                    'location' => 'Location',
                    'offence' => 'Offence',
                    'charge' => 'Charge',
                    'penalty' => 'Penalty',
                    'status' => 'Status',
                    'receipt' => 'Receipt',
                    'paydate' => 'Pay Date',
                    'pendate' => 'Penalty Deadline',
                ] as $field => $label)
                    @php $isEven = !$isEven; @endphp
                    <tr class="{{ $isEven ? 'bg-gray-100' : 'bg-white' }} hover:bg-blue-50 transition-colors duration-200">
                        <th class="text-left px-6 py-4 font-semibold text-gray-700 w-2/5 border-r border-gray-100">
                            {{ $label }}
                        </th>
                        <td class="px-6 py-4 text-gray-900 font-medium">
                            {{ $ticket[$field] ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>
