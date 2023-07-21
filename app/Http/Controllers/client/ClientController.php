<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\BidRequest;
use App\Http\Requests\client\UpdateRequest;
use App\Models\Auction;
use App\Models\Category;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use ReflectionClass;
use Carbon\Carbon;



use Redirect;
use Illuminate\Support\Facades\Validator;
use Response;


class ClientController extends Controller
{
    public function productDetails($id)
    {
        $data = Auction::join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image', 'products.description as product_description', 'products.files as listImage')
            ->where('product_id', $id)->first();


        $list_bid = DB::table('bids')
            ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
            ->join('user_info', 'bids.user_id', '=', 'user_info.user_id')
            ->where('auctions.product_id', '=', $id)
            ->orderBy('bids.created_at', 'desc')
            ->select('bids.*', 'user_info.name', 'user_info.avatar')
            ->get();

        return view('client.product.details', compact('data', 'list_bid'));
    }

    public function index()
    {
        $data1 = Auction::join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'user_info.avatar', 'categories.name as category_name', 'products.image as product_image')
            ->where('auctions.status', '=', 3)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();


        $data2 = Auction::join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'user_info.avatar', 'categories.name as category_name', 'products.image as product_image')
            ->where('auctions.status', '=', 2)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();
        $categories = Category::all();
        return view('client.homepage.index', compact('data1', 'data2', 'categories'));
    }

    public function auction()
    {
        $data = Auction::join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'user_info.avatar', 'categories.name as category_name', 'products.image as product_image')
            ->where('auctions.status', '=', 3)
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('client.product.index', compact('data'));
    }
    public function aboutus()
    {
        return view('client.aboutus.index');
    }
    public function howwork()
    {
        return view('client.howitwork.index');
    }
    public function signup()
    {
        return view('client.signup.index');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('client.index');
        } else {
            return view('client.login.index');
        }
    }

    public function dashboard(Request $request, $id)
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
        $categories = Category::get();

        $auctions = DB::table('auctions')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('products', 'auctions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image', 'products.description as product_description')
            ->where('auctions.user_id', '=', $id)
            ->paginate(2);

        $list_bids = DB::table('bids')
            ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
            ->join('products', 'auctions.product_id', '=', 'products.id')
            ->where('bids.user_id', Auth::User()->id)
            ->select('auctions.*', 'bids.amount', 'products.name as product_name', 'products.image as product_image')
            ->paginate(2);

        return view('client.dashboard.index', compact('user', 'categories', 'auctions', 'list_bids'));
    }



    public function AllProduct(Request $request, $id)
    {
        $auctions = DB::table('auctions')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('products', 'auctions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image', 'products.description as product_description')
            ->where('auctions.user_id', '=', $id)
            ->paginate(2);
        return view('client.dashboard.data', compact('auctions'));

    }
    public function BidAuctionList(Request $request, $id)
    {
        $list_bids = DB::table('bids')
            ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
            ->join('products', 'auctions.product_id', '=', 'products.id')
            ->where('bids.user_id', Auth::User()->id)
            ->select('auctions.*', 'bids.amount', 'products.name as product_name', 'products.image as product_image')
            ->paginate(2);
        return view('client.dashboard.dataBidder ', compact('list_bids'));

    }








    public function updateProfile(UpdateRequest $request, $id)
    {
        $user = $request->except('_token');
        $user['updated_at'] = new \DateTime();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');


            $filename = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('image/imageUsers/user_' . Auth::user()->id . '/'), $filename);
            $user['avatar'] = $filename;
            DB::table('user_info')->where('user_id', Auth::user()->id)->update(['avatar' => $user['avatar']]);
        }

        DB::table('user_info')->where('user_id', Auth::user()->id)->update($user);
        return redirect()->route('client.dashboard', ['id' => Auth::user()->id]);
    }


    public function productstore(Request $request)
    {

        $data = $request->except('_token', 'starting_price', 'start_time', 'end_time', 'buy_now');
        $data['created_at'] = new \DateTime();
        $data['updated_at'] = new \DateTime();
        $data['user_id'] = Auth::User()->id;
        $data['status'] = 1;
        $file = $request->image;
        $filename = time() . '_' . $file->getClientOriginalName();
        $data['image'] = $filename;
        $data['files'] = implode(', ', array_map('strval', $data['files']));

        $product_id = DB::table('products')->insertGetId($data);

        $oldDirectory = public_path('image/list_images');
        $newDirectory = public_path('image/imageProducts/user_' . Auth::user()->id . '/' . 'product_' . $product_id);
        if (!file_exists($newDirectory)) {
            mkdir($newDirectory, 0755, true);
        }

        if (!empty($request->image)) {
            $file = $request->file('image');
            $newPath = public_path('image/imageProducts/user_' . Auth::user()->id . '/' . 'product_' . $product_id);
            $file->move($newPath, $filename);
        }

        $files = glob($oldDirectory . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                $newFile = $newDirectory . '/' . basename($file);
                rename($file, $newFile);
            }
        }

        // Xóa thư mục cũ
        if (file_exists($oldDirectory) && is_dir($oldDirectory)) {
            $files = glob($oldDirectory . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($oldDirectory);
        }




        $data = $request->except('_token', 'name', 'category_id', 'image', 'description', 'Manufacturer_Name', 'Manufacturer_Brand', 'quanlity', 'files');

        $data['created_at'] = new \DateTime();
        $data['updated_at'] = new \DateTime();
        $data['status'] = 1;

        $data['product_id'] = $product_id;
        $data['user_id'] = Auth::User()->id;
        DB::table('auctions')->insert($data);


        if ($data['status'] === 1) {
            $data = $request->except('_token', 'starting_price', 'start_time', 'end_time', 'image', 'description', 'category_id', 'Manufacturer_Name', 'Manufacturer_Brand', 'quanlity', 'files', 'buy_now', 'name', 'status');
            $data['created_at'] = new \DateTime();
            $data['product_id'] = $product_id;
            DB::table('check_product')->insert($data);
        }

        return response()->json(['message' => 'success']);
    }


    public function uploadFiles(Request $request)
    {
        if ($request->hasFile('files')) {
            $image = $request->file('files');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('image/list_images'), $imageName);
            return response()->json(['imageName' => $imageName]);
        } else {
            return response()->json(['error' => 'No file uploaded.']);
        }

    }

    public function deleteImage(Request $request)
    {
        $imageName = $request->imageName;
        // Xử lý xóa tệp tin từ thư mục lưu trữ
        $filePath = public_path('image/list_images/' . $imageName);

        if (file_exists($filePath)) {
            unlink($filePath);
            // ImageUpload::where('files', $imageName)->delete();
            return response()->json(['success' => 'Tệp tin đã được xóa thành công']);
        }

        return response()->json(['error' => 'Không tìm thấy tệp tin']);
    }


    public function changeStatus(Request $request, $id)
    {
        $auction = DB::table('auctions')->where('product_id', $id)->first();

        if ($request->ajax()) {
            if ($auction->status === 3) {
                $status = 4;
                $highest_bid = DB::table('bids')
                    ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
                    ->join('user_info', 'bids.user_id', '=', 'user_info.user_id')
                    ->join('users', 'bids.user_id', '=', 'users.id')
                    ->where('auctions.product_id', '=', $id)
                    ->orderBy('bids.amount', 'desc') // Sort by bid amount in descending order
                    ->select('users.balance', 'users.blocked_balance', 'user_info.user_id', 'user_info.name', 'bids.amount')
                    ->first();

                //ended auction
                DB::table('auctions')->where('product_id', $id)->update(['status' => $status]);

                if ($highest_bid && $highest_bid->amount >= $auction->buy_now) {
                    $list_bids_winner = DB::table('bids')
                        ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
                        ->join('users', 'bids.user_id', '=', 'users.id')
                        ->where('auctions.product_id', '=', $id)
                        ->orderBy('bids.amount', 'desc')
                        ->skip(1)
                        ->take(PHP_INT_MAX) // Lấy tất cả các hàng trừ hàng đầu tiên
                        ->select('users.balance', 'users.blocked_balance', 'users.id as user_id', 'bids.amount')
                        ->get();

                    // loser auction
                    foreach ($list_bids_winner as $bid) {
                        DB::table('users')
                            ->where('id', $bid->user_id)
                            ->update([
                                'blocked_balance' => $bid->blocked_balance - $bid->amount,
                                'balance' => $bid->balance + $bid->amount
                            ]);
                    }
                    // winner auction
                    DB::table('users')->where('id', $highest_bid->user_id)->update([
                        'blocked_balance' => DB::raw('blocked_balance - ' . $highest_bid->amount)
                    ]);

                    //owner auction

                    DB::table('users')->where('id', $auction->user_id)->update([
                        'balance' => DB::raw('balance + ' . $highest_bid->amount)
                    ]);

                    return response()->json(['success' => $highest_bid]);
                } else {
                    $list_bids_loser = DB::table('bids')
                        ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
                        ->join('users', 'bids.user_id', '=', 'users.id')
                        ->where('auctions.product_id', '=', $id)
                        ->orderBy('bids.amount', 'desc')
                        ->select('users.balance', 'users.blocked_balance', 'users.id as user_id', 'bids.amount')
                        ->get();
                    if ($list_bids_loser) {
                        foreach ($list_bids_loser as $bid) {
                            DB::table('users')
                                ->where('id', $bid->user_id)
                                ->update([
                                    'blocked_balance' => $bid->blocked_balance - $bid->amount,
                                    'balance' => $bid->balance + $bid->amount
                                ]);
                        }
                    }
                    return response()->json(['error' => 'no one winner']);
                }
            }




            if ($auction->status === 2) {
                $status = 3;
                DB::table('auctions')->where('product_id', $id)->update(['status' => $status]);
                return response()->json(['success' => 'Auction Open']);
            }
        }
    }



    public function bid(BidRequest $request, $id)
    {
        $data = $request->all();
        $highest_bid = DB::table('bids')
            ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
            ->join('user_info', 'bids.user_id', '=', 'user_info.user_id')
            ->where('auctions.product_id', '=', $id)
            ->orderBy('bids.amount', 'desc') // Sort by bid amount in descending order
            ->select('user_info.name', 'bids.amount')
            ->first();

        if ($highest_bid) {
            $name = $highest_bid->name;
            $nameLogin = UserInfo::where('user_info.user_id', '=', Auth::User()->id)->first();
            if ($name === $nameLogin->name) {
                return response()->json(['error' => 'Your price is already the highest']);
            }
        }


        if ($data['bid_amount'] < $data['minimum_bid']) {
            return response()->json(['error' => 'Bid amount must be greater than the minimum bid.']);
        }



        $user = DB::table('users')->where('id', Auth::User()->id)->first();
        if ($user->balance < $data['bid_amount']) {
            return response()->json(['error' => "You don't have enough money, please top up"]);
        } else {

            DB::table('auctions')
                ->where('product_id', $id)
                ->update(['current_price' => $data['bid_amount']]);

            // // Tạo hoặc cập nhật thông tin người đấu giá
            DB::table('bids')->updateOrInsert(
                [
                    'user_id' => Auth::user()->id,
                    'auction_id' => $id,
                ],
                [
                    'amount' => $data['bid_amount'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $total_amount = DB::table('bids')->where('user_id', Auth::User()->id)->sum('amount');
            DB::table('users')->where('id', Auth::User()->id)->update(['blocked_balance' => $total_amount, 'balance' => $user->balance - $total_amount]);
            return response()->json(['success' => 'successful auction']);
        }



        // Cập nhật giá đấu giá mới


    }

}