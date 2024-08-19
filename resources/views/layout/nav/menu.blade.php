<nav class="main-navbar">
    <div class="container">
        <ul>



            <li class="menu-item  ">
                <a href="{{route('dashboard')}}" class='menu-link'>
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
                                <a href="{{route('role.index')}}" class='submenu-link'>Role</a>


                            </li>
                            {{--<li class="submenu-item  ">
                                <a href="{{route('permission.index')}}" class='submenu-link'>Permission</a>


            </li>--}}


          
            <li class="submenu-item  ">
                <a href="{{route('adminuser.index')}}" class='submenu-link'>Users</a>


            </li>



        </ul>


    </div>
    </div>
    </li>
    <li class="menu-item  has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-box-seam-fill"></i>
            <span>Company</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item  ">
                        <a href="{{route('company.index')}}" class='submenu-link'>Company</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{route('bank.index')}}" class='submenu-link'>Bank</a>
                    </li>
                </ul>
            </div>
        </div>
    </li>
    <li class="menu-item  has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Shipping</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item  ">
                        <a href="{{route('client.index')}}" class='submenu-link'>Client</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{route('vessel-categories.index')}}" class='submenu-link'>Vessel Categories</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{route('vessel.index')}}" class='submenu-link'>Vessel</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{route('order.index')}}" class='submenu-link'>Order</a>
                    </li>
                    {{--<li class="submenu-item  ">
                        <a href="{{route('payment.index')}}" class='submenu-link'>Payment</a>
                    </li>--}}
                </ul>
            </div>
        </div>
    </li>
    {{-- <li class="menu-item  has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-boxes"></i>
            <span>Product</span>
        </a>
        <div class="submenu ">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item  ">
                        <a href="{{route('category.index')}}" class='submenu-link'>Categories</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{route('product-type.index')}}" class='submenu-link'>Product Type</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{route('product.index')}}" class='submenu-link'>Products</a>
                    </li>
                    <li class="submenu-item  ">
                        <a href="{{route('supplier.index')}}" class='submenu-link'>Suppliers</a>
                    </li>
                </ul>
            </div>
        </div>
    </li> --}}
    <li class="menu-item  has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-handbag"></i>
            <span>Fund</span>
        </a>
        <div class="submenu">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item">
                        <a href="{{route('requisition.index')}}" class='submenu-link'>Fund Requisition</a>
                    </li>
                    {{-- <li class="submenu-item">
                        <a href="{{route('product-requisition.index')}}" class='submenu-link'>Product Requisition</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </li>

    <li class="menu-item  has-sub">
        <a href="#" class='menu-link'>
            <i class="bi bi-handbag"></i>
            <span>HRM</span>
        </a>
        <div class="submenu">

            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item  ">
                        <a href="{{route('designation.index')}}" class='submenu-link'>Designation</a>
                    </li>
                    <li class="submenu-item">
                        <a href="{{route('employee.index')}}" class='submenu-link'>Employee List</a>
                    </li>
                    {{-- <li class="submenu-item has-sub">
                        <a href="#" class='submenu-link'>Attendance</a>
                        <ul class="subsubmenu">
                            <li class="subsubmenu-item">
                                <a href="{{route('attendance.create')}}" class=''>Add Attendance </a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('attendance.index')}}" class=''>Employee Attendance </a>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu-item has-sub">
                        <a href="#" class='submenu-link'>Payroll</a>
                        <ul class="subsubmenu">
                            <li class="subsubmenu-item">
                                <a href="{{route('leave-type.index')}}" class=''>Leave Type</a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('total-working-day.index')}}" class=''>Total Working Day (Month Wise)</a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('total-leave-per-year.index')}}" class=''>Total Assigned Leave</a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('leave.create')}}" class=''>Add Leave </a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('leave.index')}}" class=''>Leave</a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('salary-slip.create')}}" class=''>Generate Salary Slip</a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('salary-slip.index')}}" class=''>Salary Slip</a>
                            </li>
                            <li class="subsubmenu-item">
                                <a href="{{route('salary-advance-payment.index')}}" class=''>Salary Advance Payment</a>
                            </li>
                        </ul>
                    </li> --}}

                </ul>
            </div>
        </div>
    </li>


    <li class="menu-item has-sub">
        <a href="#" class='menu-link'><i class="bi bi-calculator"></i><span>{{__('Reports')}}</span>
        </a>
        <div class="submenu">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a class='submenu-link' href="{{route('vessel_report')}}">{{__('Vessel Expense Report')}}</a></li>
                </ul>
            </div>
        </div>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'><i class="bi bi-calculator"></i><span>{{__('Accounts')}}</span>
        </a>
        <div class="submenu">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    {{-- <li class="submenu-item"><a class='submenu-link' href="{{route('master.index')}}">{{__('Master Head')}}</a></li>
                    <li class="submenu-item"><a class='submenu-link' href="{{route('sub_head.index')}}">{{__('Sub Head')}}</a></li> --}}
                    <li class="submenu-item"><a class='submenu-link' href="{{route('child_one.index')}}">{{__('Child One')}}</a></li>
                    {{-- <li class="submenu-item"><a class='submenu-link' href="{{route('child_two.index')}}">{{__('Child Two')}}</a></li> --}}
                    <li class="submenu-item"><a class='submenu-link' href="{{route('navigate.index')}}">{{__('Navigate View')}}</a></li>
                    <li class="submenu-item"><a class='submenu-link' href="{{route('incomeStatement')}}">{{__('Income Statement')}}</a></li>
                    <li class="submenu-item"><a class='submenu-link' href="{{route('headreport')}}">{{__('Account Head Report')}}</a></li>
                </ul>
            </div>
        </div>
    </li>
    <li class="menu-item has-sub">
        <a href="#" class='menu-link'><i class="bi bi-receipt"></i><span>{{__('Voucher')}}</span>
        </a>
        <div class="submenu">
            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
            <div class="submenu-group-wrapper">
                <ul class="submenu-group">
                    <li class="submenu-item"><a class='submenu-link' href="{{route('credit.index')}}">{{__('Credit Voucher')}}</a></li>
                    <li class="submenu-item"><a class='submenu-link' href="{{route('debit.index')}}">{{__('Debit Voucher')}}</a></li>
                    <li class="submenu-item"><a class='submenu-link' href="{{route('journal.index')}}">{{__('Journal Voucher')}}</a></li>
                </ul>
            </div>
        </div>
    </li>
















    </ul>
    </div>
</nav>
