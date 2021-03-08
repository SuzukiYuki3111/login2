<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // 一覧表示
    public function index()
    {
        $places = Place::paginate();
        return view ('places.index', compact('Places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // 追加画面表示
    public function create()
    {
        return view ('Places.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        //バリデーション（入力チェック）
        $data = $request->validate([
            "name" => 'required|string',
            "description" => 'required|string',
            "map_url" => 'required|url',
            "img" => 'required|file',
        ]);

        // placesフォルダを作り、保存する
        $path = Storage::putFile('places', $data['img']);
        $data['img'] = $path;

        // $data['user_id']としてログインしているユーザーのIDを代入
        $data['user_id'] = Auth::user()->id;

        // データベースに格納
        $place = Place::create('data');

        // 場所詳細ページに遷移させる
        return redirect()->to(route('places.show', compact('place')));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */

    // 詳細表示画面
    public function show(Place $place)
    {
        return view ('Places.show',compact('Place'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */

    // 修正画面
    public function edit(Place $place)
    {
        return view ('Places.modify',compact('Place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        //
    }
}
