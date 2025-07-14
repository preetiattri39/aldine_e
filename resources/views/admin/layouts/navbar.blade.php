<!-- partial:partials/_sidebar.html -->
<style>
.menu-arrow {
    transition: transform 0.3s ease;
}

.menu-arrow.rotate {
    transform: rotate(180deg);
}
</style>
 <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
      <a class="sidebar-brand brand-logo" href="{{route('admin.dashboard')}}">
        {{-- <img src="{{asset('admin/images/logo.svg')}}" alt="logo" /> --}}
        <h1 style="color:white">EDUPLAZ</h1>
      </a>
      <a class="sidebar-brand brand-logo-mini" href="{{route('admin.dashboard')}}"><img src="{{asset('admin/images/logo-mini.svg')}}" alt="logo" /></a>
    </div>
    <ul class="nav">
      <li class="nav-item profile">
        <div class="profile-desc">
          <a href="{{route('admin.profile')}}">
            <div class="profile-pic">
              <div class="count-indicator">
                <img class="img-xs rounded-circle" src = {{userImageById(authId())}} alt="User profile picture">
                <span class="count bg-success"></span>
              </div>
              <div class="profile-name">
                <h5 class="mb-0 font-weight-normal">{{UserNameById(authId())}}</h5>
              </div>
            </div>
          </a>
        </div>
      </li>

      <!-- Dashboard Link -->
      <li class="nav-item menu-items {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
            </span>
            <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <!-- Profile Link -->
      <li class="nav-item menu-items {{ request()->routeIs('admin.profile', 'admin.changePassword') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.profile', 'admin.changePassword') ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="{{ request()->routeIs('admin.profile', 'admin.changePassword') ? 'true' : 'false' }}" aria-controls="ui-basic">
            <span class="menu-icon">
                <i class="mdi mdi-settings"></i>
            </span>
            <span class="menu-title">Settings</span>
            <i class="menu-arrow mdi mdi-chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs('admin.profile', 'admin.changePassword') ? 'show' : '' }}" id="ui-basic" data-id="{{ request()->routeIs('admin.profile', 'admin.changePassword') ? 'true' : 'false' }}">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.changePassword') ? 'active' : '' }}" href="{{ route('admin.changePassword') }}">Change Password</a>
                </li>
            </ul>
        </div>
      </li>

      <!-- User Management Link -->
      <li class="nav-item menu-items {{ (request()->routeIs('admin.user.*') && !request()->routeIs('admin.user.trashed.list')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.user.list') }}">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">User Management</span>
        </a>
      </li>
      
       <!-- User Management Link -->
       <li class="nav-item menu-items {{ request()->routeIs('admin.user.trashed.list') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.user.trashed.list') }}">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Trashed User</span>
        </a>
      </li>

      <li class="nav-item menu-items {{ (request()->routeIs('admin.avatar*') && !request()->routeIs('admin.user.trashed.list')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.avatar.list') }}">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Avatar Management</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.newsletter.index') }}">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Newsletter Subscribers</span>
        </a>
      </li>
      
      <li class="nav-item menu-items {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.announcements.index') }}">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Announcements</span>
        </a>
      </li>

      <li class="nav-item menu-items {{ request()->routeIs('admin.category.*', 'admin.subcategory.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.category.list', 'admin.subcategory.list') ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#category-tab" aria-expanded="{{ request()->routeIs('admin.category.list', 'admin.subcategory.list') ? 'true' : 'false' }}" aria-controls="category-tab">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Subject</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ request()->routeIs('admin.category.list', 'admin.subcategory.list') ? 'show' : '' }}" id="category-tab" data-id="{{ request()->routeIs('admin.category.list', 'admin.subcategory.list') ? 'true' : 'false' }}">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.category.list') ? 'active' : '' }}" href="{{ route('admin.category.list') }}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.subcategory.list') ? 'active' : '' }}" href="{{ route('admin.subcategory.list') }}">SubCategories</a>
                </li>
            </ul>
        </div>
      </li>

       {{-- <li class="nav-item menu-items {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.category.list') }}">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Subject</span>
        </a>
      </li> --}}

       <li class="nav-item menu-items {{ request()->routeIs('admin.language.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.language.list') }}">
            <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
            </span>
            <span class="menu-title">Language</span>
        </a>
      </li>
      
   
      <!-- Notification Management Link -->
      <li class="nav-item menu-items {{ request()->routeIs('admin.notification.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.notification.list')}}">
            <span class="menu-icon">
                <i class="mdi mdi-bell"></i>
            </span>
            <span class="menu-title">Notifications</span>
        </a>
      </li>
      
      <!-- Content Pages Link -->
      <li class="nav-item menu-items {{ request()->routeIs('admin.contentPages.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.contentPages.*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#auth3" aria-expanded="{{ request()->routeIs('admin.card.*', 'admin.category.*') ? 'true' : 'false' }}" aria-controls="auth3">
            <span class="menu-icon">
                <i class="mdi mdi-content-save"></i>
            </span>
            <span class="menu-title">Content Pages</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ request()->routeIs('admin.contentPages.*','admin.f-a-q.*') ? 'show' : '' }}" id="auth3">
          @php
            $currentSlug = request()->route('slug');
            $isActive = function($slug) use ($currentSlug) {
                return $currentSlug === $slug;
            };
        @endphp
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('about-us') ? 'active' : '' }}" href="{{ route('admin.contentPages.detail',['slug' => 'about-us']) }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('privacy-and-policy') ? 'active' : '' }}" href="{{ route('admin.contentPages.detail',['slug' => 'privacy-and-policy']) }}">Privacy And Policy</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ $isActive('terms-and-conditions') ? 'active' : '' }}" href="{{ route('admin.contentPages.detail',['slug' => 'terms-and-conditions']) }}">Terms And Conditions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ $isActive('delete-account-steps') ? 'active' : '' }}" href="{{ route('admin.contentPages.detail',['slug' => 'delete-account-steps']) }}">Delete Account Steps</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{request()->routeIs('admin.f-a-q.*') ? 'active' : ''}}" href="{{ route('admin.f-a-q.list')}}">FAQ</a>
                </li>
            </ul>
        </div>
      </li>
      <!-- Helpdesk Link -->
      {{--<li class="nav-item menu-items {{ request()->routeIs('admin.helpDesk.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.helpDesk.list',['type' => 'open']) }}">
            <span class="menu-icon">
                <i class="mdi mdi-desktop-mac"></i>
            </span>
            <span class="menu-title">Helpdesk</span>
        </a>
      </li>--}}
       <li class="nav-item menu-items {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.contact.list') }}">
            <span class="menu-icon">
                <i class="mdi mdi-desktop-mac"></i>
            </span>
            <span class="menu-title">Contact us</span>
        </a>
      </li>

      <!-- Config setting Link -->
      <li class="nav-item menu-items {{ request()->routeIs('admin.config-setting.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.config-setting.*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#auth1" aria-expanded="{{ request()->routeIs('admin.config-setting.*') ? 'true' : 'false' }}" aria-controls="auth1">
            <span class="menu-icon">
                <i class="mdi mdi-settings"></i>
            </span>
            <span class="menu-title">Config Setting</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ request()->routeIs('admin.config-setting.*') ? 'show' : '' }}" id="auth1">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.config-setting.smtp') ? 'active' : '' }}" href="{{ route('admin.config-setting.smtp') }}">SMTP Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.config-setting.config') ? 'active' : '' }}" href="{{ route('admin.config-setting.config') }}">Social Information</a>
                </li>
              
                
            </ul>
        </div>
      </li>

      <!-- Log Out Link -->
      <li class="nav-item menu-items">
        <a class="nav-link" href="{{route('admin.logout')}}">
          <span class="menu-icon">
            <i class="mdi mdi-logout"></i>
          </span>
          <span class="menu-title">Log Out</span>
        </a>
      </li>
    </ul>
  </nav>
  <!-- partial -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function () {
    $('.nav-link').on('click', function () {
    const $arrow = $(this).find('.menu-arrow');
    
    // Defer checking the class after Bootstrap processes the collapse toggle
    setTimeout(() => {
        if ($(this).hasClass('collapsed')) {
          $arrow.removeClass('rotate');
        } else {
          $arrow.addClass('rotate');
        }
      }, 10); // 10ms delay ensures Bootstrap has updated the class
    });
      
       @if(request()->routeIs('admin.profile', 'admin.changePassword'))
       $('#ui-basic').collapse('show');
       $('#ui-basic').prev('.nav-link').find('.menu-arrow').addClass('rotate');
      @endif
  });
  </script>
