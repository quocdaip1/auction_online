<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\StoreRequest;
use App\Models\Auction;
use App\Models\Category;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;





class ProductsController extends Controller
{
    public function index()
    {
        $data = Auction::join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image')
            ->where(function ($query) {
                $query->whereIn('auctions.status', [2, 3, 4])
                    ->where('auctions.status', '!=', 1);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $categories = Category::all();
        return view('admin.products.index', compact('data', 'categories'));
    }
    public function details($id)
    {
        $data = DB::table('auctions')
            ->join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image', 'products.description as product_description', 'products.files as listImage')
            ->where('product_id', $id)->first();

        return view('admin.products.details', compact('data'));
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



    public function search(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('liveSearch')) {
                $data = Auction::search(trim($request->get('liveSearch') ?? ''))
                    ->query(function ($q) {
                        $q->join('products', 'auctions.product_id', '=', 'products.id')
                            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
                            ->join('categories', 'products.category_id', '=', 'categories.id')
                            ->select(['auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image', 'products.description as product_description'])
                            ->orderBy('created_at', 'asc');
                    })->paginate(5);
                return response($data);
            } else {
                return response(null);
            }
        }


        $request->session()->flash('selected_status', $request->input('status'));
        $request->session()->flash('selected_category', $request->input('category'));
        $data = Auction::search(trim($request->get('search')) ?? '')
            ->query(function ($q) {
                $q->join('products', 'auctions.product_id', '=', 'products.id')
                    ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->select(['auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image', 'products.description as product_description'])
                    ->orderBy('created_at', 'asc');
            })->when($request->status, function ($s, $status) {
            return $s->where('auctions.status', $status);
        })->when($request->category, function ($c, $category) {
            return $c->where('products.category_id', $category);
        })
            ->paginate(10);

        $categories = Category::all();
        return view('admin.products.index', compact('data', 'categories'));
    }





    public function edit($id)
    {
        $data = DB::table('auctions')
            ->join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'auctions.*',
                'products.name as product_name',
                'user_info.name as user_fullname',
                'categories.name as category_name',
                'products.image as product_image',
                'products.description as product_description',
                'products.files as listImage',
                'products.Manufacturer_Name',
                'products.Manufacturer_Brand',
                'products.quanlity',
            )
            ->where('product_id', $id)->first();
        $categories = Category::get();
        return view('admin.products.edit', compact('categories', 'data'));
    }
    public function create($id = null)
    {
        $categories = DB::table('categories')->get();
        return view('admin.products.create', compact('categories', 'id'));
    }




    public function update(Request $update, $id)
    {
        $data = $update->except('_token', 'starting_price', 'buy_now', 'start_time', 'end_time','status');
        $data['updated_at'] = new \DateTime();

        // if (!empty($update->image)) {
        //     if (file_exists(public_path('image/imageProducts/user_'.$) . $update->image)) {
        //         unlink(public_path('image/imageProducts') . $update->image);
        //     }
        //     $file = $update->image;
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('image/imageProducts'), $filename);
        //     $data['image'] = $filename;
        // }


        if ($update->hasFile('image')) {
            $file = $update->image;
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['image'] = $filename;
        }



        DB::table('products')->where('id', $id)->update($data);
        $product = DB::table('products')->where('id', $id)->first();


        $oldDirectory = public_path('image/list_images');
        $newDirectory = public_path('image/imageProducts/user_' . $product->user_id . '/' . 'product_' . $product->id);
        if (!file_exists($newDirectory)) {
            mkdir($newDirectory, 0755, true);
        }

        if (!empty($update->image)) {
            $file = $update->file('image');
            $newPath = public_path('image/imageProducts/user_' . $product->user_id . '/' . 'product_' . $product->id);
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
        $data = $update->except('_token', 'name', 'category', 'category_id', 'image', 'description', 'buy_now', 'files', 'Manufacturer_Name', 'Manufacturer_Brand', 'quanlity','status');

        $data['updated_at'] = new \DateTime();
        DB::table('auctions')->where('product_id', $id)->update($data);


        return redirect()->route('product.index');
    }


    public function store(Request $request)
    {
        $data = $request->except('_token', 'starting_price', 'start_time', 'end_time', 'buy_now');
        $data['created_at'] = new \DateTime();
        $data['updated_at'] = new \DateTime();
        $data['user_id'] = Auth::User()->id;
        $data['status'] = $request->status;
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

        return redirect()->route('product.index');
    }


    public function changeStatus(Request $request, $id)
    {
        $auctions = DB::table('auctions')->where('product_id', $id)->first();
        if ($auctions->status === 1) {
            $status = 2;
            $currentTime = Carbon::now();
            $formattedTime = $currentTime->format('Y-m-d H:i:s');
            $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $auctions->start_time);
            if ($start_time <= $formattedTime) {
                $status = 3;
            }
        }


        if ($request->ajax()) {
            if ($auctions->status === 3) {
                $status = 4;
                $highest_bid = DB::table('bids')
                    ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
                    ->join('user_info', 'bids.user_id', '=', 'user_info.user_id')
                    ->where('auctions.product_id', '=', $id)
                    ->orderBy('bids.amount', 'desc') // Sort by bid amount in descending order
                    ->select('user_info.name', 'bids.amount')
                    ->first();

                DB::table('products')->where('id', $id)->update(['status' => $status]);
                DB::table('auctions')->where('product_id', $id)->update(['status' => $status]);
                if ($highest_bid) {
                    return response()->json(['success' => $highest_bid]);
                } else {
                    return response()->json(['error' => 'no one winner']);

                }
            }
        }
        DB::table('products')->where('id', $id)->update(['status' => $status]);
        DB::table('auctions')->where('product_id', $id)->update(['status' => $status]);
        DB::table('check_product')->where('product_id', $id)->delete();
        return redirect()->route('product.index');
    }


    public function listCheck()
    {
        $data = DB::table('auctions')
            ->join('products', 'auctions.product_id', '=', 'products.id')
            ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('auctions.status', '=', 1)
            ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name', 'products.image as product_image')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        $listCheck = DB::table('check_product')->get();
        return view('admin.checks.index', compact('data', 'listCheck'));
    }

    public function deleteListCheck($id)
    {
        DB::table('check_product')->where('product_id', $id)->delete();
        DB::table('auctions')->where('product_id', $id)->delete();
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('product.listCheck');
    }
}