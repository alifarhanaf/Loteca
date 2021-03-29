<body class="az-body az-body-sidebar">

    <div class="az-sidebar">
      <div class="az-sidebar-header">
        <a href="index.html" class="az-logo"><b>Lo<span>te</span>ca 2.0</b></a>
      </div><!-- az-sidebar-header -->
      <div class="az-sidebar-loggedin">
        <div class="az-img-user online"><img src="https://via.placeholder.com/500" alt=""></div>
        <div class="media-body">
          <h6>Farhan Ali</h6>
          <span>Administrator</span>
        </div><!-- media-body -->
      </div><!-- az-sidebar-loggedin -->
      <div class="az-sidebar-body">
        <ul class="nav">
          <li class="nav-label">Main Menu</li>
          <li class="nav-item  {{ request()->is('dashboard') ? 'active' : ''}} {{ request()->is('dashboard') ? 'show' : ''}} ">
            <a href="index.html" class="nav-link with-sub"><i class="typcn typcn-clipboard"></i>Dashboard</a>
            <ul class="nav-sub">
              <li class="nav-sub-item  {{ request()->is('dashboard') ? 'active' : ''}} "><a href="{{ route('dashboard') }}" class="nav-sub-link">Index</a></li>
              {{-- <li class="nav-sub-item active"><a href="dashboard-two.html" class="nav-sub-link">Sales Monitoring</a></li>
              <li class="nav-sub-item"><a href="dashboard-three.html" class="nav-sub-link">Ad Campaign</a></li> --}}
              {{-- <li class="nav-sub-item"><a href="dashboard-four.html" class="nav-sub-link">Event Management</a></li>
              <li class="nav-sub-item"><a href="dashboard-five.html" class="nav-sub-link">Helpdesk Management</a></li>
              <li class="nav-sub-item"><a href="dashboard-six.html" class="nav-sub-link">Finance Monitoring</a></li>
              <li class="nav-sub-item"><a href="dashboard-seven.html" class="nav-sub-link">Cryptocurrency</a></li>
              <li class="nav-sub-item"><a href="dashboard-eight.html" class="nav-sub-link">Executive / SaaS</a></li>
              <li class="nav-sub-item"><a href="dashboard-nine.html" class="nav-sub-link">Campaign Monitoring</a></li>
              <li class="nav-sub-item"><a href="dashboard-ten.html" class="nav-sub-link">Product Management</a></li> --}}
            </ul>
          </li><!-- nav-item -->
          <li class="nav-item 
          {{ request()->is('round_grid') ? 'active' : ''}}
          {{ request()->is('round_grid') ? 'show' : ''}}
          {{ request()->is('create_round') ? 'active' : ''}}
          {{ request()->is('create_round') ? 'show' : ''}}
          

          
          ">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-anchor"></i>Round</a>
            <ul class="nav-sub">
              <li class="nav-sub-item {{ request()->is('create_round') ? 'active' : ''}}">
                <a href="{{ route('create_round') }}" class="nav-sub-link">New Round</a>
              </li>
              <li class="nav-sub-item {{ request()->is('round_grid') ? 'active' : ''}}">
                <a href="{{ route('round_grid') }}" class="nav-sub-link">All Rounds</a>
              </li>
              {{-- <li class="nav-sub-item">
                <a href="app-calendar.html" class="nav-sub-link">Calendar</a>
              </li>
              <li class="nav-sub-item">
                <a href="app-contacts.html" class="nav-sub-link">Contacts</a>
              </li>
              <li class="nav-sub-item"><a href="page-profile.html" class="nav-sub-link">Profile</a></li>
              <li class="nav-sub-item"><a href="page-invoice.html" class="nav-sub-link">Invoice</a></li>
              <li class="nav-sub-item"><a href="page-signin.html" class="nav-sub-link">Sign In</a></li>
              <li class="nav-sub-item"><a href="page-signup.html" class="nav-sub-link">Sign Up</a></li>
              <li class="nav-sub-item"><a href="page-404.html" class="nav-sub-link">Page 404</a></li> --}}
            </ul>
          </li><!-- nav-item -->
          <li class="nav-item
          {{ request()->is('game_grid') ? 'active' : ''}}
          {{ request()->is('game_grid') ? 'show' : ''}}
          {{ request()->is('create_game') ? 'active' : ''}}
          {{ request()->is('create_game') ? 'show' : ''}}
          ">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i>Games</a>
            <ul class="nav-sub">
              <li class="nav-sub-item {{ request()->is('create_game') ? 'active' : ''}}"><a href="{{ route('create_game') }}" class="nav-sub-link">New Game</a></li>
              <li class="nav-sub-item  {{ request()->is('game_grid') ? 'active' : ''}}"><a href="{{ route('game_grid') }}" class="nav-sub-link">All Games</a></li>
              {{-- <li class="nav-sub-item"><a href="elem-avatar.html" class="nav-sub-link">Avatar</a></li>
              <li class="nav-sub-item"><a href="elem-badge.html" class="nav-sub-link">Badge</a></li>
              <li class="nav-sub-item"><a href="elem-breadcrumbs.html" class="nav-sub-link">Breadcrumbs</a></li>
              <li class="nav-sub-item"><a href="elem-buttons.html" class="nav-sub-link">Buttons</a></li>
              <li class="nav-sub-item"><a href="elem-cards.html" class="nav-sub-link">Cards</a></li>
              <li class="nav-sub-item"><a href="elem-carousel.html" class="nav-sub-link">Carousel</a></li>
              <li class="nav-sub-item"><a href="elem-collapse.html" class="nav-sub-link">Collapse</a></li>
              <li class="nav-sub-item"><a href="elem-dropdown.html" class="nav-sub-link">Dropdown</a></li>
              <li class="nav-sub-item"><a href="elem-icons.html" class="nav-sub-link">Icons</a></li>
              <li class="nav-sub-item"><a href="elem-images.html" class="nav-sub-link">Images</a></li>
              <li class="nav-sub-item"><a href="elem-list-group.html" class="nav-sub-link">List Group</a></li>
              <li class="nav-sub-item"><a href="elem-media-object.html" class="nav-sub-link">Media Object</a></li>
              <li class="nav-sub-item"><a href="elem-modals.html" class="nav-sub-link">Modals</a></li>
              <li class="nav-sub-item"><a href="elem-navigation.html" class="nav-sub-link">Navigation</a></li>
              <li class="nav-sub-item"><a href="elem-pagination.html" class="nav-sub-link">Pagination</a></li>
              <li class="nav-sub-item"><a href="elem-popover.html" class="nav-sub-link">Popover</a></li>
              <li class="nav-sub-item"><a href="elem-progress.html" class="nav-sub-link">Progress</a></li>
              <li class="nav-sub-item"><a href="elem-spinners.html" class="nav-sub-link">Spinners</a></li>
              <li class="nav-sub-item"><a href="elem-toast.html" class="nav-sub-link">Toast</a></li>
              <li class="nav-sub-item"><a href="elem-tooltip.html" class="nav-sub-link">Tooltip</a></li> --}}
            </ul>
          </li><!-- nav-item -->
          <li class="nav-item {{ request()->is('game_answers') ? 'active' : ''}} {{ request()->is('game_answers') ? 'show' : ''}}">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-edit"></i>Results</a>
            <ul class="nav-sub">
              <li class="nav-sub-item  {{ request()->is('game_answers') ? 'active' : ''}}"><a href="{{ route('game_answer_grid') }}" class="nav-sub-link">Add Results</a></li>
              {{-- <li class="nav-sub-item"><a href="form-layouts.html" class="nav-sub-link">Form Layouts</a></li>
              <li class="nav-sub-item"><a href="form-validation.html" class="nav-sub-link">Form Validation</a></li>
              <li class="nav-sub-item"><a href="form-wizards.html" class="nav-sub-link">Form Wizards</a></li>
              <li class="nav-sub-item"><a href="form-editor.html" class="nav-sub-link">WYSIWYG Editor</a></li> --}}
            </ul>
          </li><!-- nav-item -->
          <li class="nav-item">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-chart-bar-outline"></i>Users</a>
            <ul class="nav-sub">
              <li class="nav-sub-item"><a href="chart-morris.html" class="nav-sub-link">All Users</a></li>
              {{-- <li class="nav-sub-item"><a href="chart-flot.html" class="nav-sub-link">Flot Charts</a></li>
              <li class="nav-sub-item"><a href="chart-chartjs.html" class="nav-sub-link">ChartJS</a></li>
              <li class="nav-sub-item"><a href="chart-sparkline.html" class="nav-sub-link">Sparkline</a></li>
              <li class="nav-sub-item"><a href="chart-peity.html" class="nav-sub-link">Peity</a></li> --}}
            </ul>
          </li><!-- nav-item -->
          <li class="nav-item">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-map"></i>Agents</a>
            <ul class="nav-sub">
              <li class="nav-sub-item"><a href="map-google.html" class="nav-sub-link">New Agent</a></li>
              <li class="nav-sub-item"><a href="map-leaflet.html" class="nav-sub-link">All Agents</a></li>
              <li class="nav-sub-item"><a href="map-vector.html" class="nav-sub-link">Agent Comission</a></li>
            </ul>
          </li><!-- nav-item -->
          <li class="nav-item">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-tabs-outline"></i>Feed Back</a>
            <ul class="nav-sub">
              <li class="nav-sub-item"><a href="table-basic.html" class="nav-sub-link">Suggestions</a></li>
              <li class="nav-sub-item"><a href="table-data.html" class="nav-sub-link">Bug Reports</a></li>
              <li class="nav-sub-item"><a href="table-data.html" class="nav-sub-link">Questions</a></li>
            </ul>
          </li><!-- nav-item -->
          <li class="nav-item">
            <a href="" class="nav-link with-sub"><i class="typcn typcn-archive"></i>Utilities</a>
            <ul class="nav-sub">
              <li class="nav-sub-item"><a href="util-background.html" class="nav-sub-link">Background</a></li>
              <li class="nav-sub-item"><a href="util-border.html" class="nav-sub-link">Border</a></li>
              <li class="nav-sub-item"><a href="util-display.html" class="nav-sub-link">Display</a></li>
              <li class="nav-sub-item"><a href="util-flex.html" class="nav-sub-link">Flex</a></li>
              <li class="nav-sub-item"><a href="util-height.html" class="nav-sub-link">Height</a></li>
              <li class="nav-sub-item"><a href="util-margin.html" class="nav-sub-link">Margin</a></li>
              <li class="nav-sub-item"><a href="util-padding.html" class="nav-sub-link">Padding</a></li>
              <li class="nav-sub-item"><a href="util-position.html" class="nav-sub-link">Position</a></li>
              <li class="nav-sub-item"><a href="util-typography.html" class="nav-sub-link">Typography</a></li>
              <li class="nav-sub-item"><a href="util-width.html" class="nav-sub-link">Width</a></li>
              <li class="nav-sub-item"><a href="util-extras.html" class="nav-sub-link">Extras</a></li>
            </ul>
          </li><!-- nav-item -->
        </ul><!-- nav -->
      </div><!-- az-sidebar-body -->
    </div><!-- az-sidebar -->

    <div class="az-content az-content-dashboard-two">
