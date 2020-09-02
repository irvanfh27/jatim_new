<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered"><a href="profile.html"><img src="{{ asset('/') }}img/ui-sam.jpg" class="img-circle"
                                                            width="80"></a>
            </p>
            <h5 class="centered">{{ Auth::user()->name }}</h5>
            <router-link :to="{ name: 'dashboard'}" v-slot="{ href, navigate, isActive }">
                <li class="mt" :class="[isActive && 'active']">
                    <a :href="href" @click="navigate"><i class="fa fa-dashboard"></i>Dashboard</a>
                </li>
            </router-link>
            {{--            <li class="mt">--}}
            {{--                <a class="{{ Request::route()->getName() == 'home' ? ' active' : '' }}" href="{{ route('home') }}">--}}
            {{--                    <i class="fa fa-dashboard"></i>--}}
            {{--                    <span>Dashboard</span>--}}
            {{--                </a>--}}
            {{--            </li>--}}
            <li class="sub-menu">
                <a class="{{ request()->segment(1) == 'nota-timbang' ? ' active' : '' }}" href="javascript:;">
                    <i class="fa fa-desktop"></i>
                    <span>Nota Timbang</span>
                </a>
                <ul class="sub">
                    <li><a class="{{ request()->segment(2) == 'input-nota-timbang' ? ' active' : '' }}"
                           href="general.html">Input Nota Timbang</a></li>
                    <li><a href="buttons.html">Search Nota Timbang</a></li>
                    <li><a href="panels.html">Input Nota Timbang(NEW)</a></li>
                    <li><a href="buttons.html">Search Nota Timbang(NEW)</a></li>
                    <li><a href="font_awesome.html">Import Data Timbangan</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-money"></i>
                    <span>Payment</span>
                </a>
                <ul class="sub">
                    <li><a href="grids.html">Grids</a></li>
                    <li><a href="calendar.html">Calendar</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="todo_list.html">Todo List</a></li>
                    <li><a href="dropzone.html">Dropzone File Upload</a></li>
                    <li><a href="inline_editor.html">Inline Editor</a></li>
                    <li><a href="file_upload.html">Multiple File Upload</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-book"></i>
                    <span>Invoice</span>
                </a>
                <ul class="sub">
                    <li class="active"><a href="blank.html">Blank Page</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="lock_screen.html">Lock Screen</a></li>
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="invoice.html">Invoice</a></li>
                    <li><a href="pricing_table.html">Pricing Table</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                    <li><a href="404.html">404 Error</a></li>
                    <li><a href="500.html">500 Error</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-tasks"></i>
                    <span>Contracts</span>
                </a>
                <ul class="sub">
                    <li><a href="form_component.html">Form Components</a></li>
                    <li><a href="advanced_form_components.html">Advanced Components</a></li>
                    <li><a href="form_validation.html">Form Validation</a></li>
                    <li><a href="contactform.html">Contact Form</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-th"></i>
                    <span>Sales</span>
                </a>
                <ul class="sub">
                    <li><a href="basic_table.html">Basic Table</a></li>
                    <li><a href="responsive_table.html">Responsive Table</a></li>
                    <li><a href="advanced_table.html">Advanced Table</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class=" fa fa-bar-chart-o"></i>
                    <span>Reports</span>
                </a>
                <ul class="sub">
                    <li><a href="morris.html">Morris</a></li>
                    <li><a href="chartjs.html">Chartjs</a></li>
                    <li><a href="flot_chart.html">Flot Charts</a></li>
                    <li><a href="xchart.html">xChart</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ request()->segment(1) == 'configuration' ? ' active' : '' }}" href="javascript:;">
                    <i class="fa fa-cogs"></i>
                    <span>Configuration</span>
                </a>
                <ul class="sub">
                    <li>
                        <a class="{{ request()->segment(2) == 'users' ? ' active' : '' }}"
                           href="{{ route('configuration.users.index') }}">Users</a>
                    </li>
                    <li><a class="{{ request()->segment(2) == 'modules' ? ' active' : '' }}" href="chat_room.html">Modules</a>
                    </li>
                    <router-link :to="{ name: 'stockpiles'}" v-slot="{ href, navigate, isActive }">
                        <li :class="[isActive && 'active']">
                            <a :href="href" @click="navigate">Stockpiles</a>
                        </li>
                    </router-link>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-cogs"></i>
                    <span>Data Vendor</span>
                </a>
                <ul class="sub">
                    <li><a href="lobby.html">Lobby</a></li>
                    <li><a href="chat_room.html"> Chat Room</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ request()->segment(1) == 'po' ? ' active' : '' }}" href="javascript:;">
                    <i class="fa fa-cogs"></i>
                    <span>PO</span>
                </a>
                <ul class="sub">
                    <li>
                        <a class="{{ request()->segment(2) == 'uoms' ? ' active' : '' }}"
                           href="{{ route('po.uoms.index') }}">Uom</a>
                    </li>
                    <li>
                        <a class="{{ request()->segment(2) == 'group-items' ? ' active' : '' }}"
                           href="{{ route('po.group-items.index') }}">Group Items</a>
                    </li>
                    <li>
                        <a class="{{ request()->segment(2) == 'items' ? ' active' : '' }}"
                           href="{{ route('po.items.index') }}">Items</a>
                    </li>
                    <li>
                        <a class="{{ request()->segment(2) == 'signs' ? ' active' : '' }}"
                           href="{{ route('po.signs.index') }}">Signs</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
