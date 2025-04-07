<x-app-layout>
   
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Scraped Vehicle Data
        </h2>
   

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(isset($results['results']) && count($results['results']) > 0)
                        @foreach($results['results'] as $scraped)
                            <div class="mb-8">
                                <h3 class="text-lg font-bold mb-2">Plate: {{ $scraped['plate_number'] ?? 'N/A' }}</h3>
                                @if(isset($scraped['records']) && count($scraped['records']) > 0)
                                    <table class="table-auto w-full border-collapse border border-gray-300">
                                        <thead>
                                            <tr>
                                                <th class="border border-gray-300 p-2">SN</th>
                                                <th class="border border-gray-300 p-2">Reference</th>
                                                <th class="border border-gray-300 p-2">License</th>
                                                <th class="border border-gray-300 p-2">Location</th>
                                                <th class="border border-gray-300 p-2">Offence</th>
                                                <th class="border border-gray-300 p-2">Charge</th>
                                                <th class="border border-gray-300 p-2">Penalty</th>
                                                <th class="border border-gray-300 p-2">Status</th>
                                                <th class="border border-gray-300 p-2">Issued Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($scraped['records'] as $record)
                                                <tr>
                                                    <td class="border border-gray-300 p-2">{{ $record['SN'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['Reference'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['License'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['Location'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['Offence'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['Charge'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['Penalty'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['Status'] }}</td>
                                                    <td class="border border-gray-300 p-2">{{ $record['Issued Date'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No records found for this plate.</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p>No scraped data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
