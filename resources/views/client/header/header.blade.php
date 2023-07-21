<header class="header-area style-1">
    <div class="header-logo">
        <a href="{{ route('client.index') }}"><img alt="image"
                src="{{ asset('client/assets/images/bg/header-logo.png') }}"></a>
    </div>
    <div class="main-menu">
        <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
            <div class="mobile-logo-wrap ">
                <a href="{{ route('client.index') }}"><img alt="image"
                        src="{{ asset('client/assets/images/bg/header-logo.png') }}"></a>
            </div>
            <div class="menu-close-btn">
                <i class="bi bi-x-lg"></i>
            </div>
        </div>
        <ul class="menu-list">
            <li class="menu-item-has-children home">
                <a href="{{ route('client.index') }}" class="drop-down">Home</a>
            </li>
            <li>
                <a href="{{ route('client.aboutus') }}">About Us</a>
            </li>
            <li>
                <a href="{{ route('client.howwork') }}">How It Works</a>
            </li>
            <li>
                <a href="{{route('client.auction')}}">Browse Product</a>
            </li>
            {{-- <li class="menu-item-has-children">
                <a href="#">News</a><i class="bx bx-plus dropdown-icon"></i>
                <ul class="submenu">
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="blog-details.html">Blog Details</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children">
                <a href="#" class="drop-down">Pages</a><i class="bx bx-plus dropdown-icon"></i>
                <ul class="submenu">
                    <li><a href="auction-details.html">Auction Details</a></li>
                    <li><a href="faq.html">Faq</a></li>
                    <li><a href="dashboard.html">Dashboard</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="signup.html">Sign Up</a></li>
                    <li><a href="404.html">404</a></li>
                </ul>
            </li> --}}
            {{-- <li><a href="contact.html">Contact</a></li> --}}
        </ul>

        <div class="d-lg-none d-block">
            <form class="mobile-menu-form mb-5">
                <div class="input-with-btn d-flex flex-column">
                    <input type="text" placeholder="Search here...">
                    <button type="submit" class="eg-btn btn--primary btn--sm">Search</button>
                </div>
            </form>
            <div class="hotline two">
                <div class="hotline-info">
                    <span>Click To Call</span>
                    <h6><a href="tel:347-274-8816">+347-274-8816</a></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-right d-flex align-items-center">
        <div class="hotline d-xxl-flex d-none">
            <div class="hotline-icon">
                <img alt="image" src="{{ asset('client/assets/images/icons/header-phone.svg') }}">
            </div>
            <div class="hotline-info">
                <span>Click To Call</span>
                <h6><a href="tel:347-274-8816">+347-274-8816</a></h6>
            </div>
        </div>
        <div class="search-btn">
            <i class="bi bi-search"></i>
        </div>
        <div class="eg-btn btn--primary header-btn">
            @if (auth()->check())
                <div class="dropdown-center">
                    <a class="dropdown-toggle"  href="{{ route('client.dashboard', ['id' => auth()->user()->id]) }}">My Account</a>
                    <ul class="dropdown-menu">
                        <li><span class="dropdown-item" ><span>Balance</span> ${{$user_login->balance}}</span></li>
                    </ul>
                </div>
            @else
                <a href="{{ route('client.login') }}">Login</a>
            @endif
        </div>
        <div class="mobile-menu-btn d-lg-none d-block">
            <i class="bx bx-menu"></i>
        </div>
    </div>
</header>
