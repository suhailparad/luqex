@extends('user.layout.app')
@section("title","Settings - luqex.com")
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-6">
        <h2>Settings</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/user">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Settings</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row animated fadeInRightBig">
        <div class="col-lg-8">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="POST" action="/user/settings/update">
                        <div class="form-group row"><label class="col-lg-3 col-form-label">Full Name</label>
                            <div class="col-lg-9">
                                <input type="text" placeholder="Full Name" name="name" class="form-control" value="{{Auth::user()->name}}"> 
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-3 col-form-label">Email Id</label>
                            <div class="col-lg-9">
                                <input type="text" placeholder="Email" name="email" class="form-control" value="{{Auth::user()->email}}"> 
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-3 col-form-label">Company Name</label>
                            <div class="col-lg-9">
                                <input type="text" placeholder="Company name" name="company_name" class="form-control" 
                                value="{{Auth::user()->subscription->company_name}}"> 
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-3 col-form-label">New Password</label>
                            <div class="col-lg-9">
                                <input type="password" name="password" placeholder="Enter new password if you want to update" class="form-control"> 
                            </div>
                        </div>
                        <hr />
                        <div class="form-group row"><label class="col-lg-3 col-form-label">SMS Alert</label>
                            <div class="col-lg-9 ">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input data-id="99" type="checkbox" {{Auth::user()->subscription->enableSms?'checked':''}} name="smsAlert" class="status-checkbox onoffswitch-checkbox" id="activate-99">
                                        <label class="onoffswitch-label" for="activate-99">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-3 col-form-label">MSG91 Sender Id</label>
                            <div class="col-lg-9">
                                <input type="text" value="{{Auth::user()->subscription->senderId}}" name="senderId" placeholder="Enter Sender Id (6 letter)" maxlength="6" class="form-control"> 
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-3 col-form-label">SMS Recieve Number</label>
                            <div class="col-lg-9">
                                <input type="text" value="{{Auth::user()->subscription->number}}" name="number" placeholder="Enter number to recieve sms" maxlength="10" class="form-control"> 
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-lg-3 col-form-label">MSG91 Api Key</label>
                            <div class="col-lg-9">
                                <input type="text" name="apiKey" value="{{Auth::user()->subscription->smsApi}}"  placeholder="Enter Api Key" class="form-control"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-offset-2 col-lg-10">
                                {{ csrf_field() }}
                                <button class="btn btn-sm btn-primary" type="submit">Save Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(function(){
        @if(session('message'))
            toastr.success("{{session('message')}}")
        @endif
    });
    
</script>
@endsection