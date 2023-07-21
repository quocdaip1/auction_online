@extends('admin.master')

@section('css')
    @parent
    <link href="{{ asset('assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <form id="createproduct-form" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="product-title-input">Product Title</label>
                            <input type="hidden" class="form-control" id="formAction" value="add">
                            <input type="text" class="form-control d-none" id="product-id-input">
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="product-title-input" value="{{ old('name') }}" name="name"
                                placeholder="Enter product title" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Product Description</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>

                        </div>

                        <div>
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Pending Confirmation</option>
                                <option value="2">Confirmed</option>
                            </select>

                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Gallery</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="fs-14 mb-1">Product Image</h5>
                            <p class="text-muted">Add Product main Image.</p>
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute top-100 start-100 translate-middle">
                                        <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip"
                                            data-bs-placement="right" title="Select Image">
                                            <div class="avatar-xs">
                                                <div
                                                    class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input name="image" class="form-control d-none" value=""
                                            id="product-image-input" type="file"
                                            accept="image/png, image/gif, image/jpeg, image/jpg">
                                    </div>
                                    <div class="avatar-lg">
                                        <div class="avatar-title bg-light rounded">
                                            <img src="#" id="product-img" class="avatar-md h-auto" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div>
                            <input type="hidden" id="list-image" name="files[]" value="">
                            <label>List image</label>
                            <div class="dropzone">
                                <div class="fallback">
                                    <input name="files[]" type="file" multiple="multiple">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info"
                                        role="tab">
                                        General Info
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="" id="addproduct-general-info">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturer-name-input">Manufacturer
                                                    Name</label>
                                                <input type="text" name="Manufacturer_Name" class="form-control"
                                                    id="manufacturer-name-input" placeholder="Enter manufacturer name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="manufacturer-brand-input">Manufacturer
                                                    Brand</label>
                                                <input type="text" name="Manufacturer_Brand" class="form-control"
                                                    id="manufacturer-brand-input" placeholder="Enter manufacturer brand">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="stocks-input">Quanlity</label>
                                                <input type="text" name="quanlity" class="form-control"
                                                    id="stocks-input" placeholder="quanlity" required>
                                                <div class="invalid-feedback">Please Enter a product stocks.</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="product-price-input">Staring Price</label>
                                                <div class="input-group has-validation mb-3">
                                                    <span class="input-group-text" id="product-price-addon">$</span>
                                                    <input type="text" name="starting_price" class="form-control"
                                                        id="product-price-input" placeholder="Enter price"
                                                        aria-label="Price" aria-describedby="product-price-addon"
                                                        required>
                                                    <div class="invalid-feedback">Please Enter a product price.</div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="product-discount-input">Buy now</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="product-discount-addon">$</span>
                                                    <input type="text" name="buy_now" class="form-control"
                                                        id="product-discount-input" placeholder="Enter discount"
                                                        aria-label="discount" aria-describedby="product-discount-addon">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end tab-pane -->

                                {{-- <div class="tab-pane" id="addproduct-metadata" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-title-input">Meta title</label>
                                            <input type="text" class="form-control" placeholder="Enter meta title"
                                                id="meta-title-input">
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="meta-keywords-input">Meta Keywords</label>
                                            <input type="text" class="form-control" placeholder="Enter meta keywords"
                                                id="meta-keywords-input">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div>
                                    <label class="form-label" for="meta-description-input">Meta Description</label>
                                    <textarea class="form-control" id="meta-description-input" placeholder="Enter meta description" rows="3"></textarea>
                                </div>
                            </div> --}}
                                <!-- end tab pane -->
                            </div>
                            <!-- end tab content -->
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    <div class="text-end mb-3">
                        <button id="submit-button" type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
                <!-- end col -->

            </div>

            <div class="col-lg-4">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Publish Schedule</h5>
                    </div>
                    <!-- end card body -->
                    <div class="card-body">
                        <div class="product-datetime m-3">
                            <label class="me-3 form-label" for="productStartTime">Start time</label>
                            <input class="form-control" name="start_time" id="productStartTime" type="datetime-local"
                                value="">

                            <div class="mb-3"></div>

                            <label class="me-3 form-label" for="productEndTime">End time</label>
                            <input value="" class="form-control" name="end_time" id="productEndTime"
                                type="datetime-local">
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Categories</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" id="category_name" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <!-- end card -->

                {{-- <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Short Description</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-2">Add short description for product</p>
                    <textarea class="form-control" placeholder="Must enter minimum of a 100 characters" rows="3"></textarea>
                </div>
                <!-- end card body -->
          
            </div>
            <!-- end row -->

            {{-- </form>  --}}
            @endsection


            @section('script')
                @parent
                <script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
                <script>
                    let images = [];
                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                    let dropzone = new Dropzone('.dropzone', {
                        url: "{{ route('product.uploadFiles') }}",
                        method: 'post',
                        maxFilesize: 10,
                        acceptedFiles: ".jpeg,.jpg,.png,.gif",
                        timeout: 5000,
                        paramName: 'files',
                        addRemoveLinks: true,
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        init: function() {
                            this.on("addedfile", function(file) {
                                // Set the 'enctype' attribute to 'multipart/form-data' in the form
                                this.element.setAttribute("enctype", "multipart/form-data");
                            });

                            this.on("removedfile", function(file) {
                                let imageName = JSON.parse(file.xhr.response).imageName;
                                $.ajax({
                                    url: "{{ route('product.deleteImage') }}",
                                    method: 'post',
                                    data: {
                                        imageName: imageName,
                                    },
                                    headers: {
                                        "X-CSRF-TOKEN": csrfToken,
                                    },
                                    success: function(res) {
                                        console.log(res);
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(error)
                                    }
                                })
                            });
                        },
                        success: function(file, response) {
                            images.push(response.imageName);
                            if (images.length > 0) {
                                var list = JSON.stringify(images)
                                $('#list-image').val(list);
                            }
                        },
                        error: function(file, response) {
                            return false;
                        },



                    })
                </script>
                <script src="{{ asset('assets/js/pages/ecommerce-product-create.init.js') }}"></script>
            @endsection
