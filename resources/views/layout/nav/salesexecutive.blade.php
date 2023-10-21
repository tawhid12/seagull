<nav class="main-navbar">
    <div class="container">
        <ul>



            <li class="menu-item  ">
                <a href="" class='menu-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>








            <li class="menu-item  has-sub">
                <a href="#" class='menu-link'>
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
                <div class="submenu ">
                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                    <div class="submenu-group-wrapper">


                        <ul class="submenu-group">

                            {{--<li class="submenu-item  has-sub">
                                                <a href="#" class='submenu-link'>Form Elements</a>


                                                <!-- 3 Level Submenu -->
                                                <ul class="subsubmenu">

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-input.html" class="subsubmenu-link">Input</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-input-group.html" class="subsubmenu-link">Input Group</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-select.html" class="subsubmenu-link">Select</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-radio.html" class="subsubmenu-link">Radio</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-checkbox.html" class="subsubmenu-link">Checkbox</a>
                                                    </li>

                                                    <li class="subsubmenu-item ">
                                                        <a href="form-element-textarea.html" class="subsubmenu-link">Textarea</a>
                                                    </li>

                                                </ul>

                                            </li>--}}
                                            <li class="submenu-item  ">
                                <a href="{{route('role.index', ['role' =>currentUser()])}}" class='submenu-link'>Role</a>


                            </li>
                                            <li class="submenu-item  ">
                                <a href="{{route('permission.index', ['role' =>currentUser()])}}" class='submenu-link'>Permission</a>


                            </li>
   

                            <li class="submenu-item  ">
                                <a href="{{route('designation.index', ['role' =>currentUser()])}}" class='submenu-link'>Designation</a>


                            </li>
                            <li class="submenu-item  ">
                                <a href="{{route('adminuser.index', ['role' =>currentUser()])}}" class='submenu-link'>Users</a>


                            </li>



                        </ul>


                    </div>
                </div>
            </li>
            <li class="menu-item  has-sub">
                <a href="#" class='menu-link'>
                    <i class="bi bi-gear"></i>
                    <span>Company</span>
                </a>
                <div class="submenu ">
                    <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                    <div class="submenu-group-wrapper">
                        <ul class="submenu-group">
                            <li class="submenu-item  ">
                                <a href="{{route('company.index', ['role' =>currentUser()])}}" class='submenu-link'>Company</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
















        </ul>
    </div>
</nav>