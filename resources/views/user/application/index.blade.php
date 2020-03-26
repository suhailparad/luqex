@extends('user.layout.app')
@section("title","Web Applications - luqex.com")
@section('style')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Web Applications</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/user">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Web Applications</strong>
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
                                    <th>Title</th>
                                    <th>URL</th>
                                    <th>Enabled</th>
                                    <th>Status</th>
                                    <th>Last Hit at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($apps as $index=>$app)
                                <tr>
                                    <td>{{ $index+1}}</td>
                                    <td>{{$app->title}}</td>
                                    <td><a href="{{$app->url}}" target="_blank" >{{$app->url}}</a></td>
                                    <td>
                                        <div class="switch">
                                            <div class="onoffswitch">
                                            <input data-id="{{$app->id}}" type="checkbox"  {{$app->enabled?'checked':''}} class="status-checkbox onoffswitch-checkbox" id="activate-{{$app->id}}">
                                            <label class="onoffswitch-label" for="activate-{{$app->id}}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        @if($app->status)
                                            <label class="label label-primary label-xs">Up</label>
                                        @else
                                            <label class="label label-danger label-xs">Down</label>
                                        @endif
                                    </td>
                                    <td>{{$app->lastHit!=null?\Carbon\Carbon::createFromTimeStamp(strtotime($app->lastHit->created_at))->diffForHumans():"Never"}}</td>
                                    <td>
                                        <button data-id="{{$app->id}}" title="Test Now" class="btn-hit btn btn-success btn-xs"><i class="fa fa-plug"></i></button>
                                        <a href="apps/{{$app->id}}/logs" title="Hit Logs" class="btn-log btn btn-info btn-xs"><i class="fa fa-eye"></i></a> 
                                        <button data-id="{{$app->id}}" title="Update" class="btn-edit btn btn-primary btn-xs"><i class="fa fa-edit"></i></button> 
                                        <button data-id="{{$app->id}}" title="Delete" class="btn-delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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
@include('user.application._modal')
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
                {extend: 'excel', title: 'Packages'},
                {extend: 'pdf', title: 'Packages'},
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

        //Open Add Modal
        $('#openModal').on('click',function(){
            $("#modal").modal("show");
        });

        //save
        $(document).on("click","button[id='save']",function(){
            //disable button
            $(this).attr("disabled","disabled");
            //loading indication on button 
            $(this).html("<i class='fa fa-spinner fa-spin'></i>");
            var title=$("input[name='name']").val();
            var url=$("input[name='url']").val();
            var status=$('input[name="enableDisable"]').is(":checked");
            $.post("/user/app/save",{
                "_token": "{{ csrf_token() }}",
                title:title,
                url:url,
                status:status
            },function(result,status){
                if(result.status="success"){
                    action=`
                        <button data-id="`+result.id+`" title="Test Now" class="btn-hit btn btn-success btn-xs"><i class="fa fa-plug"></i></button>
                        <a href="apps/`+result.id+`/logs" title="Hit Logs" class="btn-log btn btn-info btn-xs"><i class="fa fa-eye"></i></a> 
                        <button title="Update" data-id="`+result.id+`" class="btn-edit btn btn-primary btn-xs"><i class="fa fa-edit"></i></button> 
                        <button title="Delete" data-id="`+result.id+`" class="btn-delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                    `;
                    checked=$('input[name="enableDisable"]').is(":checked")?'checked':'';
                    enabled=`
                    <div class="switch">
                        <div class="onoffswitch">
                        <input data-id="`+result.id+`" type="checkbox" `+checked+`
                        class="status-checkbox onoffswitch-checkbox" id="activate-`+result.id+`">
                        <label class="onoffswitch-label" for="activate-`+result.id+`">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>`;
                    table.row.add([result.id,
                        title,url,enabled,"N/A","Never",action
                    ]).draw();
                    $("#modal").modal("hide");
                    toastr.success('Application added successfully','Success!!');
                }else{
                    toastr.error('Something went wrong, Please try again','Oopz!!');
                }
            })
        });

        //open edit
        $(document).on("click",".btn-edit",function(){
            name=$(this).closest("tr").children("td:nth(1)").html();
            url=$(this).closest("tr").children("td:nth(2)").html();
            id=$(this).data("id");
            $("button[id='save']").html("Update");
            $("button[id='save']").attr("id","update");
            $('input[name="name"]').val(name);
            $('input[name="url"]').val(url);
            $("input[name='_id']").val(id);
            status=$(this).closest("tr").children("td:nth(3)").find(".onoffswitch-checkbox").is(":checked");
            if(status=="true"){
                $("input[name='enableDisable']").prop("checked", true);
            }else{
                $("input[name='enableDisable']").prop("checked", false);
            }
            $("#modal").modal("show");
            $('input[name="name"]').focus();
            
        });

        //update
        $(document).on("click","button[id='update']",function(){
            id=$("input[name='_id']").val();
            var title=$("input[name='name']").val();
            var url=$("input[name='url']").val();
            var status=$('input[name="enableDisable"]').is(":checked");
            $.post("/user/app/update",
                {
                    "_token": "{{ csrf_token() }}",
                    title:title,
                    url:url,
                    status:status,
                    id:id
                },
                function(result,response){
                    prevStatus="";
                    if($('input[name="enableDisable"]').is(":checked")){
                        prevStatus="checked";
                    }
                    status=`
                        <div class="switch">
                            <div class="onoffswitch">
                            <input type="checkbox" `+prevStatus+` class="status-checkbox onoffswitch-checkbox" id="activate-`+id+`">
                            <label class="onoffswitch-label" for="activate-`+id+`">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    `;
                    // update cell
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(1)")).data(title).draw();
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(2)")).data(url).draw();
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(3)")).data(status).draw();
                    $("#modal").modal("hide");
                    toastr.success("Application has been updated successfully",'Success !!');
                }
            );
        });

        //delete
        $(document).on("click",".btn-delete",function(){
            element=$(this);
            id=$(this).data("id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    //Code for Delete
                    $.post("/user/app/delete",
                        {
                            "_token": "{{ csrf_token() }}",
                            id:element.data('id')
                        },
                        function(data,status){
                            table
                                .row(element.closest('tr'))
                                .remove()
                                .draw();
                            toastr.success("Application has been deleted successfully!!!");
                        }
                    );
                }
            })
        });

        //Update Status
        $(document).on('change','.status-checkbox',function(){
            id=$(this).data('id');
            $.post('/user/app/toggle-status',{
                "_token": "{{ csrf_token() }}",
                id:id,
            },
            function(result,status){
                if(result.status="success"){
                    toastr.success('Application status changed','Success!!');
                }else{
                    toastr.success('Something went wrong','Oopz!!');
                }
            })
        });
        
        //Single Hit
        $(document).on("click",".btn-hit",function(){
            id=$(this).data("id");
            element=$(this);
            element.html("<i class='fa fa-spinner fa-spin'></i>");
            element.attr("disabled","disabled");
            $.get("/user/app/"+id+"/hit",{},function(result,status){
                element.html("<i class='fa fa-plug'></i>");
                element.removeAttr("disabled");
                if(result.status=="success"){
                    status=`<label class="label label-primary label-xs">Up</label>`;
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(4)")).data(status).draw();
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(5)")).data("just now").draw();
                    toastr.success('Your application is up and available','Success!!');
                }else{
                    status=`<label class="label label-danger label-xs">Down</label>`;
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(4)")).data(status).draw();
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(5)")).data("just now").draw();
                    toastr.error('Your application is down, Response Code :'+result.code,'Oopz!!');
                }
            })
        });

        //On Modal close event
        $('#modal').on('hidden.bs.modal', function (e) {
            $("button[id='update']").attr("id","save");
            $("button[id='save']").html("Save");
            $("button[id='save']").removeAttr("disabled");
            $('input[name="name"]').val('');
            $("input[name='url']").val('');
            $('input[name="enableDisable"]').prop("checked", true);
            $("input[name='_id']").val('');
        });
    });
</script>
@endsection