<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'email', 'phone_number'];       // model iniberarti kolom mana yg bole di isi
    //protected $guarded = [];        //--model ini artinya ngga boleh di isi
}
