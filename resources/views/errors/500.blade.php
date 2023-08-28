@extends('layouts.app')

@section('content')
<div class="content">
    <div class="unboxed_content topmargin toppadding col-12 justify-content-center">
        <div class='row'>
                <h1>Error 500: Server Error</h1>
        </div>

        <div class='row'>
            <p>Something isn't set up right on our end! Please <a href='mailto:fish@fishofgalesburg.org'>contact us</a> and let us know what isn't working. We'll fix it!</p>
            @if($exception->getMessage())
                <p>Specifics: {{ $exception->getMessage() }}</p>
            @endif
        </div>

    </div>
</div>
@endsection
