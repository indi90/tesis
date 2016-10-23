@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Management History</div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th rowspan="2" style="vertical-align: middle; width: 30;" class="text-center">#</th>
                            <th colspan="2" class="text-center">DC Location</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center">Retail</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center">Track</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center">Development Cost (Rp.)</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center">Transportation Cost (Rp.)</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center">Saving Cost (Rp.)</th>
                            <th rowspan="2" style="vertical-align: middle;" class="text-center">Total Cost (Rp.)</th>
                        </tr>
                        <tr>
                            <th class="text-center">Long</th>
                            <th class="text-center">Lat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($histories->count() == 0)
                            <tr>
                                <td colspan="8" class="text-center">Data is empty</td>
                            </tr>
                        @else
                            @foreach($histories as $key => $history)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $history->longitude }}</td>
                                    <td>{{ $history->latitude }}</td>
                                    <td>
                                        <ul>
                                            @foreach($history->retails as $retail)
                                                <li>
                                                    {{ $retail->label }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ 'DC->'.str_replace(',', '->', $history->track).'->DC'.' ('.$history->total_distance.' Km)' }}</td>
                                    <td>{{ number_format($history->development_cost,2,',','.') }}</td>
                                    <td>{{ number_format($history->transportation_cost,2,',','.') }}</td>
                                    <td>{{ number_format($history->saving_cost,2,',','.') }}</td>
                                    <td>{{ number_format(($history->development_cost+$history->transportation_cost+$history->saving_cost),2,',','.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $histories->links() }}
            </div>
        </div>
    </div>
@endsection
