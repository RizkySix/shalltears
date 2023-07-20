<?php

namespace App\Http\Controllers;

use App\Models\CuttingProduk;
use App\Models\SellingProduk;
use Illuminate\Http\Request;

class AjaxCuttingRequestController extends Controller
{
    public function category_request($category_id)
    {
        $data_category = CuttingProduk::where('category_id' , $category_id)->latest()->get();

        return response()->json($data_category);
    }

    public function update_category_request($category_id, $selling_id)
    {

       /*  $sellID = $selling_id;
        $stoks = SellingProduk::whereRelation('cutting_produks' , function($data) use($sellID){
            $data->where('selling_produks_id' , $sellID);
        })->get();

        
        $array = array();
        foreach($stoks as $stok){
            foreach($stok->cutting_produks as $dt){
             $array[] = array(
                $dt->cutting_name => $dt->pivot->stok_produk
             );
            }
        }
 */

       /*  foreach ($array as $arr){
           foreach ($arr as $s => $d){
            echo $s;
           }
        } */


       /* 
        $allstok = array();
        foreach($stoks as $stok){
           foreach ($stok->cutting_produks as $st){
           if($st->category_id == $category_id){
            
                $allstok[] = array(
                    $st->cutting_name => $st->pivot->stok_produk
                );

               
           }


           }
        } */

        $produk = SellingProduk::findOrFail($selling_id);
        $getPivot = $produk->cutting_produks()->get();

        $catID = SellingProduk::where('id' , $selling_id)->get();
        foreach($catID as $ts){
            $cut_id = $ts->category_id;
        }
      
        $data_category = CuttingProduk::where('category_id' , $category_id)->latest()->get();
        if($category_id == $cut_id){
            return response()->json([$cut_id , $getPivot]);
        }else{
            return response()->json([$data_category , $getPivot ]);
        }

        

        /* foreach($allstok as $dt){
            foreach($dt as $d => $v){
                echo $d . ':' . $v;
            }
        } */

        
      
      
    }
}
