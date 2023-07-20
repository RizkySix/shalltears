<?php

namespace App\Http\Controllers;

use App\Models\SellingProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteProdukImageController extends Controller
{
    public function delete_image($slug_id , $column_name)
    {
        $delete_old_image = SellingProduk::where('slug_id' , $slug_id)->pluck($column_name);
        foreach($delete_old_image as $old){
            Storage::delete($old);
        }

        SellingProduk::where('slug_id' , $slug_id)->update([$column_name => null]);
        return back();
    }
}

