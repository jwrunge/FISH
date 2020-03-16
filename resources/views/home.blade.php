@extends('layouts.app')

@section('content')
<div class='content'>
    <div class='unboxed_content topmargin toppadding col-12'>
        <h1>{{Auth::user()->name}}'s Dash</h1>

        <h2>Your Posts</h2>
        <p><a href='/authorpost/new'>Write a new post</a></p>
        @if(Auth::user()->role === 'admin')
            <p>As the site administrator, you have the ability to edit any other user's post. You can find and edit posts in the <a href='/archive'>Archive</a>.</p>
        @endif

        @if(Auth::user()->posts)
            @foreach(Auth::user()->posts->sortByDesc('created_at') as $post) 
                <div class='row highlightable mb-2' style='max-width: 800px;'>
                    <div class='col-xs-12 col-md-8'>
                        {{Carbon\Carbon::parse($post->created_at)->format('d M Y')}}: {{$post->header}}
                    </div>
                    <div class='col-xs-12 col-md-4 text-right'>
                        <a href='/posts/{{$post->id}}'>view</a> | <a href='/authorpost/{{$post->id}}'>edit</a> | <a href='/deletepostprompt/{{$post->id}}'>delete</a>
                    </div>
                </div>
            @endforeach
        @else
            <p>You have not made any posts</p>
        @endif

        @if(Auth::user()->role === 'admin')
            <h2>Approve Editors</h2>
            @if($users = \App\User::where('role','')->get())
                <p>There are <strong>{{count($users)}}</strong> editors awaiting approval.</p>
                @foreach($users as $user) 
                    <div class='row highlightable mb-2' style='max-width: 800px;'>
                        <div class='col-xs-12 col-md-4'>
                            <span class='d-inline-block'>{{$user->name}}:</span> <a class='d-inline-block' href='mailto:{{$user->email}}'>{{$user->email}}</a>
                        </div>
                        <div class='col-xs-12 col-md-8 text-right'>
                            <a class='d-inline-block' href='/approveuser/{{$user->id}}'>approve as editor</a> | 
                            <a class='d-inline-block' href='/approveadmin/{{$user->id}}'>approve as admin</a> | 
                            <a class='d-inline-block' href='/declineuser/{{$user->id}}'>decline</a>
                        </div>
                    </div>
                @endforeach
            @else 
                <p>There are no editors awaiting approval</p>
            @endif

            <h2>Manage Editors</h2>
            @if($users = \App\User::where('role','!=','')->get())
                <p>There are <strong>{{count($users)}}</strong> approved editors.</p>
                @foreach($users as $user) 
                    <div class='row highlightable mb-2' style='max-width: 800px;'>
                        <div class='col-xs-12 col-md-4'>
                            <span class='d-inline-block'>{{$user->name}} ({{$user->role}}):</span> <a class='d-inline-block' href='mailto:{{$user->email}}'>{{$user->email}}</a>
                        </div>
                        <div class='col-xs-12 col-md-8 text-right'>
                            @if($user->role==='admin')
                                <a class='d-inline-block' href='/approveuser/{{$user->id}}'>demote to editor</a> | 
                            @else
                                <a class='d-inline-block' href='/approveadmin/{{$user->id}}'>promote to admin</a> | 
                            @endif
                            <a class='d-inline-block' href='/declineuser/{{$user->id}}'>revoke</a>
                        </div>
                    </div>
                @endforeach
            @else 
                <p>There are no editors awaiting approval</p>
            @endif
        @endif
    </div>
</div>
@endsection
