@extends('admin.master')
@section('content')
    <div tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content container">
                <form action="{{ route('user.update', ['id' => $user->id]) }}" class="tablelist-form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="col-auto">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        @php
                                            $imagePath = 'image/imageUsers/user_' . $user->id . '/' . $user->avatar;
                                            $defaultImagePath = 'image/imageUsers/default_avatar.jpg';
                                            
                                            // Kiểm tra xem tệp tin có tồn tại trong thư mục "user_" hay không
                                            $imageUrl = asset($imagePath);
                                            if (!file_exists(public_path($imagePath))) {
                                                $imageUrl = asset($defaultImagePath);
                                            }
                                        @endphp
                                        <img id="custom-image-profile" src="{{ $imageUrl }}"
                                            class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                            alt="user-profile-image">
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input name="avatar" id="profile-img-file-input" type="file"
                                                class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                                    <p class="text-muted mb-0">{{ $user->is_admin == 1 ? 'Admin' : 'Client' }}</p>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter a name.</div>
                        </div>

                        <div class="mb-3">
                            <label for="customername-field" class="form-label">Name</label>
                            <input name="name" value="{{ $user->name }}" type="text" id="customername-field"
                                class="form-control" placeholder="Enter Name" required />
                            <div class="invalid-feedback">Please enter a name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="customername-field" class="form-label">Email</label>
                            <input name="email" value="{{ $user->email }}" type="email" id="customername-field"
                                class="form-control" placeholder="Enter Name" required disabled />
                        </div>
                        <div class="mb-3">
                            <label for="customername-field" class="form-label">Password</label>
                            <input name="password" value="{{ $user->password }}" type="text" id="customername-field"
                                class="form-control" placeholder="Enter Name" required />
                        </div>

                        <div class="mb-3">
                            <label for="phone-field" class="form-label">Phone</label>
                            <input name="phone" value="{{ $user->phone }}" type="number" id="phone-field"
                                class="form-control" />
                            <div class="invalid-feedback">Please enter a phone.</div>
                        </div>

                        <div class="mb-3">
                            <label for="address-form" class="form-label">Address</label>
                            <textarea name="address" id="address-form" class="form-control" aria-label="With textarea">{{ $user->address }}</textarea>
                        </div>

                        <div>
                            <label for="status-field" class="form-label">Status</label>
                            <select name="status" class="form-control" data-trigger name="status-field" id="status-field"
                                required>
                                <option value="1" {{ old('level', $user->status) == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="2" {{ old('level', $user->status) == 2 ? 'selected' : '' }}>Block
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <div class="hstack gap-2 justify-content-end">
                            <a class="btn btn-light" href="{{ route('user.index') }}">Exit</a>
                            <button class="btn btn-success" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const input = $('#profile-img-file-input');
            const image = $('#custom-image-profile');

            input.change(function() {
                const file = input[0].files[0];
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    image.attr('src', reader.result);
                });
                if (file) {
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
