<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">



        <form action="/api/fetch-attendance" method="POST" autocomplete="off">
            @csrf
        
            <label>From Date:</label>
            <input type="date" name="from_date" value="{{ $fromdate ?? old('from_date') }}" autocomplete="off">
            
            <label>To Date:</label>
            <input type="date" name="to_date" value="{{ $todate ?? old('to_date') }}" autocomplete="off">
            
            <button type="submit">Get Attendance</button>
        </form>
        
        
        
        <h2 class="mb-4">Attendance Report</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>User ID</th>
                    <th>Process Date</th>
                    <th>Punch In</th>
                    <th>Punch Out</th>
                    <th>Total Hr</th>
                </tr>
            </thead>
            <tbody>
              


            @foreach($attendance as $record)
    <tr>
        <td>{{ $record['userid'] }}</td>
        
        <!-- Fix processdate_d format -->
        <td>
            @php
                try {
                    echo \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $record['processdate_d'])->format('d-m-Y');
                } catch (\Exception $e) {
                    echo $record['processdate_d']; // Show original value if parsing fails
                }
            @endphp
        </td>

        <!-- Fix punch1 format -->
        <td>
            @if(empty($record['punch1']))
                N/A
            @else
                @php
                    try {
                        echo \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $record['punch1'])->format('H:i:s');
                    } catch (\Exception $e) {
                        echo $record['punch1'];
                    }
                @endphp
            @endif
        </td>

        <!-- Fix outpunch format -->
        <td>
            @if(empty($record['outpunch']))
                N/A
            @else
                @php
                    try {
                        echo \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $record['outpunch'])->format('H:i:s');
                    } catch (\Exception $e) {
                        echo $record['outpunch'];
                    }
                @endphp
            @endif
        </td>

        <!-- Fix total time calculation -->
        <td>
            @if(!empty($record['punch1']) && !empty($record['outpunch']))
                @php
                    try {
                        $punchIn = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $record['punch1']);
                        $punchOut = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $record['outpunch']);
                        $totalTime = $punchIn->diff($punchOut)->format('%H:%I:%S');
                        echo $totalTime;
                    } catch (\Exception $e) {
                        echo 'N/A';
                    }
                @endphp
            @else
                N/A
            @endif
        </td>
    </tr>
@endforeach

            


            
            
            
            
            
            </tbody>
        </table>
    </div>
</body>
</html>
