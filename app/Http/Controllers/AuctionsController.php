<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Paginator;

class AuctionsController extends Controller
{
    public function index()
    {
        $data = DB::table('auctions')->join('products', 'auctions.product_id', '=', 'products.id')->paginate(3);
        $categories = DB::table('categories')->select('categories.name', 'categories.id')->get();  
        $user_info = DB::table('user_info')->get();

        $data = DB::table('auctions')
        ->join('products', 'auctions.product_id', '=', 'products.id')
        ->join('user_info', 'auctions.user_id', '=', 'user_info.user_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('auctions.*', 'products.name as product_name', 'user_info.name as user_fullname', 'categories.name as category_name','products.image as product_image')
        ->paginate(3);
        return view('modules.admin.auctions.index',compact('data'));
    }

    public function create($id = null)
    {
        $user_id = auth()->user()->id;
        $products = DB::table('products')->where('user_id', $user_id)->select('products.name', 'products.id', 'products.image')->get();
        return view('modules.admin.auctions.create', compact('products'));
    }
    public function edit($id = null){
        return view('modules.admin.products.create',compact('id'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['user_id'] = auth()->user()->id;
        $data['created_at'] = new \Datetime();

        DB::table('auctions')->insert($data);

        return redirect()->route('auction.index');

    }
}