@extends('admin.layout.app')
@section("title","Subscribers :: Administrator - luqex")
@section('style')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Subscribers</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="admin">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Subscribers</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row animated fadeInRightBig">
            <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>All Subscribers</h5>
                        </div>
                        <div class="ibox-content">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Subscriber</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Subscribed At</th>
                            <th>Expire On</th>
                            <th>Status</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($subscribers as $subscriber)
                                <tr>
                                    <td>{{$subscriber->id}}</td>
                                    <td>{{$subscriber->user->name}}</td>
                                    <td>{{$subscriber->user->email}}</td>
                                    <td>{{$subscriber->company_name}}</td>
                                    <td>{{date('d-m-Y',strtotime($subscriber->subscribed_at))}}</td>
                                    <td>{{date('d-m-Y',strtotime($subscriber->expire_at))}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs {{$subscriber->status?'btn-primary':'btn-danger'}}">{{$subscriber->status?'Active':'Inactive'}}</button>
                                            <button type="button" class="btn btn-xs {{$subscriber->status?'btn-primary':'btn-danger'}} dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item update-status" data-id={{$subscriber->id}} href="#">Enable</a>
                                                <a class="dropdown-item update-status" data-id={{$subscriber->id}} href="#">Disable</a>
                                            </div>
                                        </div>
                                    </td>
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
                {extend: 'excel', title: 'Subscribers'},
                {extend: 'pdf', title: 'Subscribers'},
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

        $(document).on('click','.update-status',function(){
            id=$(this).data('id');
            status=$(this).html()=="Enable"?1:0;
            element=$(this);
            $.post('/admin/subscribers/update-status',{
                "_token": "{{ csrf_token() }}",
                id:id,
                status:status
            },function(result,status){
                if(result.status=="success"){
                    toastr.success('Subscriber status updated','Success!!');
                    //Update button style
                    if(element.html()=="Enable"){
                        element.closest('tr').find('.btn-danger').addClass("btn-primary");
                        element.closest('tr').find('.btn-primary').removeClass("btn-danger");
                        element.closest('tr').find('.btn-primary:nth(0)').html("Active");
                    }else{
                        element.closest('tr').find('.btn-primary').addClass("btn-danger");
                        element.closest('tr').find('.btn-danger').removeClass("btn-primary");
                        element.closest('tr').find('.btn-danger:nth(0)').html("Inactive")
                    }

                }else{
                    toastr.error('Something went wrong, Please try again','Oopz!!');
                }
            });
        });
    });
</script>
@endsection