@extends('layouts.app')

@section('content')
<div class="content">
    <div class="unboxed_content topmargin toppadding col-12 justify-content-center">
        <div class='row'>
                <h1>Error 401: Unauthorized</h1>
        </div>

        <div class='row'>
            <p>Looks like you're trying to access authorized content. If you have permission to do so, make sure you are <a href='/login'>logged in</a>.</p>
            @if($exception->getMessage())
                <p>Specifics: {{ $exception->getMessage() }}</p>
            @endif
        </div>

    </div>
</div>
@endsection
