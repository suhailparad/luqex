<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">David Williams</span>
                        <span class="text-muted text-xs block">Administrator</span>
                    </a>
                </div>
                <div class="logo-element">
                    LQ
                </div>
            </li>
            <li class="{{Request::is('admin')?'active':''}}">
                <a href="/admin"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{Request::is('admin/packages')?'active':''}}">
                <a href="/admin/packages"><i class="fa fa-database"></i> <span class="nav-label">Packages</span></a>
            </li>
            <li class="{{Request::is('admin/subscribers')?'active':''}}">
                <a href="/admin/subscribers"><i class="fa fa-users"></i> <span class="nav-label">Subscribers</span></a>
            </li>
        </ul>
    </div>
</nav>