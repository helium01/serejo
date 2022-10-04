<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\tb_profil;
use App\Models\tb_tentang;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $profils = new tb_profil();
        $profils = $profils->leftJoin('tb_tentangs', 'tb_tentangs.id', '=', 'tb_profils.id_tentang');
        $profils = $profils->select('tb_profils.*', 'tb_tentangs.nama as nama');
        $profils = $profils->get();
        return view('pages.profil.index', ['profils' => $profils]);
    }

    public function create()
    {
        $tentang = tb_tentang::all();
        return view('pages.profil.create')->with(['tentang' => $tentang]);
    }

    public function store(Request $request)
    {
        $profil = new tb_profil();
        $profil->id_tentang = $request->id_tentang;
        $profil->moto = $request->moto;
        $profil->foto_1 = $request->foto_1;
        $profil->foto_2 = $request->foto_2;
        $profil->foto_3 = $request->foto_3;
        $profil->save();
        return redirect()->route('profil.index')->with('message', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $profil = tb_profil::find($id);
        $tentang = tb_tentang::all();
        return view('pages.profil.edit', ['profil' => $profil, 'tentang' => $tentang]);
    }

    public function update(Request $request, $id)
    {
        $profil = tb_profil::find($id);
        $profil->id_tentang = isset($request->id_tentang) ? $request->id_tentang : $profil->id_tentang;
        $profil->moto = isset($request->moto) ? $request->moto : $profil->moto;
        $profil->foto_1 = isset($request->foto_1) ? $request->foto_1 : $profil->foto_1;
        $profil->foto_2 = isset($request->foto_2) ? $request->foto_2 : $profil->foto_2;
        $profil->foto_3 = isset($request->foto_3) ? $request->foto_3 : $profil->foto_3;
        $profil->save();
        return redirect()->route('profil.index')->with('message', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $profil = tb_profil::find($id);
        $profil->delete();
        return redirect()->route('profil.index')->with('message', 'Data berhasil dihapus');
    }
}