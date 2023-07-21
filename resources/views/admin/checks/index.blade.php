@extends('admin.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">List check confirm</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-4 mb-3">
                            {{-- <div class="col-sm-auto">
                                <div>
                                    <button onclick="location.href='{{ route('product.create') }}'" type="button"
                                        class="btn btn-success add-btn add-btn-form" data-bs-toggle="modal" id="create-btn"
                                        data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i>
                                        Add</button>
                                    <a class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></a>
                                </div>
                            </div> --}}
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <form action="{{ route('product.search') }}" method="get">
                                            <input name="search" type="text" class="form-control search "
                                                placeholder="Search...">
                                            <i style="position: absolute;
                                                        top: 1px;
                                                        left: 13px;
                                                    }"
                                                class="ri-search-line search-icon"></i>
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
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="option1">
                                                </div>
                                            </th>
                                            <div class="col-12">
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">#VZ2101</a></td>
                                                <td class="product_name">
                                                    <span>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-3">
                                                                <div class="avatar-sm bg-light rounded p-1"><img
                                                                        src="{{ asset('image/imageProducts/user_' . $auction->user_id . '/' . 'product_' . $auction->product_id . '/' . $auction->product_image) }}"
                                                                        alt="" class="img-fluid d-block"></div>
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
                                                    @if ($auction->status === 1)
                                                        <span class="badge rounded-fill text-bg-primary">Pending
                                                            Confirmation</span>
                                                    @elseif ($auction->status === 2)
                                                        <span class="badge rounded-fill text-bg-success">Confirmed</span>
                                                    @endif
                                                </td>
                                                <td class="action"><span>
                                                        <div class="dropdown"><button
                                                                class="btn btn-soft-secondary btn-sm dropdown"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false"><i class="ri-more-fill"></i></button>
                                                            <ul class="dropdown-menu dropdown-menu-end" style="">

                                                                <li>
                                                                    <a href="{{ route('product.details', ['id' => $auction->product_id]) }}"
                                                                        class="dropdown-item">
                                                                        <i
                                                                            class="ri-view-fill align-bottom me-2 text-muted"></i>
                                                                        View
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="{{ route('product.changeStatus', ['id' => $auction->product_id]) }}"
                                                                        class="dropdown-item">
                                                                        <i
                                                                            class="ri-check-fill align-bottom me-2 text-muted"></i>
                                                                        Confirm
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('product.deleteListCheck', ['id' => $auction->product_id]) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="dropdown-item remove-list">
                                                                            <i
                                                                                class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                            delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </span></td>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if (count($data) == 0 && count($listCheck) == 0)
                                <div class="noresult" style="display: block">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
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


    <script></script>
@endsection
