<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlacesController extends Controller
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
        return view ('places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // 追加画面表示
    public function create()
    {
        return view ('places.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // 新規作成
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
        $place = Place::create($data);

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
        return view ('places.show',compact('place'));
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
        return view ('places.modify',compact('place'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */

    // 更新
    public function update(Request $request, Place $place)
    {
        if($place->user_id != Auth::user()->id){
            abort(403);
        }

         //リクエストバリデーション
         $data = $request->validate([
            "name" => 'required|string',
            "description" => 'required|string',
            "map_url" => 'required|url',
            "img" => 'file',
        ]);

        // ファイルがあったら、保存済みのファイルを削除＆新しいファイルの取得
        if(isset($data['img'])){
            Storage::delate($place->img);
            $path = Storage::putFile('places', $data['img']);
            $data['img'] = $path;
        }

        // データベースをアップデート
        $place->update($data);

        // その後、場所詳細ページに移動する
        return redirect()->to(route('places.show', compact('place')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */

    // 削除
    public function destroy(Place $place)
    {
        if($place->user_id != Auth::user()->id){
            abort(403);
        }

        $place->delate();
        return redirect()->to(route('place.index'));
    }
}
