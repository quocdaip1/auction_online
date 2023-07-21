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
                    <h4 class="card-title mb-0">List users</h4>
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
                                        <form class="d-flex justify-content-between" action="{{ route('user.search') }}"
                                            method="get">
                                            <div class="me-2">
                                                <select name="role" id="role" class="form-control">
                                                    <option value="">Role</option>
                                                    <option value="1"
                                                        {{ old('status', session('selected_role')) == 1 ? 'selected' : '' }}>
                                                        Admin</option>
                                                    <option value="2"
                                                        {{ old('status', session('selected_role')) == 2 ? 'selected' : '' }}>
                                                        Client</option>
                                                </select>
                                            </div>
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
                                        <th class="sort" data-sort="customer_name">Name</th>
                                        <th class="sort" data-sort="email">Email</th>
                                        <th class="sort" data-sort="phone">Phone</th>
                                        <th class="sort" data-sort="role">Role</th>
                                        <th class="sort" data-sort="status">Status</th>
                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <div id="loading-icon" style="display:none;">
                                        <img src="/images/loading.gif" alt="Loading...">
                                    </div>
                                    @include('admin.users.data')
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

                    {{-- <input type="hidden" name="hidden_page" id="hidden_page" value="1" /> --}}
                        {{ $data->links()}}
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
                <form class="tablelist-form" action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Customer Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Enter Name" required />
                            <div class="name-error mt-3 text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Enter Email" required />
                            <div class="email-error mt-3 text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="phone-field" class="form-label">Phone</label>
                            <input type="phone" id="phone" name="phone" class="form-control"
                                placeholder="Enter Phone number" />
                            <div class="invalid-feedback">Please enter a phone.</div>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="password-field" class="form-label">Password</label>
                            <input id="password-field" type="password" name="phone" class="form-control"
                                placeholder="Enter Phone number" />
                            <div class="invalid-feedback">Please enter a phone.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Password confirmation</label>
                            <input id="password_confirmation" type="password" name="phone" class="form-control"
                                placeholder="Enter Phone number" />
                            <div class="invalid-feedback">Please enter a phone.</div>
                        </div> --}}

                        <div class="mb-3">
                            <label for="is_admin" class="form-label">Role</label>
                            <select class="form-control" id="is_admin" data-trigger name="is_admin">
                                <option value="1">Admin</option>
                                <option value="2">Client</option>
                            </select>
                            <div class="invalid-feedback">Please choose role.</div>
                        </div>

                        <div>
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" data-trigger name="status" required>
                                <option value="1">Active</option>
                                <option value="2">Block</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add Customer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // $(document).ready(function() {
        //     // Check for success flash message
        //     var successMessage = "{{ session('success') }}";
        //     if (successMessage) {
        //         toastr.success(successMessage, 'Success', {
        //             timeOut: 2000
        //         });
        //     }
        // });










        //add users
        $(document).ready(function() {
            // Bắt sự kiện submit form
            $('form.tablelist-form').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của form
                // Lấy dữ liệu từ form
                let formData = $(this).serialize();
                let form = e.target;
                // Gửi yêu cầu AJAX
                $.ajax({
                    url: $(this).attr(
                        'action'), // URL được chỉ định trong thuộc tính action của form
                    type: $(this).attr(
                        'method'), // Phương thức được chỉ định trong thuộc tính method của form
                    data: formData, // Dữ liệu form đã được serialize
                    datatype: "json",
                    // Xử lý khi yêu cầu thành công
                    success: function(response) {

                        toastr.success('User created successfully.', 'Success', {
                            timeOut: 2000
                        });


                        form.reset();
                        form.querySelector('.name-error').textContent = '';
                        form.querySelector('.email-error').textContent = '';


                    },

                    // Xử lý khi yêu cầu thất bại
                    error: function(xhr, status, error) {
                        // Xử lý lỗi và hiển thị thông báo
                        var errors = xhr.responseJSON
                            .errors; // Lấy danh sách lỗi từ phản hồi JSON


                        if (errors.name) {
                            $('.name-error').text(errors.name
                                .toString()); // Gán thông báo lỗi tên vào phần tử .name-error
                        }

                        if (errors.email) {
                            $('.email-error').text(errors.email
                                .toString()
                            ); // Gán thông báo lỗi email vào phần tử .email-error
                        }

                    }
                });
            });
        });




        // search
        let searchTimer;
        $(document).ready(function() {
            $('body').on('keyup', '#search', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    let live_search = $('#search').val();
                    $.ajax({
                        url: "{{ route('user.search') }}",
                        type: 'get',
                        data: {
                            "liveSearch": live_search
                        },
                        datatype: 'json',
                        success: function(data) {
                            if (data.data) {
                                $result = '';
                                data.data.forEach(user => {
                                    $result += '<li class="list-group-item">';
                                    $result += '<a href="#">' + user.name +
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



        document.addEventListener('DOMContentLoaded', function() {
            const changeStatus = document.querySelectorAll('.changeStatus-form');
            changeStatus.forEach(function(form) {
                form.addEventListener('change', function(event) {
                    const selectedSlider = event.target;
                    const dataId = selectedSlider.getAttribute('data-id');
                    let url = "{{ route('user.changeStatus', ['id' => 'USER_ID']) }}";
                    url = url.replace('USER_ID', dataId);
                    $.ajax({
                        url: url,
                        type: "get",
                        datatype: 'json',
                        success: function(res) {
                            toastr.success(res.message, 'Success', {
                                timeOut: 2000
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                });
            });



            const changeRole = document.querySelectorAll('.changeRole');
            changeRole.forEach(function(form) {
                form.addEventListener('click', function(event) {
                    event.preventDefault();
                    const btnChangeRole = event.target;
                    let url = btnChangeRole.getAttribute('href');
                    $.ajax({
                        url: url,
                        type: 'get',
                        datatype: 'json',
                        success: function(res) {
                            let id = btnChangeRole.getAttribute('href').split(
                                'changeRole/')[1];
                            if (res && res.user && res.user.id === Number(id)) {
                                if (res.user.is_admin === 1) {
                                    btnChangeRole.textContent = "Admin";
                                    btnChangeRole.classList.replace(
                                        'badge-soft-success',
                                        'badge-soft-danger');
                                } else if (res.user.is_admin === 2) {
                                    btnChangeRole.textContent = "Client";
                                    btnChangeRole.classList.replace('badge-soft-danger',
                                        'badge-soft-success');

                                }
                                toastr.success(res.message);
                            };
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        },
                    });
                })
            })
        });


        function disableEditAdmin(event) {
            event.preventDefault();
            Swal.fire(
                "Error",
                "You don't have sufficient privileges.",
                'error'
            );
            // return false;
        }
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
