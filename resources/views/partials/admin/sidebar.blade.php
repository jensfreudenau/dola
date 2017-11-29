@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/admin') }}"> <i class="fa fa-wrench"></i> <span class="title">@lang('quickadmin.qa_dashboard')</span> </a>
            </li>
            @can('user_management_access')
                <li class="treeview">
                    <a href="#"> <i class="fa fa-users"></i> <span class="title">@lang('quickadmin.user-management.title')</span> <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        @can('role_access')
                            <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.roles.index') }}"> <i class="fa fa-briefcase"></i> <span class="title">
                                @lang('quickadmin.roles.title')
                            </span> </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                                <a href="{{ route('admin.users.index') }}"> <i class="fa fa-user"></i> <span class="title">
                                @lang('quickadmin.users.title')
                            </span> </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('organizer_access')
                <li class="{{ $request->segment(2) == 'organizers' ? 'active' : '' }}">
                    <a href="{{ route('admin.organizers.index') }}"> <i class="fa fa-gears"></i> <span class="title">@lang('quickadmin.organizers.title')</span> </a>
                </li>
            @endcan

            @can('participators_access')
                <li class="{{ $request->segment(2) == 'participators' ? 'active' : '' }}">
                    <a href="{{ route('admin.participators.index') }}"> <i class="fa fa-user"></i> <span class="title">@lang('quickadmin.participators.title')</span> </a>
                </li>
            @endcan

            @can('record_access')
                <li class="treeview">
                    <a href="#"> <i class="fa fa-trophy"></i> <span class="title">@lang('quickadmin.records.title')</span> <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span> </a>
                    <ul class="treeview-menu">
                        <li class="{{ $request->segment(2) == 'bests' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.records.index') }}"> <i class="fa fa-briefcase"></i> <span class="title">
                                @lang('quickadmin.records.records.title')
                            </span> </a>
                        </li>

                        <li class="{{ $request->segment(2) == 'records' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.records.bestsindex') }}"> <i class="fa fa-bars"></i> <span class="title">
                                @lang('quickadmin.records.bests.title')
                            </span> </a>
                        </li>

                    </ul>
                </li>

            @endcan

            @can('address_access')
                <li class="{{ $request->segment(2) == 'addresses' ? 'active' : '' }}">
                    <a href="{{ route('admin.addresses.index') }}"> <i class="fa fa-address-card-o"></i> <span class="title">@lang('quickadmin.addresses.title')</span> </a>
                </li>
            @endcan

            @can('competition_access')
                <li class="{{ $request->segment(2) == 'competitions' ? 'active' : '' }}">
                    <a href="{{ route('admin.competitions.index') }}"> <i class="fa fa-soccer-ball-o"></i> <span class="title">@lang('quickadmin.competitions.title')</span> </a>
                </li>
            @endcan

            @can('competition_access')
                <li class="{{ $request->segment(2) == 'pages' ? 'active' : '' }}">
                    <a href="{{ route('admin.pages.index') }}"> <i class="fa fa-file-text-o"></i> <span class="title">@lang('quickadmin.pages.title')</span> </a>
                </li>
            @endcan

            <li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
                <a href="{{ route('auth.change_password') }}"> <i class="fa fa-key"></i> <span class="title">Change password</span> </a>
            </li>

            <li>
                <a href="#logout" onclick="$('#logout').submit();"> <i class="fa fa-arrow-left"></i> <span class="title">@lang('quickadmin.qa_logout')</span> </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('quickadmin.logout')</button>
{!! Form::close() !!}
