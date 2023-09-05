<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Controller
{
    //
    public function index(){
        $productCategories = DB::select('select * from product_categories order by created_at desc');
        return view('admin.pages.productCategory.list', ['productCategories' => $productCategories]);

        // return view('admin.pages.productCategory.list', compact($productCategories));
        // return view('admin.pages.productCategory.list')->with('productCategories', $productCategories);

    }
    public function add(){
        return view('admin.pages.productCategory.create');
    }
    public function store(StoreProductCategoryRequest $request){


        $bool = DB::insert('INSERT into product_categories(name, status, created_at, updated_at) values (?, ?, ?, ?)', [
            $request->name,
            $request->status,
            Carbon::now()->addDay(999)->addMonth()->addYear(),
            Carbon::now()
        ]);
        // dd('thanh cong');
        // dd($request->all());
        // $name = $request->name;
        // $status = $request->status;

        $message = $bool ? 'thanh cong' : 'that bai';

        //Session flash
        return redirect()->route('admin.productCategory.list')->with('message',$message);
    }
    public function detail($id){
        $productCategory = DB::select('select * from product_categories where id = ?', [$id]);

        return view('admin.pages.productCategory.detail', ['productCategory' => $productCategory[0]]);

    }
    public function update(UpdateProductCategoryRequest $request, $id){


        // dd($request->all());

        $check = DB::update('UPDATE `product_categories` SET name = ? , status = ?  WHERE id = ? ', [$request->name, $request->status, $id]);
        $message = $check > 0 ? 'Cap nhat thanh cong' : 'Cap nhat that bai';
         //Session flash
        return redirect()->route('admin.productCategory.list')->with('message',$message);

    }
    public function destroy($id){
        $check = DB::delete('delete from product_categories where id = ? ', [$id]);
        $message = $check > 0 ? 'Xoa thanh cong' : 'Xoa that bai';
        //Session flash
       return redirect()->route('admin.productCategory.list')->with('message',$message);
    }
}