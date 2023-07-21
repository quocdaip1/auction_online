@foreach ($data as $user)
    <tr>
        <th scope="row">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
            </div>
        </th>
        <div class="col-12">
            <td class="id" style="display:none;"><a href="javascript:void(0);"
                    class="fw-medium link-primary">#VZ2101</a></td>
            <td class="customer_name">{{ $user->user_info->name }}</td>
            <td class="email">{{ $user->email }}</td>
            <td class="phone">{{ $user->user_info->phone }}</td>
            <td class="role">
                {{-- {{ \Illuminate\Support\Carbon::parse($user->created_at)->toDateTimeString() }} --}}
                @if ($user->is_admin === 1)
                    @if ($user_login->id === 1)
                        <a href="{{ route('user.changeRole', ['id' => $user->id]) }}"
                            class="btn badge badge-soft-danger text-uppercase changeRole">Admin</a>
                    @else
                        <a onclick="return disableEditAdmin(event)" class="btn badge badge-soft-danger text-uppercase changeRole">Admin</a>
                    @endif
                @else
                    @if ($user_login->id === 1)
                        <a href="{{ route('user.changeRole', ['id' => $user->id]) }}"
                            class="btn badge badge-soft-success text-uppercase changeRole">Client</a>
                    @else
                        <a onclick="return disableEditAdmin(event)" class="btn badge badge-soft-success text-uppercase changeRole">Client</a>
                    @endif
                @endif
            </td>
            <td class="status">

                @if ($user->is_admin === 2)
                    <label class="switch">
                        <input data-id="{{ $user->id }}" class="changeStatus-form" type="checkbox"
                            {{ $user->status === 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                @else
                    @if ($user_login->id === 1)
                        <label class="switch">
                            <input data-id="{{ $user->id }}" class="changeStatus-form" type="checkbox"
                                {{ $user->status === 1 ? 'checked' : '' }}
                                {{ $user_login->id === $user->id ? 'disabled' : '' }}>
                            <span style=" {{ $user_login->id === $user->id ? 'background-color: #c8c8fa' : '' }}"
                                class="slider round"></span>
                        </label>
                    @else
                        <label class="switch">
                            <input data-id="{{ $user->id }}" class="changeStatus-form" type="checkbox"
                                {{ $user->status === 1 ? 'checked' : '' }} disabled>
                            <span style="background-color: #c8c8fa" class="slider round"></span>
                        </label>
                    @endif
                @endif
            </td>
            <td>
                @if ($user->is_admin === 1)
                    @if ($user_login->id === 1)
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}"
                            class="btn btn-sm btn-success edit-item-btn">Edit</a>
                    @else
                        <a onclick="return disableEditAdmin(event)"
                            href="{{ route('user.edit', ['id' => $user->id]) }}"
                            class="btn btn-sm btn-success edit-item-btn">Edit</a>
                    @endif
                @else
                    <a href="{{ route('user.edit', ['id' => $user->id]) }}"
                        class="btn btn-sm btn-success edit-item-btn">Edit</a>
                @endif
            </td>
        </div>
    </tr>
    </div>
@endforeach
