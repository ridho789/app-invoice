<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark ps ps--active-y bg-white" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard-pro/pages/dashboards/analytics.html " target="_blank">
            <img src="{{ asset('') }}asset/assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Reportify Shipment</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto h-auto ps" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @if (Auth::check())
                @if (Auth::user()->level == 0)
                    <li class="nav-item mt-3">
                        <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">MGMT</h6>
                    </li>
                    <li class="nav-item">
                        <div>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->is('list_shipments', 'form_sea_shipment', 'form_air_shipment', 'list_sea_shipment', 'list_air_shipment', 'sea_shipment-edit/*', 'air_shipment-edit/*') ? 'active bg-gradient-primary' : '' }}" 
                                    href="{{ url('/list_shipments') }}">
                                        <span class="sidenav-mini-icon"> S </span>
                                        <span class="nav-link-text ms-1">Shipments</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->is('list_bill_recap', 'form_bill_recap', 'form_air_bill_recap', 'bill_recap-edit/*', 'bill_recap-editair/*') ? 'active bg-gradient-primary' : '' }}" 
                                    href="{{ url('/list_bill_recap') }}">
                                        <span class="sidenav-mini-icon"> Br </span>
                                        <span class="nav-link-text ms-1">Bill Recap (SOA)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <hr class="horizontal light">
                        <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">Main</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('account') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/account') }}">
                            <span class="sidenav-mini-icon"> A </span>
                            <span class="nav-link-text ms-1">Accounts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('banker') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/banker') }}">
                            <span class="sidenav-mini-icon"> B </span>
                            <span class="nav-link-text ms-1">Bankers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('company') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/company') }}">
                            <span class="sidenav-mini-icon"> Co </span>
                            <span class="nav-link-text ms-1">Companies</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('customer') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/customer') }}">
                            <span class="sidenav-mini-icon"> Cu </span>
                            <span class="nav-link-text ms-1">Customers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('desc') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/desc') }}">
                            <span class="sidenav-mini-icon"> D </span>
                            <span class="nav-link-text ms-1">Descs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('origin') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/origin') }}">
                            <span class="sidenav-mini-icon"> O </span>
                            <span class="nav-link-text ms-1">Origins</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('ship') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/ship') }}">
                            <span class="sidenav-mini-icon"> S </span>
                            <span class="nav-link-text ms-1">Ships</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('shipper') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/shipper') }}">
                            <span class="sidenav-mini-icon"> Sh </span>
                            <span class="nav-link-text ms-1">Shippers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('state') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/state') }}">
                            <span class="sidenav-mini-icon"> St </span>
                            <span class="nav-link-text ms-1">States</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('unit') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/unit') }}">
                            <span class="sidenav-mini-icon"> U </span>
                            <span class="nav-link-text ms-1">Units</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('uom') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/uom') }}">
                            <span class="sidenav-mini-icon"> Uo </span>
                            <span class="nav-link-text ms-1">UOM</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <hr class="horizontal light">
                        <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">Fees</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('cas') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/cas') }}">
                            <span class="sidenav-mini-icon"> C </span>
                            <span class="nav-link-text ms-1">Cas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('pricelist') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/pricelist') }}">
                            <span class="sidenav-mini-icon"> P </span>
                            <span class="nav-link-text ms-1">Pricelists</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <hr class="horizontal light">
                        <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">Misc</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('history') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/history') }}">
                            <span class="sidenav-mini-icon"> H </span>
                            <span class="nav-link-text ms-1">Histories</span>
                        </a>
                    </li>
                @elseif (Auth::user()->level == 1)
                    <li class="nav-item mt-3">
                        <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">MGMT</h6>
                    </li>
                    <li class="nav-item">
                        <div>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->is('list_shipments', 'form_sea_shipment', 'list_sea_shipment', 'sea_shipment-edit/*') ? 'active bg-gradient-primary' : '' }}" 
                                    href="{{ url('/list_shipments') }}">
                                        <span class="sidenav-mini-icon"> S </span>
                                        <span class="nav-link-text ms-1">Shipments</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->is('list_bill_recap', 'form_bill_recap', 'bill_recap-edit/*') ? 'active bg-gradient-primary' : '' }}" 
                                    href="{{ url('/list_bill_recap') }}">
                                        <span class="sidenav-mini-icon"> B </span>
                                        <span class="nav-link-text ms-1">Bill Recap (SOA)</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <hr class="horizontal light">
                        <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">Main</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('account') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/account') }}">
                            <span class="sidenav-mini-icon"> A </span>
                            <span class="nav-link-text ms-1">Accounts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('banker') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/banker') }}">
                            <span class="sidenav-mini-icon"> B </span>
                            <span class="nav-link-text ms-1">Bankers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('company') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/company') }}">
                            <span class="sidenav-mini-icon"> Co </span>
                            <span class="nav-link-text ms-1">Companies</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('customer') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/customer') }}">
                            <span class="sidenav-mini-icon"> Cu </span>
                            <span class="nav-link-text ms-1">Customers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('desc') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/desc') }}">
                            <span class="sidenav-mini-icon"> D </span>
                            <span class="nav-link-text ms-1">Descs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('origin') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/origin') }}">
                            <span class="sidenav-mini-icon"> O </span>
                            <span class="nav-link-text ms-1">Origins</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('ship') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/ship') }}">
                            <span class="sidenav-mini-icon"> S </span>
                            <span class="nav-link-text ms-1">Ships</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('shipper') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/shipper') }}">
                            <span class="sidenav-mini-icon"> Sh </span>
                            <span class="nav-link-text ms-1">Shippers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('state') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/state') }}">
                            <span class="sidenav-mini-icon"> St </span>
                            <span class="nav-link-text ms-1">States</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('unit') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/unit') }}">
                            <span class="sidenav-mini-icon"> U </span>
                            <span class="nav-link-text ms-1">Units</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('uom') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/uom') }}">
                            <span class="sidenav-mini-icon"> Uo </span>
                            <span class="nav-link-text ms-1">UOM</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <hr class="horizontal light">
                        <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">Fees</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('cas') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/cas') }}">
                            <span class="sidenav-mini-icon"> C </span>
                            <span class="nav-link-text ms-1">Cas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('pricelist') ? 'active bg-gradient-primary' : '' }}" href="{{ url('/pricelist') }}">
                            <span class="sidenav-mini-icon"> P </span>
                            <span class="nav-link-text ms-1">Pricelists</span>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</aside>