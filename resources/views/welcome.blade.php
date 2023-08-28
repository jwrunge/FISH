@extends('layouts.app')

@section('content')
<div class="lead_img">
    <div style='position: relative;'>
        <img id='hero_img' src='/images/fish_lead_min.jpg' alt=""/>
        <a href='http://www.unitedway-knoxcounty.org/' target='_blank'><img id='uwlogo' src='images/unitedway.jpg' alt='We are a United Way agency'/></a>
    </div>
    <div class='hero_box'>
        <div class='p-3 flex-row d-sm-flex d-xs-block flex-wrap align-items-center justify-content-center'>
            <img class='ml-sm-0 mr-sm-3 d-block mx-auto' src='/images/fish_logo_white.svg' alt="FISH Food Pantry logo"/>
            <div class='attention_box d-block text-center'>
                <h1><span class='d-inline-block'>Providing Food</span> <span class='d-inline-block'>for Those in Need</span></h1>
                <div>
                    <a href='assistance'><button type='button' class='btn'>Get Assistance</button></a>
                    <a href='http://paypal.me/fishofgalesburg' target='_blank'><button type='button' class='btn'>Donate <img class='d-inline mx-0' style='max-width: 1.5em; max-height: 1.5em;' src='images/ppcom-white.svg'/></button></a>
                    <a href='about#volunteer'><button type='button' class='btn'>Volunteer</button></a>
                    <div class="financials">For financial information, contact <a href="https://web.archive.org/web/20230610073933/mailto:fish@fishofgalesburg.org">fish@fishofgalesburg.org.</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='content'>
    <div class='unboxed_content col-12 mb-5'>
        <h1>What's new at FISH?</h1>
        <p class='nopadding'>For more news and information, be sure to check out our <a target='_blank' href='https://www.facebook.com/FishOfGalesburg/'>Facebook page</a>!
        <br/><a href='/archive'>View News Archives</a></p>
    </div>

    @if(isset($posts))
        @foreach($posts as $post)
            <div class='post_box rounded'>
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

                    <h2>{{$post->header}}</h2>
                    <p class='byline'>Posted by <strong>@if($post->user) {{$post->user->name}} @else Anonymous @endif</strong> on {{Carbon\Carbon::parse($post->created_at)->format('d M Y')}}</p>
                    {!!$post->content!!}
                    <br clear='both'/>
                    @if(Auth::user() && (Auth::user()->can('changepost', $post) || Auth::user()->role==='admin'))
                        <div class='text-right'>
                            <a href='/authorpost/{{$post->id}}'>edit</a> | <a href='/deletepostprompt/{{$post->id}}'>delete</a>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    @endif
</div>

@endsection
