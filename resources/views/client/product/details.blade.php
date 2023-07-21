@extends('client.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s">
                Auction Details
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Auction Details
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="auction-details-section pt-120">
        <img alt="image" src={{ asset('client/assets/images/bg/section-bg.png') }} class="img-fluid section-bg-top" />
        <img alt="image" src={{ asset('client/assets/images/bg/section-bg.png') }} class="img-fluid section-bg-bottom" />
        <div class="container">
            <div class="row g-4 mb-50">
                <div
                    class="col-xl-6 col-lg-7 d-flex flex-row align-items-start justify-content-lg-start justify-content-center flex-md-nowrap flex-wrap gap-4">
                    <ul class="nav small-image-list d-flex flex-md-column flex-row justify-content-center gap-4 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">

                        @php
                            $list_image = json_decode($data->listImage);
                            $imageUrlPrefix = 'image/imageProducts/user_' . $data->user_id . '/product_' . $data->product_id . '/';
                            $DefaultUrlPrefix = 'image/imageProducts/';
                            
                            if (!$list_image) {
                                $list_image = ['no_image_available-product.png', 'no_image_available-product.png', 'no_image_available-product.png'];
                            } else {
                                while (count($list_image) < 3) {
                                    $list_image[] = 'no_image_available-product.png';
                                }
                            }
                            
                        @endphp
                        @foreach ($list_image as $index => $image)
                            @php
                                $imageUrl = $image == 'no_image_available-product.png' ? asset($DefaultUrlPrefix . $image) : asset($imageUrlPrefix . urlencode($image));
                            @endphp
                            <li class="nav-item">
                                <div id="details-img{{ $index }}" data-bs-toggle="pill"
                                    data-bs-target="#gallery-img{{ $index }}"
                                    aria-controls="gallery-img{{ $index }}">
                                    <img alt="image" src="{{ $imageUrl }}" class="img-fluid" />
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mb-4 d-flex justify-content-lg-start justify-content-center wow fadeInUp"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        @foreach ($list_image as $index => $image)
                            @php
                                $imageUrl = $image == 'no_image_available-product.png' ? asset($DefaultUrlPrefix . $image) : asset($imageUrlPrefix . urlencode($image));
                            @endphp
                            <div class="tab-pane big-image fade {{ $index == 0 ? 'show active' : '' }}"
                                id="gallery-img{{ $index }}">
                                <div
                                    class="auction-gallery-timer d-flex align-items-center justify-content-center flex-wrap">
                                    <div class="bid-countDown text-white" data-startTime="{{ $data->start_time }}"
                                        data-endTime="{{ $data->end_time }}"></div>
                                </div>
                                <img alt="image" src="{{ $imageUrl }}" class="img-fluid" />
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="col-xl-6 col-lg-5">
                    <div class="product-details-right wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <h3>{{ $data->product_name }}</h3>
                        <p class="para">
                            {{ $data->product_description }}
                        </p>
                        <h4>Bidding Price: <span>${{ $data->buy_now }}</span></h4>
                        <h4>Current Price:
                            <span>${{ $data->current_price ? $data->current_price : $data->starting_price }}</span>
                        </h4>
                        <div class="bid-form">
                            <div class="form-title">
                                @php
                                    $minimumBid = $data->current_price ? $data->current_price * 1.1 : $data->starting_price * 1.1;
                                @endphp

                                <h5>Bid Now</h5>
                                <p>Bid Amount : Minimum Bid ${{ $minimumBid }}</p>
                            </div>

                            <form class="bids" action="{{ route('client.bid', ['id' => $data->product_id]) }}"
                                method="post">
                                @csrf
                                @if ($data->user_id === Auth::User()->id || $data->is_admin === 1)
                                    <div class="form-inner gap-2">
                                        <input name="minimum_bid" type="hidden" value="{{ $minimumBid }}">
                                        <input class="form-control bid_amount" type="number" name="bid_amount" placeholder="$00.00"
                                            disabled />
                                        <button class="eg-btn btn--primary btn--sm" type="submit" disabled>
                                            Place Bid
                                        </button>
                                    </div>
                                

                                @else
                                    <div class="form-inner gap-2">
                                        <input name="minimum_bid" type="hidden" value="{{ $minimumBid }}">
                                        <input class="form-control bid_amount" type="number" name="bid_amount" placeholder="$00.00" />
                                        <button class="eg-btn btn--primary btn--sm" type="submit">
                                            Place Bid
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center g-4">
                <div class="col-lg-8">
                    <ul class="nav nav-pills d-flex flex-row justify-content-start gap-sm-4 gap-3 mb-45 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".2s" id="pills-tab" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link active details-tab-btn" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                Description
                            </button>
                        </li> --}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link details-tab-btn" id="pills-bid-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-bid" type="button" role="tab" aria-controls="pills-bid"
                                aria-selected="false">
                                Biding History
                            </button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link details-tab-btn" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab"
                                aria-controls="pills-contact" aria-selected="false">
                                Other Auction
                            </button>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s"
                            id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="describe-content">
                                <p class="para">
                                    {{ $data->description }}
                                </p>


                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-bid" role="tabpanel" aria-labelledby="pills-bid-tab">
                            <div class="bid-list-area">


                                <ul class="bid-list">
                                    @if (count($list_bid) > 0)
                                        @foreach ($list_bid as $bid)
                                            @php
                                                $imagePath = 'image/imageUsers/user_' . $bid->user_id . '/' . $bid->avatar;
                                                $defaultImagePath = 'image/imageUsers/default_avatar.jpg';
                                                // Kiểm tra xem tệp tin có tồn tại trong thư mục "user_" hay không
                                                $imageUrl = asset($imagePath);
                                                if (!file_exists(public_path($imagePath))) {
                                                    $imageUrl = asset($defaultImagePath);
                                                }
                                                
                                                $createdTime = $bid->created_at; // Tạo ra thời gian
                                                $timeAgo = \App\Helpers\TimeHelpers::getTimeAgo($createdTime);
                                            @endphp
                                            <style>
                                                .bidder-img {
                                                    width: 50px;
                                                    height: 50px;
                                                }
                                            </style>
                                            <li>
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-7">
                                                        <div class="bidder-area">
                                                            <div class="bidder-img">
                                                                <img alt="image" src="{{ $imageUrl }}"
                                                                    class="image-user w-50 h-50" />
                                                            </div>
                                                            <div class="bidder-content">
                                                                <a href="#">
                                                                    <h6>{{ $bid->name }}</h6>
                                                                </a>
                                                                <p>${{ $bid->amount }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-5 text-end">
                                                        <div class="bid-time">
                                                            <p>{{ $timeAgo }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <p>Không có dữ liệu đấu giá.</p>
                                    @endif
                                </ul>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="row d-flex justify-content-center g-4">
                                <div class="col-lg-6 col-md-4 col-sm-10">
                                    <div class="eg-card auction-card1">
                                        <div class="auction-img">
                                            <img alt="image"
                                                src={{ asset('client/assets/images/bg/live-auc1.png') }} />
                                            <div class="auction-timer">
                                                <div class="bid-countdown" id="timer1">

                                                </div>
                                            </div>
                                            <div class="author-area">
                                                <div class="author-emo">
                                                    <img alt="image"
                                                        src={{ asset('client/assets/images/icons/smile-emo.svg') }} />
                                                </div>
                                                <div class="author-name">
                                                    <span>by @robatfox</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="auction-content">
                                            <h4>
                                                <a href="auction-details.html">Brand New royal Enfield 250 CC For Sale</a>
                                            </h4>
                                            <p>Bidding Price : <span>$85.9</span></p>
                                            <div class="auction-card-bttm">
                                                <a href="auction-details.html" class="eg-btn btn--primary btn--sm">Place a
                                                    Bid</a>
                                                <div class="share-area">
                                                    <ul class="social-icons d-flex">
                                                        <li>
                                                            <a href="https://www.facebook.com/"><i
                                                                    class="bx bxl-facebook"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.twitter.com/"><i
                                                                    class="bx bxl-twitter"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.pinterest.com/"><i
                                                                    class="bx bxl-pinterest"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.instagram.com/"><i
                                                                    class="bx bxl-instagram"></i></a>
                                                        </li>
                                                    </ul>
                                                    <div>
                                                        <a href="#" class="share-btn"><i
                                                                class="bx bxs-share-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-10">
                                    <div class="eg-card auction-card1 wow fadeInDown">
                                        <div class="auction-img">
                                            <img alt="image"
                                                src={{ asset('client/assets/images/bg/live-auc2.png') }} />
                                            <div class="auction-timer">
                                                <div class="countdown" id="timer2">
                                                    <h4>
                                                        <span id="hours2">05</span>H :
                                                        <span id="minutes2">52</span>M :
                                                        <span id="seconds2">32</span>S
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="author-area">
                                                <div class="author-emo">
                                                    <img alt="image"
                                                        src={{ asset('client/assets/images/icons/smile-emo.svg') }} />
                                                </div>
                                                <div class="author-name">
                                                    <span>by @robatfox</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="auction-content">
                                            <h4>
                                                <a href="auction-details.html">Wedding Special Exclusive Cupple Ring
                                                    (S2022)</a>
                                            </h4>
                                            <p>Bidding Price : <span>$85.9</span></p>
                                            <div class="auction-card-bttm">
                                                <a href="auction-details.html" class="eg-btn btn--primary btn--sm">Place a
                                                    Bid</a>
                                                <div class="share-area">
                                                    <ul class="social-icons d-flex">
                                                        <li>
                                                            <a href="https://www.facebook.com/"><i
                                                                    class="bx bxl-facebook"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.twitter.com/"><i
                                                                    class="bx bxl-twitter"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.pinterest.com/"><i
                                                                    class="bx bxl-pinterest"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="https://www.instagram.com/"><i
                                                                    class="bx bxl-instagram"></i></a>
                                                        </li>
                                                    </ul>
                                                    <div>
                                                        <a href="#" class="share-btn"><i
                                                                class="bx bxs-share-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-banner wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="1s">
                            <div class="banner-content">
                                <span>CARS</span>
                                <h3>Toyota AIGID A Clasis Cars Sale</h3>
                                <a href="auction-details.html" class="eg-btn btn--primary card--btn">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="about-us-counter pt-120 pb-120">
        <div class="container">
            <div class="row g-4 d-flex justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="counter-icon">
                            <img alt="image" src={{route('client/assets/images/icons/employee.svg')}} />
                        </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="5400">&nbsp;</h3>
                            <p>Happy Customer</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <div class="counter-icon">
                            <img alt="image" src={{route('client/assets/images/icons/review.svg')}} />
                        </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="1250">&nbsp;</h3>
                            <p>Good Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".4s">
                        <div class="counter-icon">
                            <img alt="image" src={{route('client/assets/images/icons/smily.svg')}} />
                        </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="4250">&nbsp;</h3>
                            <p>Winner Customer</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".8s">
                        <div class="counter-icon">
                            <img alt="image" src={{route('client/assets/images/icons/comment.svg')}} />
                        </div>
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="500">&nbsp;</h3>
                            <p>New Comments</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <script>
        // const countDown = document.querySelectorAll('.bid-countDown');
        // countDown.forEach(element => {
        //     let startTimeString = element.dataset.starttime;
        //     let endTimeString = element.dataset.endtime;

        //     // let startTime = new Date(startTimeString).getTime();
        //     let endTime = new Date(endTimeString).getTime();

        //     let countDown = setInterval(() => {
        //         var now = new Date().getTime();

        //         let timeLeft = endTime - now;

        //         let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        //         let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //         let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        //         let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);


        //         element.innerHTML = days + "d " + hours + "h " +
        //             minutes + "m " + seconds + "s ";


        //         if (timeLeft < 0) {
        //             clearInterval(countDown);
        //         }

        //     })
        // }, 1000);


        const countDownElements = document.querySelectorAll('.bid-countDown');
        let inputAmount = document.querySelector('.bid_amount');
        if (countDownElements) {
            countDownElements.forEach((countDownElement) => {
                let startTimeString = countDownElement.dataset.starttime;
                let endTimeString = countDownElement.dataset.endtime;

                let startTime = new Date(startTimeString).getTime();
                let endTime = new Date(endTimeString).getTime();
                let idProduct = "<?php echo $data->product_id; ?>";
                let url = "{{ route('client.changeStatus', ['id' => ':id']) }}";
                url = url.replace(':id', idProduct);
                if (new Date().getTime() >= startTime) {
                    let countDown = setInterval(() => {
                        let currentTime = new Date().getTime();
                        let timeLeft = endTime - currentTime;
                        if (timeLeft < 0) {
                            clearInterval(countDown);
                            countDownElement.innerHTML = 'Auction Ended';
                            inputAmount.setAttribute('disabled','');
                            $.ajax({
                                url: url,
                                method: 'get',
                                success: function(res) {
                                    console.log(res);
                                },
                                error: function(xhr, status, error) {
                                    console.log(error);
                                }
                            });
                        } else {
                            let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                            let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                            let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                            countDownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " +
                                seconds + "s ";
                        }
                    }, 1000);
                }
            });
        }




        // bid 
        const formBid = document.querySelector('form.bids');
        formBid.addEventListener('submit', function(event) {
            event.preventDefault();
            let form = event.target;
            let url = form.action;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let formData = $(this).serialize();
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                success: function(res) {
                    let id = url.split('productDetails/')[1];
                    let dynamicUrl = "{{ route('client.productDetails', ['id' => ':id']) }}";
                    dynamicUrl = dynamicUrl.replace(':id', id);

                    if (res.success) {

                        location.reload();

                        // Show the success message after the page has reloaded

                    }
                    if (res.error) {
                        toastr.error(res.error, 'Error');
                    }




                },
                error: function(xhr, status, error) {
                    toastr.error(error);
                }
            })
        })
    </script>
@endsection
