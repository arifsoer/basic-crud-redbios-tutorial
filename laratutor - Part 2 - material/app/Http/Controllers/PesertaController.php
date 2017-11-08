<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Peserta;
use App\Http\Resources\Peserta as PesertaResource;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PesertaResource::collection(Peserta::all());
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
          'name' => 'required',
          'email' => 'required|email'
        ]);

        $peserta = new Peserta;
        $peserta->name = $request->name;
        $peserta->email = $request->email;
        $peserta->save();

        return response()->json(['peserta' => Peserta::find($peserta->id)]);
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
        'name' => 'required',
        'email' => 'required|email'
      ]);

      $peserta = Peserta::find($id);
      $peserta->name = $request->name;
      $peserta->email = $request->email;
      $peserta->save();

      return response()->json(['message' => 'Berhasil simpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peserta = Peserta::find($id);
        $peserta->delete();

        return response()->json(['message' => 'Berhasil dihapus']);
    }
}
