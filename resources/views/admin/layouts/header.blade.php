<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
      <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('admin/images/logo-mini.svg')}}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
      <ul class="navbar-nav navbar-nav-right">
        @php
            $notification_count = auth()->user()->unreadNotifications()->count();
        @endphp
        <li class="nav-item dropdown border-left">
            <a class="nav-link count-indicator read-notification" id="notificationDropdown" href="{{route('admin.notification.list')}}">
                <i class="mdi mdi-bell"></i>
                @if ($notification_count)
                  <span class="count bg-danger"></span>
                @endif
            </a>
            @if($notification_count)
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  @foreach (auth()->user()->unreadNotifications()->take(5)->get() as $notification)
                      <div class="dropdown-divider m-0"></div>
                      <a href="{{route('admin.notification.list')}}">
                        <p class="preview-subject p-3 mb-0">{{($notification->data)['description']}}</p>
                      </a>
                  @endforeach
                  @if(auth()->user()->unreadNotifications()->count() > 5)
                        <div class="dropdown-divider"></div>
                        <a href="{{route('admin.notification.list')}}">
                          <p class="p-3 mb-0 text-center">See all notifications</p>
                        </a>
                  @endif
              </div>
            @endif
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
            <div class="navbar-profile">

              <img class="img-xs rounded-circle" src={{userImageById(authId())}} alt="User profile picture">
              
              <p class="mb-0 d-none d-sm-block navbar-profile-name">{{UserNameById(authId(  ))}}</p>
              <i class="mdi mdi-menu-down d-none d-sm-block"></i>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
            {{-- <h6 class="p-3 mb-0">Profile</h6> --}}
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item" href="{{route('admin.profile')}}">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-account text-success"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject mb-1">Profile</p>
                </div>
            </a>
            {{-- <a class="dropdown-item preview-item" href="{{route('admin.helpDesk.list',['type' => 'open'])}}">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-desktop-mac text-success"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject mb-1">Helpdesk</p>
                </div>
            </a> --}}
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item" href="{{route('admin.logout')}}">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-dark rounded-circle">
                  <i class="mdi mdi-logout text-danger"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <p class="preview-subject mb-1">Log out</p>
              </div>
            </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-format-line-spacing"></span>
      </button>
    </div>
  </nav>
  <!-- partial -->