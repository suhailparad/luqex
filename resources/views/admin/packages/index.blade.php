@extends('admin.layout.app')
@section("title","Packages :: Administrator - luqex")
@section('style')
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Packages</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="admin">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Packages</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <button id="openModal" class="btn btn-primary">Add Package</button>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row animated fadeInRightBig">
            <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>All Packages</h5>
                        </div>
                        <div class="ibox-content">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table" >
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                            <tr>
                                <td>{{$package->id}}</td>
                                <td>{{$package->name}}</td>
                                <td>{{$package->description}}</td>
                                <td>{{$package->price}}</td>
                                <td>
                                    <button data-id="{{$package->id}}" class="btn-edit btn btn-primary btn-xs"><i class="fa fa-edit"></i></button> 
                                    <button data-id="{{$package->id}}" class="btn-delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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
@include('admin.packages._modal')
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
            var name=$("input[name='name']").val();
            var description=$("textarea[name='description']").val();
            var price=$("input[name='price']").val();
            $.post("/admin/package/save",{
                "_token": "{{ csrf_token() }}",
                name:name,
                description:description,
                price:price
            },function(result,status){
                if(result.status="success"){
                    action=`
                        <button data-id="`+result.id+`" class="btn-edit btn btn-primary btn-xs"><i class="fa fa-edit"></i></button> 
                        <button data-id="`+result.id+`" class="btn-delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                    `;
                    table.row.add([result.id,
                        name,description,price,action
                    ]).draw();
                    $("#modal").modal("hide");
                    toastr.success('Package added successfully','Success!!');
                }else{
                    alert("failed");
                }
            })
        });

        //open edit
        $(document).on("click",".btn-edit",function(){
            name=$(this).closest("tr").children("td:nth(1)").html();
            description=$(this).closest("tr").children("td:nth(2)").html();
            price=$(this).closest("tr").children("td:nth(3)").html();
            id=$(this).data("id");
            $("button[id='save']").html("Update");
            $("button[id='save']").attr("id","update");
            $('input[name="name"]').val(name);
            $('textarea[name="description"]').val(description);
            $('input[name="price"]').val(price);
            $("input[name='_id']").val(id);
            $("#modal").modal("show");
            $('input[name="name"]').focus();
        });

        //update
        $(document).on("click","button[id='update']",function(){
            id=$("input[name='_id']").val();
            var name=$("input[name='name']").val();
            var description=$("textarea[name='description']").val();
            var price=$("input[name='price']").val();
            $.post("/admin/package/update",
                {
                    "_token": "{{ csrf_token() }}",
                    name:name,
                    description:description,
                    price:price,
                    id:id
                },
                function(result,status){
                    // update cell
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(1)")).data(name).draw();
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(2)")).data(description).draw();
                    table.cell($(".btn-edit[data-id='"+id+"']")
                    .closest("tr").children("td:nth(3)")).data(price).draw();
                    $("#modal").modal("hide");
                    toastr.success("Package has been updated successfully",'Success !!');
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
                    $.post("/admin/package/delete",
                        {
                            "_token": "{{ csrf_token() }}",
                            id:element.data('id')
                        },
                        function(data,status){
                            table
                                .row(element.closest('tr'))
                                .remove()
                                .draw();
                            toastr.success("Package has been deleted successfully!!!");
                        }
                    );
                }
            })
        });
        //On Modal close event
        $('#modal').on('hidden.bs.modal', function (e) {
            $("button[id='update']").attr("id","save");
            $("button[id='save']").html("Save");
            $("button[id='save']").removeAttr("disabled");
            $('input[name="name"]').val('');
            $("input[name='price']").val('');
            $("textarea[name='description']").val('');
            $("input[name='_id']").val('');
        });
    });
</script>
@endsection