@extends('client.master')
@section('content')
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s">Live Auction</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Live Auction</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="live-auction-section pt-120 pb-120">
        <img alt="image" src="assets/images/bg/section-bg.png" class="img-fluid section-bg-top">
        <img alt="image" src="assets/images/bg/section-bg.png" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row gy-4 mb-60 d-flex justify-content-center">
                @foreach ($data as $auction)
                    @php
                        $imageUrl = public_path('image/imageProducts/user_' . $auction->user_id . '/product_' . $auction->product_id . '/' . $auction->product_image);
                        $defaultImagePath = 'image/imageProducts/no_image_available-product.png';
                        
                        if (!file_exists($imageUrl)) {
                            $imageUrl = asset($defaultImagePath);
                        } else {
                            $imageUrl = asset('image/imageProducts/user_' . $auction->user_id . '/product_' . $auction->product_id . '/' . urlencode($auction->product_image));
                        }
                        
                        $avatarUrl = 'image/imageUsers/user_' . $auction->user_id . '/' . $auction->avatar;
                        $defaultAvatarPath = 'image/imageUsers/default_avatar.jpg';
                        
                        if (!file_exists(public_path($avatarUrl))) {
                            $avatarUrl = asset($defaultAvatarPath);
                        } else {
                            $avatarUrl = asset(urlencode($avatarUrl));
                        }
                    @endphp
                    <div class="col-lg-4 col-md-6 col-sm-10 ">
                        <div data-wow-duration="1.5s" data-wow-delay="0.2s" class="eg-card auction-card1 wow fadeInDown">
                            <div class="auction-img">
                                <img alt="image" src="{{ $imageUrl }}">
                                <div class="auction-timer">
                                    <div class="countdown" id="timer1">
                                        <h4><span id="hours1">05</span>H : <span id="minutes1">52</span>M : <span
                                                id="seconds1">32</span>S</h4>
                                    </div>
                                </div>
                                <div class="author-area">
                                    <div class="author-emo">
                                        <img alt="image" src="{{ $avatarUrl }}">
                                    </div>
                                    <div class="author-name">
                                        <span>by {{ $auction->user_fullname }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="auction-content">
                                <h4><a
                                        href="{{ route('client.productDetails', ['id' => $auction->product_id]) }}">{{ $auction->product_name }}</a>
                                </h4>
                                <p>Bidding Price : <span>${{ $auction->buy_now }}</span></p>
                                <div class="auction-card-bttm">
                                    <a href="{{ route('client.productDetails', ['id' => $auction->product_id]) }}"
                                        class="eg-btn btn--primary btn--sm">Place a Bid</a>
                                    <div class="share-area">
                                        <ul class="social-icons d-flex">
                                            <li><a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a></li>
                                            <li><a href="https://www.twitter.com/"><i class="bx bxl-twitter"></i></a></li>
                                            <li><a href="https://www.pinterest.com/"><i class="bx bxl-pinterest"></i></a>
                                            </li>
                                            <li><a href="https://www.instagram.com/"><i class="bx bxl-instagram"></i></a>
                                            </li>
                                        </ul>
                                        <div>
                                            <a href="#" class="share-btn"><i class="bx bxs-share-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                {{-- <nav class="pagination-wrap">
                    <ul class="pagination d-flex justify-content-center gap-md-3 gap-2">
                        <li class="page-item">
                            <a class="page-link" href="#" tabindex="-1">Prev</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">01</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">02</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">03</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav> --}}
                {{ $data->Links('vendor.pagination.paginationcustom') }}
            </div>
        </div>
    </div>


    <div class="about-us-counter pb-120">
        <div class="container">
            <div class="row g-4 d-flex justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="counter-icon"> <img alt="image" src="assets/images/icons/employee.svg"> </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="5400">&nbsp;</h3>
                            <p>Happy Customer</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <div class="counter-icon"> <img alt="image" src="assets/images/icons/review.svg"> </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="1250">&nbsp;</h3>
                            <p>Good Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <div class="counter-icon"> <img alt="image" src="assets/images/icons/smily.svg"> </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="4250">&nbsp;</h3>
                            <p>Winner Customer</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".8s">
                        <div class="counter-icon"> <img alt="image" src="assets/images/icons/comment.svg"> </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="500">&nbsp;</h3>
                            <p>New Comments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
