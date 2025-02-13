<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';

    protected $primaryKey = 'id_komentar';

    protected $fillable = ['id_foto','id_user','komentar','tanggal'];

}
