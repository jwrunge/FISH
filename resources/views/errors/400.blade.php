@extends('layouts.app')

@section('content')
<div class="content">
    <div class="unboxed_content topmargin toppadding col-12 justify-content-center">
        <div class='row'>
                <h1>Error 400: Bad Request</h1>
        </div>

        <div class='row'>
            <p>Something in the data you sent us doesn't look quite right. Head back <a href='/'>home</a> and try again.</p>
            @if($exception->getMessage())
                <p>Specifics: {{ $exception->getMessage() }}</p>
            @endif
        </div>

    </div>
</div>
@endsection
