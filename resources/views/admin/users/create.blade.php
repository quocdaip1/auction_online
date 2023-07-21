@extends('admin.master')
@section('content')
    <div tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('user.store') }}" class="tablelist-form" autocomplete="off" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3" id="modal-id" style="display: none;">
                            <label for="id-field" class="form-label">ID</label>
                            <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                        </div>

                        <div class="mb-3">
                            <label for="name-field" class="form-label">name</label>
                            <input class="form-control  @error('name') is-invalid @enderror" name="name" type="text"
                                id="name-field" value="{{old('name')}}" placeholder="Enter your name" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="email-field" class="form-label">Email</label>
                            <input name="email" type="email" id="email-field"
                                class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="Enter Email" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="password-field" class="form-label">Password</label>
                            <input name="password" type="password" id="password-field"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Enter password" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-field" class="form-label">Password confirmation</label>
                            <input name="password_confirmation" type="password" id="password_confirmation-field"
                                class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Enter password" />
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="modal-footer mt-3">
                        <div class="hstack gap-2 justify-content-end">
                            <button class="btn btn-success" type="submit">Add</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
