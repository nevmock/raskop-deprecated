<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Models\Room;
use App\Models\Customer;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use App\Http\Resources\ReservasiResource;
use App\Models\Whatsapp;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class ReservasiController extends Controller
{
    public function getReservasi(){
        $getAllReservasi = Reservasi::with(['room','customer'])->get();

        return ReservasiResource::collection($getAllReservasi);
    }

    public function addReservasi(Request $request){

        $getRoom = Room::where('id_room',$request->ruangan)->first();


        $kapasitasRuangan =  $getRoom->capacity;
        //pelanggan
        $nama = $request->nama;
        $nomer  = $request->nomer;
        $fakultas = $request->fakultas;
        $pesanan = $request->pesanan;
        $note = $request->note;
        $jumlah = $request->jumlah;

        //Logic reservasi beli
        preg_match_all('/\d+/', $pesanan, $matches);
        // Mengonversi angka-angka yang ditemukan menjadi integer dan menjumlahkannya
        $total_sum_order = array_sum(array_map('intval', $matches[0]));
      

        $minimOrder = 0.7; //Customer order harus melebihi 70%

        $percentage = $jumlah*$minimOrder;
      


        //reservasi
        $inputTanggal = $request->tanggal;
        $ruangan = $request->ruangan;
        $jamMulai = $request->mulai;
        
        // Calculate end time by adding 3 hours to the start time
        $jamSelesai = strtotime($jamMulai) + (3 * 3600);
        
        // Convert input date to database format
        $date = Carbon::createFromFormat('d-m-Y', $inputTanggal);
        $dateForDatabase = $date->toDateString();
        
        // Format the start and end times without seconds
        $formattedTimeMulai = date("H:i:00", strtotime($jamMulai));
        $formattedTimeSelesai = date("H:i:00", $jamSelesai);
        
        // Check if the specified date and time are in the past
        $timezone = 'Asia/Jakarta'; // You should replace this with your actual time zone
        Carbon::setLocale('id'); // Set the locale to Indonesian if needed
        
        $currentDateTime = Carbon::now($timezone);
        $requestedDateTime = $date->setTimezone($timezone)->setTimeFromTimeString($formattedTimeMulai);
        
        if ($requestedDateTime < $currentDateTime) {
            // The requested date and time are in the past, handle accordingly
            return response()->json(['error' => 'Tidak dapat melakukan reservasi, jam atau tanggal sudah lewat']);
        }
        // Check if the room is already reserved for the given date and time
        if (Reservasi::where('id_room', $ruangan)
            ->where('tanggal', $dateForDatabase)
            ->where(function ($query) use ($formattedTimeMulai, $formattedTimeSelesai) {
                $query->where(function ($query) use ($formattedTimeMulai, $formattedTimeSelesai) {
                    $query->where('jam_mulai', '>=', $formattedTimeMulai)
                        ->where('jam_mulai', '<', $formattedTimeSelesai);
                })->orWhere(function ($query) use ($formattedTimeMulai, $formattedTimeSelesai) {
                    $query->where('jam_selesai', '>', $formattedTimeMulai)
                        ->where('jam_selesai', '<=', $formattedTimeSelesai);
                });
            })
            ->exists()) {
            // Room is already reserved for the given date and time, handle accordingly
            return response()->json(['error' => 'Room is already reserved for the given date and time.']);
        }

        if($kapasitasRuangan < $jumlah or $percentage > $total_sum_order ) {
            return response()->json([
                'error' => 'Gagal melakukan reservasi karena melibihi kapasitas atau pembelian kurang dari 70%'
            ]);
        }


        //RandomAngka
        $characters = '0123456789';
        $randomString = '';

        $length = 4; // Ganti dengan panjang string yang diinginkan

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        //Customers insert
        $customer = Customer::create([
            'name' => $nama,
            'phone' => $nomer,
            'faculty' => $fakultas,
            'order' => $pesanan,
            'note' => $note,
            'reservation_count' => $jumlah
        ]);
        
        // Proceed with creating the reservation
        $reservasi = Reservasi::create([
            'kode_reservasi' => 'RAS'.$randomString,
            'id_room' => $ruangan,
            'id_customer' => $customer->id,
            'tanggal' => $dateForDatabase,
            'jam_mulai' => $formattedTimeMulai,
            'jam_selesai' => $formattedTimeSelesai
        ]);
        $send_whatsapp_status = $this->sendWhatsappMessage($nomer,$reservasi->kode_reservasi);
        // Return a success response or perform any additional actions
        return response()->json(['success' => 'Reservasi telah terbuat dengan Code '.$reservasi->kode_reservasi.' dan code berhasil dicopy', 'kode_reservasi' => $reservasi->kode_reservasi]);
        
    }

    protected function sendWhatsappMessage($number,$kodeReservasi)
    {   
        try{
            $client = new Client();
            $user = Whatsapp::first();
            $accessToken = $user->access_token;
            $deviceName = $user->device_name;
            $response = $client->request('POST',env('WHATSAPP_URL').'/api/send-message',[
                'headers' => [
                    'x-access-token' => $accessToken,
                ],
                'form_params' => [
                    'number' => $number,
                    'message' => "Selamat anda berhasil melakukan reservasi dengan kode : *".$kodeReservasi."*"."\n\n"."harap tunggu admin kami untuk memverifikasi apakah pesanan anda diterima/ditolak",
                    'token'=> $deviceName
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            return $response;
        }catch(ClientException $e){
            $res = $e->getResponse()->getStatusCode();
            if($res == 401){
                $token = $this->requestLogin();
                if($token){
                    $whatsappInstance = Whatsapp::first();
                    $whatsappInstance->update([
                        'access_token' => $token
                    ]);
                    $this->sendWhatsappMessage($number,$kodeReservasi);
                }
            }
        }
        catch(ConnectException $e){
            return false;
        }
    }

    protected function requestLogin()
    {
        try{
            $client = new Client();
            $whatsappInstance = Whatsapp::first();
            $response = $client->request('POST', env('WHATSAPP_URL').'/api/signin', [
                // sent form-data
                'form_params' => [
                    'email' => $whatsappInstance->email,
                    'password'=> $whatsappInstance->password,
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            if($response->status){
                return $response->token;
            }
            return false;
        }
        catch(ClientException $e){
            return false;
        }
        catch(ConnectException $e){
            return false;
        }
    }

    public function getAvailableReservations(Request $request){
        $date = $request->input('date');
        $room_id = $request->input('room_id');

        // Mengambil data reservasi dari database berdasarkan tanggal dan ruangan
        $reservedTimes = Reservasi::where('id_room', $room_id)
            ->where('tanggal', $date)
            ->get(['jam_mulai', 'jam_selesai'])
            ->toArray();

        // Menginisialisasi daftar waktu yang tersedia dari 06:00 hingga 18:00
        $availableTimes = [['start_time' => '06:00', 'end_time' => '18:00']];

        // Iterasi melalui waktu yang telah dipesan dan kurangkan dari waktu yang tersedia
        foreach ($reservedTimes as $reservedTime) {
            $start = strtotime($reservedTime['jam_mulai']);
            $end = strtotime($reservedTime['jam_selesai']);

            foreach ($availableTimes as $key => $availableTime) {
                $availStart = strtotime($availableTime['start_time']);
                $availEnd = strtotime($availableTime['end_time']);

                // Jika waktu yang dipesan berada di dalam waktu yang tersedia
                if ($start < $availEnd && $end > $availStart) {
                    // Ubah waktu yang tersedia sesuai dengan waktu yang dipesan
                    if ($start <= $availStart && $end >= $availEnd) {
                        unset($availableTimes[$key]);
                    } else {
                        if ($start <= $availStart) {
                            $availableTimes[$key]['start_time'] = date('H:i', $end);
                        } elseif ($end >= $availEnd) {
                            $availableTimes[$key]['end_time'] = date('H:i', $start);
                        } else {
                            // Pisahkan waktu yang dipesan menjadi dua bagian
                            $newTimeSlot = [
                                'start_time' => date('H:i', $end),
                                'end_time' => date('H:i', $availEnd),
                            ];
                            array_push($availableTimes, $newTimeSlot);
                            $availableTimes[$key]['end_time'] = date('H:i', $start);
                        }
                    }
                }
            }
        }

        // Ambil waktu yang tersedia dalam format yang diinginkan
        $result = [];
        foreach ($availableTimes as $timeSlot) {
            $startTime = strtotime($timeSlot['start_time']);
            $endTime = strtotime($timeSlot['end_time']);
            $currentTime = $startTime;

            while ($currentTime < $endTime) {
                $result[] = date('H:i', $currentTime);
                $currentTime = strtotime('+1 minutes', $currentTime);
            }
        }

        return response()->json(['available_times' => $result]);

    }


    public function reservationsTimeCheck(Request $request){
        // Validasi input request jika diperlukan
        $request->validate([
            'room_id' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
        ]);

        // Ambil data dari request
        $roomID = $request->input('room_id');
        $date = $request->input('date');

        // Dapatkan daftar reservasi untuk ruangan dan tanggal tertentu
        $existingReservations = Reservasi::where('id_room', $roomID)
            ->where('tanggal', $date)
            ->get();

        // Inisialisasi array untuk menyimpan jam yang sudah direservasi
        $reservedTimes = [];

        // Loop melalui setiap reservasi dan tambahkan jam ke dalam array
        foreach ($existingReservations as $reservation) {
            // Periksa status reservasi, jika 'pending' atau 'approved', tambahkan ke array
            if ($reservation->status === 'pending' || $reservation->status === 'approved') {
                $startDateTime = $reservation->tanggal . ' ' . $reservation->jam_mulai;
                $endDateTime = $reservation->tanggal . ' ' . $reservation->jam_selesai;
        
                // Tambahkan rentang waktu ke dalam array
                $reservedTimes[] = [
                    'start_time' => date('H:i', strtotime($startDateTime)),
                    'end_time' => date('H:i', strtotime($endDateTime)),
                ];
            }
        }

        // Mengembalikan respons JSON dengan waktu yang sudah direservasi
        return response()->json(['reserved_times' => $reservedTimes]);
    
    }


    public function cekReservasi(Request $request){
        $kodeReservasi = $request->kode;

        $reservasi = Reservasi::with(['room','customer'])
                                ->where('kode_reservasi',$kodeReservasi)->get();

        return ReservasiResource::collection($reservasi);

    }

    public function updateReservasi(Request $request,$kodeReservasi){
       $reservasiData = Reservasi::where('kode_reservasi',$kodeReservasi)->first();

       if(!$reservasiData){
            return response()->json([
                'data' => null
            ]);
       }

       
       $reservasiData->update([
        'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Reservasi berhasil di update'
        ]);

    }

}
