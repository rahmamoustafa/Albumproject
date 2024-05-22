@extends('layouts.app')
@section('links')
    <link href="{{ asset('/css/home.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container mt-5 text-center">
        <h2 class="mb-4">My Albums :</h2>
        <div class="btn btn-primary"><a href="{{ route('ablum.add') }}" class="btn btn-sm">Add Album</a></div>
        <table class="table table-bordered yajra-datatable cell-border">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Created_at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        <h3> Chart # of photos:
        <canvas id="myChart" ></canvas>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
                            /** datatables*/
        $(function() {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ablums.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true,

                    },
                ]
            });

        });
            /*       chart js                */
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @if (isset($albums))
                        @for ($i = 0; $i < count($albums); $i++)
                            "{{ $albums[$i] }}",
                        @endfor
                    @endif
                ],
                datasets: [{
                    label: 'Number pictures in albums',
                    data: [
                        @if (isset($count))
                            @for ($i = 0; $i < count($count); $i++)
                                "{{ $count[$i] }}",
                            @endfor
                        @endif
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
