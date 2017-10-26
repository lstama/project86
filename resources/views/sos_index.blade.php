@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Admin Dashboard</div>

                    <div class="panel-body">
                        <table class="table table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($sos as $item)
                                    <tr>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->latitude }}</td>
                                        <td>{{ $item->longitude }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        {{ $sos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
