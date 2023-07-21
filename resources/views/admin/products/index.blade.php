    @extends('admin.master')
    @section('css')
        @parent
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">List product</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div>
                                        <button onclick="location.href='{{ route('product.create') }}'" type="button"
                                            class="btn btn-success add-btn add-btn-form" data-bs-toggle="modal"
                                            id="create-btn" data-bs-target="#showModal"><i
                                                class="ri-add-line align-bottom me-1"></i>
                                            Add</button>
                                        {{-- <a class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                                class="ri-delete-bin-2-line"></i></a> --}}
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="d-flex justify-content-sm-end">
                                        <div class="ms-2">
                                            <form class="d-flex justify-content-between"
                                                action="{{ route('product.search') }}" method="get">
                                                <div class="me-2">
                                                    <select name="category" id="category" class="form-control">
                                                        <option value="">Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ old('category', session('selected_category')) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="me-2">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="">Status</option>
                                                        <option value="2"
                                                            {{ old('status', session('selected_status')) == 2 ? 'selected' : '' }}>
                                                            Confirmed</option>
                                                        <option value="3"
                                                            {{ old('status', session('selected_status')) == 3 ? 'selected' : '' }}>
                                                            In progress</option>
                                                        <option value="4"
                                                            {{ old('status', session('selected_status')) == 4 ? 'selected' : '' }}>
                                                            Auction ended</option>
                                                    </select>
                                                </div>
                                                <div class="me-2 position-relative">
                                                    <input class="form-control" type="text" name="search" id="search"
                                                        placeholder="Tìm kiếm..." autocomplete="off">
                                                    <ul
                                                        class="list-group list-group-numbered live-search position-absolute">
                                                    </ul>
                                                </div>
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-success text-center custom-btn form-control">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive table-card mt-3 mb-1">
                                <table class="table align-middle table-nowrap" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                        value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="product_name">Name product</th>
                                            <th class="sort" data-sort="Customer">Customer</th>
                                            <th class="sort" data-sort="datetime">Joining Date</th>
                                            <th class="sort" data-sort="status">Status</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                            @foreach ($data as $auction)
                                            @if($auction->status != 1)
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="chk_child" value="option1">
                                                            </div>
                                                        </th>
                                                        <div class="col-12">
                                                            <td class="id" style="display:none;"><a
                                                                    href="javascript:void(0);"
                                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                                            <td class="product_name">
                                                                <span>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-3">
                                                                            <div class="avatar-sm bg-light rounded p-1">

                                                                                @php
                                                                                    $imageUrl = public_path('image/imageProducts/user_' . $auction->user_id . '/product_' . $auction->product_id . '/' . $auction->product_image);
                                                                                    $defaultImagePath = 'image/imageProducts/no_image_available-product.png';
                                                                                    
                                                                                    if (!file_exists($imageUrl)) {
                                                                                        $imageUrl = asset($defaultImagePath);
                                                                                    } else {
                                                                                        $imageUrl = asset('image/imageProducts/user_' . $auction->user_id . '/product_' . $auction->product_id . '/' . urlencode($auction->product_image));
                                                                                    }
                                                                                @endphp
                                                                                <img src={{ $imageUrl }} alt=""
                                                                                    class="img-fluid d-block">
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="fs-14 mb-1"><a
                                                                                    href="apps-ecommerce-product-details.html"
                                                                                    class="text-dark">{{ $auction->product_name }}</a>
                                                                            </h5>
                                                                            <p class="text-muted mb-0">Category : <span
                                                                                    class="fw-medium">{{ $auction->category_name }}</span>
                                                                            </p>
                                                                        </div>

                                                                    </div>
                                                                </span>
                                                            </td>


                                                            <td class="Customer">
                                                                {{ $auction->user_fullname }}
                                                            </td>

                                                            <td class="Datetime">
                                                                {{ \Illuminate\Support\Carbon::parse($auction->created_at)->toDateTimeString() }}
                                                            </td>


                                                            <td class="status">
                                                                @if ($auction->status === 2)
                                                                    <a class="badge rounded-fill text-bg-danger"
                                                                        href="{{ route('product.changeStatus', ['id' => $auction->product_id]) }}">Confirmed</a>
                                                                @elseif ($auction->status === 3)
                                                                    <a class="badge rounded-fill text-bg-danger"
                                                                        href="{{ route('product.changeStatus', ['id' => $auction->product_id]) }}">In
                                                                        progress</a>
                                                                @elseif($auction->status === 4)
                                                                    <span
                                                                        class="badge rounded-fill text-bg-success">Auction
                                                                        ended</span>
                                                                @endif
                                                            </td>
                                                            <td class="action"><span>
                                                                    <div class="dropdown"><button
                                                                            class="btn btn-soft-secondary btn-sm dropdown"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false"><i
                                                                                class="ri-more-fill"></i></button>
                                                                        <ul class="dropdown-menu dropdown-menu-end"
                                                                            style="">
                                                                            <li><a class="dropdown-item"
                                                                                    href="{{ route('product.details', ['id' => $auction->product_id]) }}"><i
                                                                                        class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                                    View</a></li>
                                                                            <li><a class="dropdown-item edit-list"
                                                                                    href="{{ route('product.edit', ['id' => $auction->product_id]) }}"><i
                                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                                    Edit</a></li>
                                                                            <li class="dropdown-divider"></li>
                                                                            {{-- <li><a class="dropdown-item remove-list"
                                                                                    href="{{ route('product.destroy', ['id' => $auction->product_id]) }}"><i
                                                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                                    Delete</a></li> --}}
                                                                        </ul>
                                                                    </div>
                                                                </span></td>
                                                        </div>
                                                    </tr>
                                            @endif
                                            @endforeach
                                        
                                    </tbody>
                                </table>
                                @if (count($data) === 0)
                                    <div class="noresult" style="display: block">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                            </lord-icon>
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                            <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find
                                                any
                                                orders
                                                for you search.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{ $data->links() }}
                        </div>
                    </div><!-- end card -->
                </div>
                <!-- end col -->
            </div>
        </div>
        <script>
            let searchTimer;
            $(document).ready(function() {
                $('body').on('keyup', '#search', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(function() {
                        let live_search = $('#search').val();
                        $.ajax({
                            url: "{{ route('product.search') }}",
                            type: 'get',
                            data: {
                                "liveSearch": live_search
                            },
                            datatype: 'json',
                            success: function(data) {
                                if (data.data) {
                                    $result = '';

                                    console.log(data.data)
                                    data.data.forEach(auction => {
                                        $result += '<li class="list-group-item">';
                                        $result += '<a href="#">' + auction
                                            .product_name +
                                            '</a>';
                                        $result += '</li>';
                                    });
                                    $('.live-search').empty().html($result);
                                } else {
                                    $('.live-search').empty().html();
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    }, 500);
                });
            });
        </script>
    @endsection

    @section('script')
        @parent
        <!-- prismjs plugin -->
        <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>

        <script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
        <script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
        <!-- end prismjs plugin -->

        <!-- listjs init -->
        <script src="{{ asset('assets/js/pages/listjs.init.js') }}"></script>
        <!-- end listjs init -->

        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    @endsection
