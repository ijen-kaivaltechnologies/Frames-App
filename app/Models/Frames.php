<?php

namespace App\Models;
use App\Models\Catagory;
use Illuminate\Database\Eloquent\Model;

class Frames extends Model
{
   protected $fillable = [
   'catagory_id',
    'image_url',
    'is_premium',
    'is_popular',
   ];

   public function catagory()
   {
      return $this->belongsTo(Catagory::class, 'catagory_id');
   }

}
