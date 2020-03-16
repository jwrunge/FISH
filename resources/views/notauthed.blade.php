@extends('layouts.app')

@section('content')
<div class="content">
    <div class="unboxed_content topmargin toppadding">
        <h1>Waiting on Approval</h1>

        <p>Thanks for your request! Now you just need to wait for a site administrator to approve your access privileges. Please get in touch with a site administrator.</p>
        <form method='POST' action='/logout'>
            @csrf
            <input type='submit' class='btn btn-link m-0' value='Log out'/>
        </form>

    </div>
</div>
@endsection
