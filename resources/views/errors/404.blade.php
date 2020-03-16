@extends('layouts.app')

@section('content')
<div class="content">
    <div class="unboxed_content topmargin toppadding col-12 justify-content-center">
        <div class='row'>
                <h1>Error 404: Page not found</h1>
        </div>

        <div class='row'>
            <p>I'm sorry - it doesn't look like we have the page you're looking for. Head back <a href='/'>home</a>.</p>
            @if($exception->getMessage())
                <p>Specifics: {{ $exception->getMessage() }}</p>
            @endif
        </div>

    </div>
</div>
@endsection
