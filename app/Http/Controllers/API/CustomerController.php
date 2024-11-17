<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Room;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getCustomer(){
        $getCustomer = Customer::all();
        return response()->json([
            'data' => $getCustomer
        ],200);
    }

    public function addCustomer(Request $request){
        $customer = Customer::create([
            'name' => $request->nama,
            'phone' => $request->nomer,
            'faculty' => $request->fakultas,
            'order' => $request->pesanan,
            'note' => $request->note
        ]);

        return response()->json([
            $customer
        ],200);


    }


    public function testpelanggan(Request $request){

        $getRoom = Room::where('id_room','5')->first();


        $kapasitasRuangan =  $getRoom->capacity;

        


        $input_string = $request->order;
        
        preg_match_all('/\d+/', $input_string, $matches);
        // Mengonversi angka-angka yang ditemukan menjadi integer dan menjumlahkannya
        $total_sum_order = array_sum(array_map('intval', $matches[0]));
        $total_reservation = $request->reservation_count;
        var_dump($total_reservation);

        $minimOrder = 0.7; //Customer order harus melebihi 70%

        $percentage = $total_reservation*$minimOrder;

        if($kapasitasRuangan <= $total_reservation and $percentage > $total_sum_order  ) {
            echo 'KWKKWKWKWKW';
        }else{
            echo 'Berhasil bro';
        }

        // if($total_sum_order >= $percentage){
        //     $customerDatabase = Customer::create([
        //         'name' => $request->name,
        //         'phone' => $request->phone,
        //         'faculty' => $request->faculty,
        //         'order' => $request->order,
        //         'note' => $request->note,
        //         'reservation_count' => $request->reservation_count,
        //     ]);
        //     return response()->json([
        //         'message' => 'Berhasil brooooooooooooooooooooooo'
        //     ]);
        // }else {
        //     echo "Anda harus membeli 70% dari total pengunjung";
        // }


       

        

    }
}
