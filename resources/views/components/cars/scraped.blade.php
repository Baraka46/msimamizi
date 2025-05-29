<x-app-layout>
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
       Offenses
    </h2>


    @if(session('success'))
    <div class="mb-4 text-green-600">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="mb-4 text-red-600">{{ $errors->first() }}</div>
@endif

<form  action="{{ route('cars.scrape') }}" class="mb-6">
    @csrf
    <button type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
        🔄 Refresh Data
    </button>
</form>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(!empty($results))
                        <div class="space-y-6">
                       @foreach($results as $plate => $scraped)
                                <div x-data="{ open: false }" class="border rounded-lg shadow-md">
                                    <!-- Plate Number Header -->
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 bg-gray-100 hover:bg-gray-200 font-semibold text-xl">

                                        <span class="text-lg">
                                            {{ strtoupper($plate) }}
                                        </span>


                                        <span class="float-right text-sm text-gray-600">
                                            Offenses: {{ count($scraped['pending_transactions'] ?? []) }}
                                        </span>
                                    </button>

                                    <!-- Records Table (Displayed when clicked) -->
                                    <div x-show="open" x-transition class="p-6 bg-white border-t border-gray-200">
                                          @php
                                            $offenses = $scraped['pending_transactions'] ?? [];
                                        @endphp
                                        @if(count($offenses)>0)
                                            <table class="table-auto w-full border-collapse border border-gray-300 text-md">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="border border-gray-300 p-4">SN</th>
                                                        <th class="border border-gray-300 p-4">Reference</th>
                                                        <th class="border border-gray-300 p-4">Charge</th>

                                                        <th class="border border-gray-300 p-4">Penalty</th>
                                                        <th class="border border-gray-300 p-4">Issued Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
    @foreach($offenses as $i => $record)
        <tr onclick="window.location='{{ route('view.ticket', ['reference' => $record['reference']]) }}'"
            class="cursor-pointer bg-gradient-to-r from-white to-gray-50 hover:from-blue-50 hover:to-blue-100 hover:shadow-lg hover:scale-[1.02] transition-all duration-300 transform hover:-translate-y-1 rounded-lg border-2 border-gray-200 hover:border-blue-300 mb-2">
            <td class="p-4 rounded-l-lg">
                <div class="bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow-md">
                    {{ $i + 1 }}
                </div>
            </td>
            <td class="p-4 font-semibold text-gray-800 bg-gradient-to-r from-transparent to-blue-50">
                {{ $record['reference'] }}
            </td>
            <td class="p-4">
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold text-sm shadow-sm">
                    {{ $record['charge'] }}
                </span>
            </td>
            <td class="p-4">
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold text-sm shadow-sm">
                    {{ $record['penalty'] }}
                </span>
            </td>
            <td class="p-4 rounded-r-lg text-gray-600 font-medium">
                {{ $record['issued_date'] }}
            </td>
        </tr>
    @endforeach
</tbody>
                                            </table>
                                        @else
                                            <p class="text-gray-600">No pending offences found.</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No scraped data available.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
