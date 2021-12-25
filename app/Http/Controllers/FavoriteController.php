<?php

namespace App\Http\Controllers;

use App\Models\Barbie;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorites = Favorite::all();

        return response([
            "favorites" => $favorites,
            "message" => "Uspesno",
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        $barbie = Barbie::find($request->barbie_id);

        if (!$user || !$barbie) {
            return response([
                'favorite' => null,
                'message' => 'User / Barbie nisu pronadjeni.',
            ], 400);
        }

        // VALIDATE DATA
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'barbie_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response([
                'favorite' => null,
                'message' => 'Validacija neuspesna.',
                'errors' => $validator->messages(),
            ], 400);
        }

        $favorite = new Favorite();

        $favorite->user_id = auth()->user()->id;
        $favorite->barbie_id = $request->barbie_id;

        $favorite->save();

        return response([
            "favorite" => $favorite,
            "message" => "Uspeh.",
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $favorite = Favorite::find($id);

        if (!$favorite) {
            return response([
                'favorite' => null,
                'message' => 'Nije pronadjeno.',
            ], 404);
        }

        return response([
            "favorite" => $favorite,
            "message" => "Uspeh",
        ], 200);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorite = Favorite::find($id);

        if (!$favorite) {
            return response([
                'favorite' => null,
                'message' => 'Nije pronadjeno.',
            ], 404);
        }

        if (auth()->user()->id != $favorite->user_id) {
            return response([
                "favorite" => $favorite,
                "message" => "Unauthorized.",
            ], 401);
        }

        $favorite->delete();

        return response([
            "favorite" => $favorite,
            "message" => "Uspeno iybrisano.",
        ], 200);
    }
}
