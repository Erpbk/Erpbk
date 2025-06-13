<!-- need to remove -->
<li class="menu-item {{ Request::is('/') ? 'active' : '' }}">
    <a href="{{ route('home') }}" class="menu-link ">
      <i class="menu-icon tf-icons ti ti-layout-dashboard"></i>
      <div>Dashboard</div>
     {{--  <div class="badge bg-white text-dark rounded-pill ms-auto">2</div>  --}}
    </a>
  </li>
@can('item_view')
  <li class="menu-item {{ Request::is('items*') ? 'active' : '' }}">
    <a href="{{ route('items.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-notes"></i>
        <div>Items</div>
    </a>
</li>
@endcan
@can('customer_view')
<li class="menu-item {{ Request::is('customers*') ? 'active' : '' }}">
  <a href="{{ route('customers.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-user-star"></i>
      <div>Customers</div>
  </a>
</li>
@endcan
@can('vendor_view')
<li class="menu-item {{ Request::is('vendors*') ? 'active' : '' }}">
  <a href="{{ route('vendors.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-user-star"></i>
      <div>Vendors</div>
  </a>
</li>
@endcan
@can('rider_view')
<li class="menu-item {{ Request::is('riders*') ? 'active' : '' }}">
  <a href="{{ route('riders.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-user-pin"></i>
      <div>Riders</div>
  </a>
</li>
<li class="menu-item {{ Request::is('riderInvoices*') ? 'active' : '' }}">
  <a href="{{ route('riderInvoices.index') }}" class="menu-link ">
      <i class="menu-icon tf-icons ti ti-file"></i>
      <div>Invoices</div>
  </a>
</li>
<li class="menu-item {{ Request::is('riderActivities*') ? 'active' : '' }}">
  <a href="{{ route('riderActivities.index') }}" class="menu-link ">
      <i class="menu-icon tf-icons ti ti-bike"></i>
      <div>Activities</div>
  </a>
</li>
@endcan
@can('bank_view')
<li class="menu-item {{ Request::is('banks') ? 'active' : '' }}">
  <a href="{{ route('banks.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-building-bank"></i>
      <div>Banks</div>
  </a>
</li>
@endcan
@can('leasing_view')
<li class="menu-item {{ Request::is('leasingCompanies*') ? 'active' : '' }}">
  <a href="{{ route('leasingCompanies.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-building"></i>
      <div>Leasing Companies</div>
  </a>
</li>
@endcan
@can('garage_view')
<li class="menu-item {{ Request::is('garages*') ? 'active' : '' }}">
  <a href="{{ route('garages.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-parking"></i>
      <div>Garages</div>
  </a>
</li>
@endcan
@can('voucher_view')
<li class="menu-item {{ Request::is('vouchers*') ? 'active' : '' }}">
  <a href="{{ route('vouchers.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-device-sim"></i>
      <div>Vouchers</div>
  </a>
</li>
@endcan
@can('bike_view')
<li class="menu-item {{ Request::is('bikes*') ? 'active' : '' }}">
  <a href="{{ route('bikes.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-motorbike"></i>
      <div>Bikes</div>
  </a>
</li>
{{-- <li class="menu-item {{ Request::is('bikeHistories*') ? 'active' : '' }}">
  <a href="{{ route('bikeHistories.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-bike-off"></i>
      <div>Bike History</div>
  </a>
</li> --}}
@endcan
@can('sim_view')
<li class="menu-item {{ Request::is('sims*') ? 'active' : '' }}">
  <a href="{{ route('sims.index') }}" class="menu-link">
      <i class="menu-icon tf-icons ti ti-device-sim"></i>
      <div>Sims</div>
  </a>
</li>
@endcan

@canany(['supplier_view']) <!-- Replace with your actual permission(s) -->
<li class="menu-item {{ Request::is('suppliers*') ? 'open' : '' }}">

  <a href="javascript:void(0); " class="menu-link menu-toggle">
    <i class="menu-icon tf-icons ti ti-truck"></i> <!-- You can choose an icon -->
    <div>Supplier</div>
  </a>
  <ul class="menu-sub">

      <li class="menu-item {{ Request::is('suppliers*') ? 'active' : '' }}">
      <a href="{{ route('suppliers.index') }}" class="menu-link">
        <div>Suppliers</div>
      </a>
    </li>

    <li class="menu-item {{ Request::is('supplier-invoices*') ? 'active' : '' }}">
      <a href="{{ route('supplier_invoices.index') }}" class="menu-link">
        <div>Supplier Invoices</div>
      </a>
    </li>

    <!-- You can add other Supplier submenu items here -->

  </ul>
</li>
@endcanany

@canany(['account_view','gn_ledger'])
 <li class="menu-item {{ Request::is('accounts*') ? 'open' : '' }} {">
  <a href="javascript:void(0);" class="menu-link menu-toggle ">
    <i class="menu-icon tf-icons ti ti-graph"></i>
    <div data-i18n="Front Pages">Accounts</div>
  </a>
  <ul class="menu-sub">

     {{--  <li class="menu-item {{ Request::is('accounts/accounts') ? 'active' : '' }}">
        <a href="{{ route('accounts.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div>Chart Of Accounts</div>
        </a>
      </li>
 --}}
 @can('account_view')
      <li class="menu-item {{ Request::is('accounts/tree') ? 'active' : '' }}">
        <a href="{{ route('accounts.tree') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div>Chart Of Accounts</div>
        </a>
      </li>
      @endcan

      @can('gn_ledger')

      <li class="menu-item {{ Request::is('accounts/ledger') ? 'active' : '' }}">
        <a href="{{ route('accounts.ledger') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div>Ledger</div>
        </a>
      </li>
      @endcan


  </ul>
</li>
@endcan
<li class="menu-item {{ Request::is('reports*') ? 'open' : '' }} ">
    <a href="javascript:void(0);" class="menu-link menu-toggle ">
      <i class="menu-icon tf-icons ti ti-chart-area"></i>
      <div data-i18n="Front Pages">Reports</div>
    </a>
    <ul class="menu-sub">

  <li class="menu-item {{ Request::is('reports*') ? 'active' : '' }}">
    <a href="{{ route('reports.rider_report') }}" class="menu-link ">
        <i class="menu-icon tf-icons ti ti-users-group"></i>
        Rider Report
    </a>
    </li>
  </ul>
    </li>

  @can('user_view')
  <li class="menu-item {{ Request::is('users*') ? 'open' : '' }} {{ Request::is('roles*') ? 'open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle ">
      <i class="menu-icon tf-icons ti ti-users-group"></i>
      <div data-i18n="Front Pages">User Management</div>
    </a>
    <ul class="menu-sub">

  <li class="menu-item {{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}" class="menu-link ">
        <i class="menu-icon tf-icons ti ti-users-group"></i>
        Users
    </a>
    </li>


    @can('role_view')
    <li class="menu-item {{ Request::is('roles*') ? 'active' : '' }}">
    <a href="{{ route('roles.index') }}" class="menu-link ">
        <i class="menu-icon tf-icons ti ti-user-check"></i>
        Roles
    </a>
    </li>


    <li class="menu-item {{ Request::is('permissions*') ? 'active' : '' }}">
      <a href="{{ route('permissions.index') }}" class="menu-link ">
          <i class="menu-icon tf-icons ti ti-user-check"></i>
          Permissions
      </a>
      </li>
      @endcan
  </ul>
</li>
@endcan

@canany(['gn_settings','department_view','dropdown_view'])
<li class="menu-item {{ Request::is('settings*') ? 'open' : '' }} {">
  <a href="javascript:void(0);" class="menu-link menu-toggle ">
    <i class="menu-icon tf-icons ti ti-settings"></i>
    <div data-i18n="Front Pages">Company Settings</div>
  </a>
  <ul class="menu-sub">
    @can('gn_settings')
      <li class="menu-item {{ Request::is('settings/company') ? 'active' : '' }}">
        <a href="{{ route('settings') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div>Settings</div>
        </a>
      </li>
@endcan
@can('department_view')
      <li class="menu-item {{ Request::is('settings/departments') ? 'active' : '' }}">
        <a href="{{ route('departments.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div>Departments</div>
        </a>
      </li>
      @endcan
      @can('dropdown_view')

      <li class="menu-item {{ Request::is('settings/dropdowns') ? 'active' : '' }}">
        <a href="{{ route('dropdowns.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-list"></i>
            <div>Dropdowns</div>
        </a>
      </li>
      @endcan

  </ul>
</li>
@endcan


{{-- <li class="nav-item">
    <a href="{{ route('riderAttendances.index') }}" class="nav-link {{ Request::is('riderAttendances*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Rider Attendances</p>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a href="{{ route('riderActivities.index') }}" class="nav-link {{ Request::is('riderActivities*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Rider Activities</p>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a href="{{ route('riderEmails.index') }}" class="nav-link {{ Request::is('riderEmails*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Rider Emails</p>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a href="{{ route('files.index') }}" class="nav-link {{ Request::is('files*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Files</p>
    </a>
</li> --}}

