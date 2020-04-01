 <!-- sidebar-menu  -->
 <div class="sidebar-menu">
        <ul class="navbar-nav">
                <li>
                        <a href="{{ route('home') }}" class="menu__link {!! classActiveRoute('home') !!}">
                            <i class="link__icon la la-dashboard"></i>
                            <span class="link__text">Dashboard</span>
                        </a>
                </li>
                <li class="menu__title menu__link">
                        <i class="link__icon la la-ellipsis-h"></i>
                        <span class="link__text">Manage</span>
                    </li>
                    @if(Helpers::has_permission('4_view') || Helpers::has_permission('5_view'))
                    <li class="dropdown {!! classOpenSegment(2,'users') !!} {!! classOpenSegment(2,'roles') !!}  ">
                            <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown">
                                <i class="link__icon la la-user-friends"></i>
                                <span class="link__text">User Details</span>
                                <i class="link__arrow la la-angle-right"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if(Helpers::has_permission('5_view'))
                                    <li class="{!! classActiveSegment('2','users') !!}">
                                        <a  href="{{ route('users.index') }}" class="menu__sublink">
                                                <i class="sublink__icon la la-circle"></i>
                                                <span class="link__text">All Users</span>
                                            </a></li>
                                   @endif             
                                    @if(Helpers::has_permission('4_view'))
                                        <li class="{!! classActiveSegment('2','roles') !!}">
                                        <a href="{{ route('roles.index') }}" class="menu__sublink ">
                                                <i class="sublink__icon la la-circle"></i>
                                                <span class="link__text">User Roles</span>
                                    </a>
                                    </li>
                                    @endif 
                            </ul>
                    </li>
                    @endif 
                    @if(Helpers::has_permission('1_view') || Helpers::has_permission('2_view')  || Helpers::has_permission('3_view'))
                    <li class="menu__title menu__link">
                        <i class="link__icon la la-ellipsis-h"></i>
                        <span class="link__text">Settings</span>
                    </li>
                    <li class="dropdown  {!! classOpenSegment(2,'settings') !!} {!! classOpenSegment(1,'categories') !!} {!! classOpenSegment(1,'categories_data') !!} ">
                            <a href="#" class="dropdown-toggle menu__link" data-toggle="dropdown">
                                <i class="link__icon la la-cogs"></i>
                                <span class="link__text">General</span>
                                <i class="link__arrow la la-angle-right"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if(Helpers::has_permission('1_view'))
                                    <li class="{!! classActiveRoute('settings')  !!}">
                                        <a  href="{{ route('settings') }}" class="menu__sublink">
                                                <i class="sublink__icon la la-circle"></i>
                                                <span class="link__text">Settings</span>
                                            </a></li>
                                   @endif             
                                    @if(Helpers::has_permission('2_view'))
                                        <li class="{!! classActiveRoute('preference_categories.index') !!}">
                                        <a href="{{ route('preference_categories.index') }}" class="menu__sublink ">
                                                <i class="sublink__icon la la-circle"></i>
                                                <span class="link__text">Preference Categories</span>
                                    </a>
                                    </li>
                                    @endif 
                                    @if(Helpers::has_permission('3_view'))
                                        <li class="{!! classActiveSegment('1','preferences') !!}">
                                        <a href="{{ route('preferences.index') }}" class="menu__sublink ">
                                                <i class="sublink__icon la la-circle"></i>
                                                <span class="link__text">Preferences</span>
                                    </a>
                                    </li>
                                    @endif 
                            </ul>
                            </li>
                          
                    @endif 
            <li>
                <a href="{{ URL::to('change_password')}}" class="ajax-popup menu__link">
                    <i class="link__icon la la-key"></i>
                    <span class="link__text">Change Password</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- sidebar-menu  -->