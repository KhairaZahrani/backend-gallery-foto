<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';

    protected $primaryKey = 'id_foto';

    protected $fillable = ['judul','deskripsi','tanggal','gambar','id_album','id_user'];

}
