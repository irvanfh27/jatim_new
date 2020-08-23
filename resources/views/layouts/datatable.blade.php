@extends('layouts.app')

@section('content')
    <section class="panel">
        <header class="panel-heading wht-bg">
            <h4 class="gen-case">
                {{ $config['title'] }}
            </h4>
        </header>
        <header class="panel-heading wht-bg">
            @isset($config['route-add'])
                <a href="{{route($config['route-add'])}}" class="btn btn-theme"><i class="fa fa-plus"></i> Add Data</a>
            @endisset
        </header>
        <div class="panel-body minimal">
            <div class="mail-option">
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered"
                           id="hidden-table-info">
                        <thead>
                        <tr>
                            <th class="hidden-phone" width="120">
                                Action
                            </th>
                            @foreach ($columns as $column)
                                <th class="hidden-phone">{{ $column['title'] }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $row)
                            <tr>
                                <td class="center hidden-phone">
                                    <form action="{{ route($config['route-delete'], $row->uuid) }}"
                                          method="post" id="delete-{{$row->id}}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a class="badge bg-important"
                                       href="{{ route($config['route-delete'], $row->uuid) }}"
                                       onclick="event.preventDefault();document.getElementById('delete-{{ $row->id }}').submit();">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <a href="{{ route($config['route-edit'], $row->uuid) }}"
                                       class="badge bg-warning"
                                       title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                @foreach ($columns as $column)
                                    <td class="hidden-phone">{{ $row[$column['field']] }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('css')
    <link href="{{ asset('/') }}lib/advanced-datatable/css/demo_page.css" rel="stylesheet"/>
    <link href="{{ asset('/') }}lib/advanced-datatable/css/demo_table.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/') }}lib/advanced-datatable/css/DT_bootstrap.css"/>
@endpush
@push('js')
    <script type="text/javascript" language="javascript"
            src="{{ asset('/') }}lib/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{{ asset('/') }}lib/advanced-datatable/js/DT_bootstrap.js"></script>
    <script type="text/javascript">
        /* Formating function for row details */
        // function fnFormatDetails(oTable, nTr) {
        //     var aData = oTable.fnGetData(nTr);
        //     var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        //     sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
        //     sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
        //     sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
        //     sOut += '</table>';
        //
        //     return sOut;
        // }

        $(document).ready(function () {
            /*
             * Insert a 'details' column to the table
             */
            // var nCloneTh = document.createElement('th');
            // var nCloneTd = document.createElement('td');
            // nCloneTd.innerHTML = '<img src="lib/advanced-datatable/images/details_open.png">';
            // nCloneTd.className = "center";
            //
            // $('#hidden-table-info thead tr').each(function () {
            //     this.insertBefore(nCloneTh, this.childNodes[0]);
            // });
            //
            // $('#hidden-table-info tbody tr').each(function () {
            //     this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
            // });

            /*
             * Initialse DataTables, with no sorting on the 'details' column
             */
            var oTable = $('#hidden-table-info').dataTable({
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0]
                }],
                "aaSorting": [
                    [1, 'asc']
                ]
            });

            /* Add event listener for opening and closing details
             * Note that the indicator for showing which row is open is not controlled by DataTables,
             * rather it is done here
             */
            // $('#hidden-table-info tbody td img').live('click', function () {
            //     var nTr = $(this).parents('tr')[0];
            //     if (oTable.fnIsOpen(nTr)) {
            //         /* This row is already open - close it */
            //         this.src = "lib/advanced-datatable/media/images/details_open.png";
            //         oTable.fnClose(nTr);
            //     } else {
            //         /* Open this row */
            //         this.src = "lib/advanced-datatable/images/details_close.png";
            //         oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            //     }
            // });
        });
    </script>

@endpush
