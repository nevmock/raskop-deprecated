<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Room extends Model
{
    use HasFactory;

    protected $table = 'room';

    protected $primaryKey = 'id_room';

    protected $fillable = [
        'room_name',
        'image_url',
        'slug',
        'capacity',
        'description',
    ];


    public static function boot()
    {
        parent::boot();

        static::deleting(function($model){
            // delete data image from cloudinary
            Storage::disk('cloudinary')->delete($model->image_url);
            $model->category()->detach();
        });
    }

    public function getImage(){
        $image_ext = explode('.', $this->image_url);
        $image_ext = end($image_ext);
        return env('CLOUDINARY_URL').$this->image_url.'.'.$image_ext;
    }



}
