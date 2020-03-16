@extends('layouts.app')

@section('content')
<div class='content'>
    <div class='unboxed_content topmargin toppadding'>
        <h1>Archives</h1>
        @if(isset($posts))
            <?php $month = '' ?>
            @foreach($posts as $post)
                @if(Carbon\Carbon::parse($post->created_at)->format('M Y') !== $month)
                    @if($month !== '') </ul> @endif
                    <?php $month = Carbon\Carbon::parse($post->created_at)->format('M Y') ?>
                    <h2>{{Carbon\Carbon::parse($post->created_at)->format('M Y')}}</h2>
                    <ul>
                @endif
                <li>
                    <a href='posts/{{$post->id}}'>
                        {{Carbon\Carbon::parse($post->created_at)->format('d M Y')}}: <strong>{{$post->header}}</strong>
                    </a>
                    @if(Auth::user() && (Auth::user()->can('changepost', $post) || Auth::user()->role==='admin'))
                        | <a href='/authorpost/{{$post->id}}'>edit</a> | <a href='/deletepostprompt/{{$post->id}}'>delete</a>
                @endif
                </li>
            @endforeach
            </ul>
        @endif
    </div>

</div>

@endsection
