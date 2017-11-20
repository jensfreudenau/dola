@extends('layouts.front')
@section('content')
    <style type="text/css" media="screen">
        

.table.no-border tr td, .table.no-border tr th {
  border-width: 0;
}
    </style>
    <h2>Archiv</h2>
    <hr>
    @foreach ($archives as $season => $archive)
        @if(!$archive)  @php continue @endphp @endif
        <h3>{{ $season }}</h3>
        @foreach ($archive as $year => $results)
            @php $i = 0 @endphp
            <div class="card mb-3">
                <div class="card-body pb-0">
                    <h4 class="card-title pb-0">{{ $year }}</h4>
                </div>
                <div class="card-body">
                    <table class="table no-border">
                        @foreach($results as $key => $day)
                            @if ($i % 4 == 0) <tr> @endif
                            @php $i ++ @endphp
                            <td>
                                <a href="{{ asset('resultsets/'.$season.'/'.basename($day['file'])) }}" taget="_blank">{{$day['date'] }}</a>
                                
                        @endforeach
                    </table>
                </div>

            </div>
        @endforeach
    @endforeach
@endsection