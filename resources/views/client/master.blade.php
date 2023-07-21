<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from demo.egenslab.com/html/bidout/preview/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 May 2023 01:54:11 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidout - Auction and Bidding HTML Template</title>
    @yield('css')
    @include('client.style.css')

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>

    {{-- <div class="preloader">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div> --}}



    <div class="mobile-search">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-11">
                    <label>What are you lookking for?</label>
                    <input type="text" placeholder="Search Products, Category, Brand">
                </div>
                <div class="col-1 d-flex justify-content-end align-items-center">
                    <div class="search-cross-btn">

                        <i class="bi bi-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="topbar">
        <div class="topbar-left d-flex flex-row align-items-center">
            <h6>Follow Us</h6>
            <ul class="topbar-social-list gap-2">
                <li><a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a></li>
                <li><a href="https://www.twitter.com/"><i class="bx bxl-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="bx bxl-instagram"></i></a></li>
                <li><a href="https://www.pinterest.com/"><i class="bx bxl-pinterest-alt"></i></a></li>
            </ul>
        </div>
        <div class="email-area">
            <h6>Email: <a
                    href="https://demo.egenslab.com/cdn-cgi/l/email-protection#375458594356544377524f565a475b521954585a"><span
                        class="__cf_email__"
                        data-cfemail="4d2e2223392c2e390d28352c203d2128632e2220">[email&#160;protected]</span></a></h6>
        </div>
        <div class="topbar-right">
            <ul class="topbar-right-list">
                <li><span>Language</span><img src="assets/images/icons/flag-eng.png" alt="image">
                    <ul class="topbar-sublist">
                        <li><span>Germeny</span><img src="assets/images/icons/flag-germeny.svg" alt="image"></li>
                        <li> <span>French</span><img src="assets/images/icons/flag-french.svg" alt="image"></li>
                        <li><span>Bengali</span><img src="assets/images/icons/flag-bangla.svg" alt="image"></li>
                    </ul>
                </li>
                <li>Currency
                    <ul class="topbar-sublist">
                        <li><a href="login.html"><i class="bi bi-currency-dollar"></i>Usd</a></li>
                        <li><a href="register.html"><i class="bi bi-currency-euro"></i>Euro</a></li>
                        <li><a href="register.html"><i class="bi bi-currency-pound"></i>Pound</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div> --}}

    @include('client.header.header')




    @yield('content')





    @include('client.footer.footer')
    @include('client.js.script')
    @yield('js')
</body>

<!-- Mirrored from demo.egenslab.com/html/bidout/preview/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 May 2023 01:54:48 GMT -->

</html>
