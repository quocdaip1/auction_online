<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\ChangePassWordRequest;
use App\Http\Requests\user\StoreRequest;
use App\Http\Requests\user\UpdateRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $data = User::with('user_info')
            ->orderBy('users.id', 'desc')
            ->paginate(10);
        return view('admin.users.index', compact('data'));
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('liveSearch')) {
                $data = User::search(trim($request->get('liveSearch') ?? ''))
                    ->query(function ($q) {
                        $q->join('user_info', 'users.id', 'user_info.user_id')
                            ->select(['users.*', 'user_info.name', 'user_info.phone'])
                            ->orderBy('created_at', 'desc');
                    })->paginate(5);
                return response($data);
            } else {
                return response(null);
            }
        }

        $request->session()->flash('selected_status', $request->input('status'));
        $request->session()->flash('selected_role', $request->input('role'));
        $data = User::search(trim($request->get('search')) ?? '')
            ->query(function ($q) {
                $q->join('user_info', 'users.id', 'user_info.user_id')
                    ->select(['users.*', 'user_info.name', 'user_info.phone'])
                    ->orderBy('created_at', 'desc');
            })->when($request->status, function ($s, $status) {
            return $s->where('status', $status);
        })->when($request->role, function ($r, $role) {
            return $r->where('is_admin', $role);
        })
            ->paginate(10);
        return view('admin.users.index', compact('data'));
    }


    public function create()
    {
        return view('admin.users.create');
    }

    public function edit($id)
    {
        $user = User::join('user_info', 'users.id', '=', 'user_info.user_id')
            ->where('users.id', $id)
            ->select('users.*', 'user_info.name', 'user_info.phone', 'user_info.address', 'user_info.avatar')
            ->first();
        return view('admin.users.edit', compact('user'));
    }


    public function store(StoreRequest $request)
    {

        if ($request->ajax()) {
            $data = $request->data;
            $data = $request->except('_token', 'name', 'phone');
            $data['password'] = bcrypt('password');
            $data['created_at'] = new \DateTime();
            $data['updated_at'] = new \DateTime();
            DB::table('users')->insert($data);
            $user = DB::table('users')->where('email', $request->email)->first();

            $path = public_path('image/imageUsers/user_' . $user->id);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $user_info = $request->except('_token', 'email', 'password', 'is_admin', 'status');
            $user_info['user_id'] = $user->id;
            $user_info['created_at'] = new \DateTime();
            $user_info['updated_at'] = new \DateTime();
            DB::table('user_info')->insert($user_info);
            return redirect()->route('user.index');
        }

        $data = $request->all();
        $data = $request->except('_token', 'name');
        $data['password'] = bcrypt($request->password);
        $data['created_at'] = new \DateTime();
        $data['updated_at'] = new \DateTime();
        DB::table('users')->insert($data);
        $user = DB::table('users')->where('email', $request->email)->first();
        $user_info = $request->except('_token', 'email', 'password', 'is_admin', 'status');

        $path = public_path('image/imageUsers/user_' . $user->id);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $user_info['user_id'] = $user->id;
        $user_info['created_at'] = new \DateTime();
        $user_info['updated_at'] = new \DateTime();
        DB::table('user_info')->insert($user_info);
        return redirect()->route('user.index');
    }

    public function changePassWord(ChangePassWordRequest $request, $id)
    {
        if ($request->ajax()) {
            $currentPass = Auth::user()->password;
            if (Hash::check($request->oldpassword, $currentPass)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json([
                    'status' => "pass",
                ]);
            } else {
                return response()->json([
                    'status' => "mật khẩu không đúng",
                ]);
            }
        }
        ;
    }


    public function update(UpdateRequest $update, $id)
    {
        $data = $update->all();
        $originalData = User::find($id);
        if (isset($update->password) && $update->password != $originalData->password) {
            $data = $update->except('_token', 'email', 'name', 'phone', 'address', 'avatar');
            $data['password'] = bcrypt($update->password);
        } else {
            $data = $update->except('_token', 'email', 'password', 'name', 'phone', 'address', 'avatar');
        }
        $data['updated_at'] = new \Datetime();
        DB::table('users')->where('id', $id)->update($data);

        $data = $update->except('_token', 'email', 'status', 'password');
        if ($update->hasFile('avatar')) {

            $path = public_path('image/imageUsers/user_' . $id);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $user_info = UserInfo::where('user_id', $id)->first();
            if (file_exists(public_path('image/imageUsers/user_' . $id . '/') . $user_info->avatar)) {
                unlink(public_path('image/imageUsers/user_' . $id . '/') . $user_info->avatar);
            }
            $file = $update->avatar;
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image/imageUsers/user_' . $id), $filename);
            $data['avatar'] = $filename;
        }
        $data['updated_at'] = new \Datetime();
        DB::table('user_info')->where('user_id', $id)->update($data);
        return redirect()->route('user.index');
    }

    public function profile($id)
    {
        $user = User::join('user_info', 'users.id', '=', 'user_info.user_id')->select(
            'users.id',
            'users.email',
            'user_info.name',
            'users.created_at',
            'user_info.address',
            'user_info.phone',
            'user_info.avatar'
        )->where('users.id', '=', $id)->first();
        return view('admin.users.profile', compact('user'));
    }

    public function editProfile($id)
    {
        $user = User::join('user_info', 'users.id', '=', 'user_info.user_id')->select(
            'users.id',
            'users.email',
            'user_info.name',
            'users.created_at',
            'user_info.address',
            'user_info.phone',
            'user_info.avatar'
        )->where('users.id', $id)->first();
        return view('admin.users.EditProfile', compact('user'));
    }

    public function updateProfile(Request $update, $id)
    {
        $user = $update->except('_token');
        $user['updated_at'] = new \DateTime();
        DB::table('user_info')->where('user_id', $id)->update($user);
        return redirect()->route('user.profile', ['id' => $id]);
    }

    public function updateProfileAvatar(Request $update, $id)
    {
        $data = $update->except('_token');
        $data['updated_at'] = new \DateTime();
        if (!empty($update->avatar)) {
            $user = DB::table('user_info')->where('user_id', $id)->first();
            if (file_exists(public_path('image/imageUsers/user_' . $id . '/') . $user->avatar)) {
                unlink(public_path('image/imageUsers/user_' . $id . '/') . $user->avatar);
            }
            $file = $update->avatar;
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image/imageUsers/user_' . $id . '/'), $filename);
            $data['avatar'] = $filename;
        }
        DB::table('user_info')->where('user_id', $id)->update(['avatar' => $data['avatar']]);
        return redirect()->route('user.editProfile', ['id' => $id]);
    }

    public function changeStatus($id)
    {

        $user = User::find($id);
        if ($user->status === 1) {
            $user->status = 2;

        } else if ($user->status === 2) {
            $user->status = 1;
        }
        ;

        $user->save();
        return response()->json(['status' => $user->status, 'message' => 'The status change was successful.']);
    }

    public function changeRole($id)
    {
        $user = User::find($id);
        if ($user->is_admin === 2) {
            $user->is_admin = 1;
        } else if ($user->is_admin === 1) {
            $user->is_admin = 2;
        }
        ;
        $user->save();
        return response()->json(['user' => $user, 'message' => 'The Role change was successful.']);
    }


}