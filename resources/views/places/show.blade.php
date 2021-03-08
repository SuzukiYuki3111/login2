@extends('layout')

@section('contents')

<div>
    <h1>場所詳細</h1>

    <table>
        <tr>
            <th>写真</th>
            <td>
                <img src="{{ asset('strage/' .$place->img) }}">
            </td>
        </tr>
        <tr>
            <th>名称</th>
            <td>
                {{ $place->name }}
            </td>
        </tr>
        <tr>
            <th>詳細</th>
            <td>
                {{!! nl2br($place->description) !!}}
            </td>
        </tr>
        <tr>
            <th>マップURL</th>
            <td>
                <a href="{{ $place->map_url }}" target="_blank">確認</a>
            </td>
        </tr>
    </table>

    @if ($place->user->id === Auth::user()->id)
        {{-- <a href="{{ route('places.index') }}">一覧</a> --}}
        <a href="{{ route('places.edit', compact('place')) }}">修正</a>
        <form action="{{ route('places.destroy', compact('place')) }}">
            @method('delete')
            @csrf
            <button type="submit">削除</button>
        </form>
    @endif
</div>

@endsection
