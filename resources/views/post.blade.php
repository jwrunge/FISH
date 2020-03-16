@extends('layouts.app')

@section('content')
<div class='content'>
    <div class='unboxed_content padded_ps topmargin toppadding col-12'>
        @if(isset($post))
            <h1>{{$post->header}}</h1>
            <p class='byline'>Posted by <strong>@if($post->user) {{$post->user->name}} @else Anonymous @endif</strong> on {{$post->created_at}}</p>
            @if($post->images)
                @if(count($post->images) > 1)
                    <div id='slideshow_{{$post->id}}' class='slideshow rounded'>
                        <img src='/images/prev.svg' class='left-ctrl'/>
                        <img src='/images/next.svg' class='right-ctrl'/>
                        @foreach($post->images as $key=>$image)
                            <img src='{{$image->src}}' class='displayable rounded @if($key==0) active @endif @switch($image->rotation)
                            @case(90) r1 @break
                            @case(180) r2 @break
                            @case(270) r3 @break
                            @endswitch' alt='{{$image->alt}}'/>
                        @endforeach
                    </div>
                @elseif(count($post->images) === 1)
                    <img class='float-right rounded postimg @switch($post->images[0]->rotation)
                    @case(90) r1 @break
                    @case(180) r2 @break
                    @case(270) r3 @break
                    @endswitch' src='{{$post->images[0]->src}}' alt='{{$post->images[0]->alt}}'/>
                @endif
            @endif
            {!!$post->content!!}
        @else
            <h1>Uh-oh!</h1>
            <p>Looks like the post you're looking for doesn't exist. Be sure to check the URL to ensure it is correct, or take a look through our <a href=>archives</a></p>
        @endif
        <br clear='both'/>

        <div class='row mt-5'>
            @if(Auth::user() && (Auth::user()->can('changepost', $post) || Auth::user()->role==='admin'))
                <div class='text-right col-12'>
                    <a href='/authorpost/{{$post->id}}'>edit</a> | <a href='/deletepostprompt/{{$post->id}}'>delete</a>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
