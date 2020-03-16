@extends('layouts.app')

@section('content')

<div class='content'>

    <div class='unboxed_content topmargin toppadding col-12'>
        <div class='col-12'>
            <h1>Are you sure?</h1>
            <p>Are you sure you want to delete this post? You will not be able to recover it.</p>
        </div>

        <div class='col-12'>
            <a href='/deletepost/{{$postid}}'><button class='btn btn-danger mx-1'>Delete it</button></a>
            <a href='/home'><button class='btn btn-primary mx-1'>Never mind</button></a>
        </div>
    </div>
</div>

@endsection
