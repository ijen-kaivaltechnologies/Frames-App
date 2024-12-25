<?php

namespace App\Models;
use App\Models\Frames;
use Illuminate\Database\Eloquent\Model;

class Catagory extends Model
{
    protected $table = 'catagories';

    protected $fillable = [
        'priority',
        'catagory_name',
        'catagory_url',
    ];


    public function frames()
    {
        return $this->hasMany(Frames::class, 'catagory_id');
    }
    

}
