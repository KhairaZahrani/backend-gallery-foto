<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Foto::with('album')->get(); // Ambil foto dengan relasi album
        return view('gallery.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $albums = Album::all(); // Ambil semua album
        return view('gallery.create', compact('albums'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_album' => 'required|exists:album,id_album', // Pastikan id_album valid
        ]);

        // Proses upload gambar
        $imagePath = $request->file('gambar')->store('images', 'public');

        Foto::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'gambar' => $imagePath,
            'id_album' => $request->id_album,
            'id_user' => auth()->id(), // Menyimpan id pengguna yang membuat
        ]);

        return redirect()->route('gallery.index')->with('success', 'Foto berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $foto = Foto::findOrFail($id);
        return view('gallery.show', compact('foto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $foto = Foto::findOrFail($id);
        return view('gallery.edit', compact('foto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_album' => 'required|exists:album,id_album',
        ]);

        $foto = Foto::findOrFail($id);
        $foto->judul = $request->judul;
        $foto->deskripsi = $request->deskripsi;
        $foto->tanggal = $request->tanggal;
        $foto->id_album = $request->id_album;

        if ($request->hasFile('gambar')) {
            // Proses upload gambar baru
            $imagePath = $request->file('gambar')->store('images', 'public');
            $foto->gambar = $imagePath; // Update path gambar
        }

        $foto->save();

        return redirect()->route('gallery.index')->with('success', 'Foto berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $foto = Foto::findOrFail($id);
        $foto->delete();

        return redirect()->route('gallery.index')->with('success', 'Foto berhasil dihapus!');
    }
}
