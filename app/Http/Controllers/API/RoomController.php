<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\RoomResource;

class RoomController extends Controller
{
    public function getRoom(){
        //get semua ruangan
        $getRoom = Room::all();

        // return response()->json([
        //     'data' => $getRoom
        // ], 200);


        // buat front end
        return RoomResource::collection($getRoom);

    }

    public function getDetailRoom($slug){
        $getSlug = Room::where('slug',$slug)->first();
        return response()->json([
            'data' => $getSlug
        ], 200);
    }

    public function updateRoom(Request $request,$slug){
        $getSlug = Room::where('slug',$slug)->first();
        
        $getSlug->update([
            'room' => $request->ruangan,
            'capacity' => $request->kapasitas,
            'description' => $request->deskripsi
        ]);

        return response()->json([
            'message' => 'Ruangan berhasil diupdate',
            'data' => $getSlug
        ]);
    }

    public function addRoom(Request $request){
        $slug = Str::slug($request->ruangan);
        $room = Room::create([
            'room_name' => $request->ruangan,
            'slug' => $slug,
            'capacity' => $request->kapasitas,
            'description' => $request->deskripsi
        ]);

        return response()->json([
            'message' => 'Ruangan berhasil ditambahkan',
            'data' => $room
        ]);

    }

    public function deleteRoom($slug){
        $getSlug = Room::where('slug',$slug)->first();

        $getSlug->delete();
        return response()->json([
            'message' => 'Ruangan berhasil dihapus',
            'data' => $getSlug
        ]);

    }


}

