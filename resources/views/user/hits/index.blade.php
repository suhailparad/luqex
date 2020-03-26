@extends('user.layout.app')
@section("title","Hit Logs - luqex.com")
@section('style')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Hit Logs</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/user">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/user/apps">Web Apps</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Logs</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-6">
        <div class="title-action">
            <button id="openModal" class="btn btn-primary">Add Application</button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row animated fadeInRightBig">
            <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>All Applications</h5>
                        </div>
                        <div class="ibox-content">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>On</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                    <th>Hit By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $key=>$app)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$app->created_at}}</td>
                                    <td>
                                        @if($app->status=="Up")
                                            <label class="label label-primary label-xs">Up</label>
                                        @else
                                            <label class="label label-danger label-xs">Down</label>
                                        @endif
                                    </td>
                                    <td>{{$app->note}}</td>
                                    <td>{{$app->hit_by}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('assets/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(function(){
        //categories table
        var table = $('#table').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'Hit Logs'},
                {extend: 'pdf', title: 'Hit Logs'},
                {extend: 'print',
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                }
            ]
        });
    });
</script>
@endsection