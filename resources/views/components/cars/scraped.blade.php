<x-app-layout>
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        Scraped Vehicle Data
    </h2>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(isset($results['results']) && count($results['results']) > 0)
                        <div class="space-y-6">
                            @foreach($results['results'] as $index => $scraped)
                                <div x-data="{ open: false }" class="border rounded-lg shadow-md">
                                    <!-- Plate Number Header -->
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 bg-gray-100 hover:bg-gray-200 font-semibold text-xl">
                                        <!-- Vehicle Number (Display as numbered) -->
                                        <span class="text-lg">{{ $index + 1 }} - Plate: 
                                            {{ strtoupper(substr($scraped['plate_number'], 0, 1)) }}
                                            {{ strtoupper(substr($scraped['plate_number'], 1, 3)) }}
                                            {{ strtoupper(substr($scraped['plate_number'], 4)) }}
                                        </span>

                                        <!-- Number of Offenses displayed on the far right -->
                                        <span class="float-right text-sm text-gray-600">
                                            Offenses: 
                                            @php
                                                $offenseCount = isset($scraped['records']) ? count($scraped['records']) : 0;
                                            @endphp
                                            {{ $offenseCount }}
                                        </span>
                                    </button>

                                    <!-- Records Table (Displayed when clicked) -->
                                    <div x-show="open" x-transition class="p-6 bg-white border-t border-gray-200">
                                        @if(isset($scraped['records']) && count($scraped['records']) > 0)
                                            <table class="table-auto w-full border-collapse border border-gray-300 text-md">
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th class="border border-gray-300 p-4">SN</th>
                                                        <th class="border border-gray-300 p-4">Reference</th>
                                                        <th class="border border-gray-300 p-4">License</th>
                                                        <th class="border border-gray-300 p-4">Location</th>
                                                        <th class="border border-gray-300 p-4">Offence</th>
                                                        <th class="border border-gray-300 p-4">Charge</th>
                                                        <th class="border border-gray-300 p-4">Penalty</th>
                                                        <th class="border border-gray-300 p-4">Status</th>
                                                        <th class="border border-gray-300 p-4">Issued Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($scraped['records'] as $record)
                                                        <tr>
                                                            <td class="border border-gray-300 p-4">{{ $record['SN'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['Reference'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['License'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['Location'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['Offence'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['Charge'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['Penalty'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['Status'] }}</td>
                                                            <td class="border border-gray-300 p-4">{{ $record['Issued Date'] }}</td>
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
