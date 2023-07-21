<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\StoreRequest;
use App\Http\Requests\category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $data = $request->except('_token');
        $user_id = Auth::User()->id;
        $data['user_id'] = $user_id;
        $data['created_at'] = new \DateTime();
        $data['updated_at'] = new \DateTime();
        DB::table('categories')->insert($data);
        return redirect()->route('product.create');

    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response($category);
    }
    public function update(UpdateRequest $update, $id)
    {
        $data = Category::findOrFail($id);

        if (!empty($update->image)) {
            if (file_exists(public_path('image/imageCategories') . $update->image)) {
                unlink(public_path('image/imageCategories') . $update->image);
            }
            $file = $update->image;
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('image/imageCategories'), $filename);
            $data['image'] = $filename;
        }

        $data->update($update->all());
        return redirect()->route('category.index');
    }

    public function index()
    {
        $data = Category::join('user_info', 'categories.user_id', 'user_info.id')
            ->select('categories.*', 'user_info.name as customer')
            ->withCount('products')
            ->paginate(5);
        return view('admin.categories.index', compact('data'));
    }

    public function search(Request $request)
    {

        if ($request->ajax()) {
            if ($request->get('liveSearch')) {
                $data = Category::search(trim($request->get('liveSearch') ?? ''))
                    ->query(function ($q) {
                        $q->join('user_info', 'categories.user_id', 'user_info.user_id')
                            ->select(['categories.*', 'user_info.name as customer'])
                            ->orderBy('created_at', 'asc');
                    })->paginate(5);
                return response($data);
            } else {
                return response(null);
            }
        }

        $request->session()->flash('selected_status', $request->input('status'));
        $data = Category::search(trim($request->get('search')) ?? '')
            ->query(function ($q) {
                $q->join('user_info', 'categories.user_id', 'user_info.user_id')
                    ->select(['categories.*', 'user_info.name as customer'])
                    ->withCount('products')
                    ->orderBy('created_at', 'asc');
            })->when($request->status, function ($s, $status) {
            return $s->where('status', $status);
        })->paginate(5);
        return view('admin.categories.index', compact('data'));
    }


    public function changeStatus($id)
    {
        $category = Category::find($id);
        if ($category->status === 1) {
            $category->status = 2;
        } else if ($category->status === 2) {
            $category->status = 1;
        }
        $category->save();
        return redirect()->route('category.index');
    }


}