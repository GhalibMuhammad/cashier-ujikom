<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Home</h6>
                    <ul>
                        <li class="{{ Request::is('index', '/',) ? 'active' : '' }}"><a
                                href="{{ url('index') }}"><i data-feather="box"></i><span>Dashboard</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Inventory</h6>
                    <ul>
                        <li class="{{ Request::is('product-list','product-details') ? 'active' : '' }}"><a
                                href="{{ url('product-list') }}"><i data-feather="box"></i><span>Products</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Sales</h6>
                    <ul>
                        <li class="{{ Request::is('sales/list') ? 'active' : '' }}"><a
                                href="{{ url('sales/list') }}"><i
                                    data-feather="shopping-cart"></i><span>Sales</span></a></li>
                        </li>
                        @if (Auth::user()->role == 'employee')

                        <li class="{{ Request::is('sales/create') ? 'active' : '' }}"><a href="{{ url('sales/create') }}"><i
                                    data-feather="hard-drive"></i><span>POS</span></a></li>
                        @endif
                    </ul>
                </li>

                @if (Auth::user()->role == 'admin')

                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li class="{{ Request::is('users') ? 'active' : '' }}"><a href="{{ url('users') }}"><i
                                    data-feather="user-check"></i><span>Users</span></a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
