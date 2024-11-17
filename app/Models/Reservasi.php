<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservasi extends Model
{
    use HasFactory;
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';

    protected $fillable = [
        'kode_reservasi',
        'id_room',
        'id_customer',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room', 'id_room');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
