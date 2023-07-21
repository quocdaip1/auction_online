@extends('admin.master')
@section('css')
    @parent
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
@endsection


@section('content')
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">List categories</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal"><i
                                            class="ri-add-line align-bottom me-1"></i> Add</button>

                                    {{-- <a class="btn btn-soft-danger" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></a> --}}



                                </div>
                            </div>


                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="ms-2">
                                        <form class="d-flex justify-content-between" action="{{ route('category.search') }}"
                                            method="get">

                                            <div class="me-2">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="">Status</option>
                                                    <option value="1"
                                                        {{ old('status', session('selected_status')) == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="2"
                                                        {{ old('status', session('selected_status')) == 2 ? 'selected' : '' }}>
                                                        Block</option>
                                                </select>
                                            </div>
                                            <div class="me-2 position-relative">
                                                <input class="form-control" type="text" name="search" id="search"
                                                    placeholder="Tìm kiếm..." autocomplete="off">
                                                <ul class="list-group list-group-numbered live-search position-absolute">
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
                                        <th class="sort" data-sort="name_category">Name</th>
                                        <th class="sort" data-sort="Customer name">Customer name</th>
                                        <th class="sort" data-sort="Total_products">Total products</th>
                                        <th class="sort" data-sort="Time_created">Time created</th>
                                        <th class="sort" data-sort="status">Status</th>
                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <div id="loading-icon" style="display:none;">
                                        <img src="/images/loading.gif" alt="Loading...">
                                    </div>
                                    @foreach ($data as $category)
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
                                                <td class="name">{{ $category->name }}</td>
                                                <td class="customer_name">{{ $category->customer }}</td>
                                                <td class="Total_products text-center">{{ $category->products_count }}</td>
                                                <td class="Time_created">{{ $category->created_at }}</td>
                                                <td class="status">
                                                    @if ($category->status === 1)
                                                        <a href="{{ route('category.changeStatus', ['id' => $category->id]) }}"
                                                            class="btn badge badge-soft-success text-uppercase">Active</a>
                                                    @else
                                                        <a href="{{ route('category.changeStatus', ['id' => $category->id]) }}"
                                                            class="btn badge badge-soft-danger text-uppercase">Block</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ route('category.edit', ['id' => $category->id]) }}"
                    class="btn btn-sm btn-success edit-item-btn">Edit</a> --}}

                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-success edit-btn"
                                                            data-id-category='{{ $category->id }}' data-bs-toggle="modal"
                                                            data-bs-target="#showModal">Edit</button>
                                                    </div>
                                                </td>
                                            </div>
                                        </tr>
                        </div>
                        @endforeach

                        </tbody>

                        </table>
                        @if (count($data) === 0)
                            <div class="noresult">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                        orders for you search.</p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{ $data->links() }}
            </div>
        </div><!-- end card -->
    </div>
    <!-- end col -->
    </div>


    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form class="tablelist-form" action="{{ route('category.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name_category" class="form-label">Category Name</label>
                            <input type="text" id="name_category" name="name" class="form-control"
                                placeholder="Enter Category Name" required>
                            <div class="name-error mt-3 text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="imageCategory" class="form-label">Image category</label>
                            <input type="file" class="form-control mb-3" name="image" id="imageCategory">
                            <img src="#" class="img-thumbnail" alt="image Category" id="previewImage"
                                style="display: none;">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" required>
                                <option value="1">Active</option>
                                <option value="2">Block</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add category</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {


            // Bắt sự kiện submit form
            $('form.tablelist-form').on('submit', function(e) {
                let formData = $(this).serialize();
                console.log(formData)
                $.ajax({
                    url: $(this).attr(
                        'action'), // URL được chỉ định trong thuộc tính action của form
                    type: $(this).attr(
                        'method'), // Phương thức được chỉ định trong thuộc tính method của form
                    data: formData, // Dữ liệu form đã được serialize
                    datatype: "json",
                    // Xử lý khi yêu cầu thành công
                    success: function(response) {
                        // Xử lý kết quả trả về (nếu cần)
                        console.log(response)
                        // location.reload();
                    },

                    // Xử lý khi yêu cầu thất bại
                    error: function(xhr, status, error) {

                        if (xhr.responseJSON) {
                            let errors = xhr.responseJSON
                                .errors;

                            if (errors.name) {
                                $('.name-error').text(errors.name
                                    .toString()
                                ); // Gán thông báo lỗi tên vào phần tử .name-error
                            }
                        }


                    }
                });
            });



        });




        const input = $('#imageCategory');
        const image = $('#previewImage');
        input.change(function() {
            const file = input[0].files[0];
            const reader = new FileReader();


            reader.addEventListener('load', function() {
                image.attr('src', reader.result);
                $('#previewImage').attr('style', 'display: block;')
            });
            if (file) {
                reader.readAsDataURL(file);
            }
        });



        $('.edit-btn').on('click', function() {
            let id = $(this).data('id-category');
            let url = "{{ route('category.edit', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'get',
                url: url,
                datatype: 'json',
                success: function(res) {
                    if ($('#showModal').attr('aria-modal') == "true") {
                        $('.text-error').text('');
                    }
                    $('.tablelist-form #name_category').val(res.name);
                    $('.tablelist-form .btn-success').text('Edit category');
                    $('.tablelist-form .status').val(res.status);
                    $('.tablelist-form').attr('action',
                        '{{ route('category.update', ['id' => ':id']) }}'.replace(':id', id));
                    $('.tablelist-form #previewImage').attr('src',
                        '{{ asset('/image/imageCategories') }}' + '/' + res.image);
                    $('.tablelist-form #previewImage').attr('style', 'display: block;')

                },
                error: function(error) {
                    console.log(error);
                }

            })
        })

        $('.add-btn').on('click', function() {
            if ($('#showModal').attr('aria-modal') == "true") {
                $('.text-error').text('');
            }
            $('#imageCategory').val('');
            $('#previewImage').attr('style', 'display: none;')
            $('#previewImage').attr('src', '#')

            $('.tablelist-form #name_category').val('');
            $('.tablelist-form .status').val(1);
            $('.tablelist-form .edit-category').removeClass('edit-category').addClass('add-category').text(
                'Add category');
        })







        let searchTimer;
        $(document).ready(function() {
            $('body').on('keyup', '#search', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    let live_search = $('#search').val();
                    $.ajax({
                        url: "{{ route('category.search') }}",
                        type: 'get',
                        data: {
                            "liveSearch": live_search
                        },
                        datatype: 'json',
                        success: function(data) {
                            if (data.data) {
                                $result = '';
                                data.data.forEach(category => {
                                    $result += '<li class="list-group-item">';
                                    $result += '<a href="#">' + category.name +
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

    <!-- Add this to your HTML -->
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
