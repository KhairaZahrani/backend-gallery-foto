@extends('layouts.app')
@section('judul', 'Gallery Foto')

@section('content')
<a href="/gallery/create">Tambah</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Album</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>
                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" style="width: 100px; height: auto;">
                </td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->album->nama_album ?? 'Tidak ada album' }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('foto.edit', $item->id_foto) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('foto.destroy', $item->id_foto) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
