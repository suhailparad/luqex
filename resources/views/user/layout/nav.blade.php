<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{Auth::user()->name}}</span>
                        <span class="text-muted text-xs block">{{Auth::user()->subscription->company_name}}</span>
                    </a>
                </div>
                <div class="logo-element">
                    LQ
                </div>
            </li>
            <li class="{{Request::is('user')?'active':''}}">
                <a href="/user"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{Request::is('user/apps*')?'active':''}}">
                <a href="/user/apps"><i class="fa fa-globe"></i> <span class="nav-label">Web Apps</span></a>
            </li>
            <li class="{{Request::is('user/settings')?'active':''}}">
                <a href="/user/settings"><i class="fa fa-gears"></i> <span class="nav-label">Settings</span></a>
            </li>
        </ul>
    </div>
</nav>