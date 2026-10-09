<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Work::all();
    }

       /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Work = Work::create($request->all());
    
        return [
            "data" => $Work
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // On renvoie l'œuvre dont l'id est le même que $id, avec ses exemplaires ('examples' est la fonction définie dans le modèle Work)
        // find($id) renvoie le premier
        return Work::with('examples')->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Work::where('id', $id)->delete();
    }
}