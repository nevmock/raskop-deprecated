<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'kode_reservasi' => $this->kode_reservasi,
            'tanggal' => $this->tanggal,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'status' => $this->status,
            'ruangan' => [
                'nama_ruangan' => $this->room->room_name,
                
                'kapasitas' => $this->room->capacity,
                'deskripsi' => $this->room->description,
            ],
            'pelanggan' => [
                'nama' => $this->customer->name,
                'nomer' => $this->customer->phone,
                'fakultas' => $this->customer->faculty,
                'order' => $this->customer->order,
                'note' => $this->customer->note,
            ],
        ];
        
    }
}
