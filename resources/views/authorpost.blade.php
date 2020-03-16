@extends('layouts.app')

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class='content'>
    <div class='unboxed_content topmargin toppadding col-12'>
        @if($post)
            <form method='post' action='/savepost/{{$post->id}}' enctype='multipart/form-data'>
        @else
            <form method='post' action='/savepost/new' enctype='multipart/form-data'>
        @endif
            @csrf

            <h1>Author a Post</h1>

            @if($errors->any())
                <div class='alert alert-danger'>
                    <p>Oops! There are some errors in your post.</p>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class='form-group'>
                <label for='post_header'>Header</label>
                <input type='text' name='header' @if($post) value="{{$post->header}}" @endif class='form-control' id='post_header' placeholder='An Engaging Header'/>
            </div>
            <div class='form-group aboveall'>
                <label for='editor'>Content</label>
                <div id='editor'>
                    @if($post) {!!$post->content!!}
                    @endif
                </div>
                <input type='hidden' name='content'/>
                <input type='hidden' name='removeimgs'/>
                <input type='hidden' name='r1'/>
                <input type='hidden' name='r2'/>
                <input type='hidden' name='r3'/>
            </div>

            <div class='form-group behindall'>
                <label>Add images</label>
                <div class='input-group'>
                    <div class='custom-file'>
                        <input type='file' name='images[]' class='custom-file-input' id='image_uploader' multiple>
                        <label class='custom-file-label' for='image_uploader'>Upload image...</label>
                    </div>
                </div>
                <br/>
                <label>Pending uploads:</label>
                <p id='upload_list' class='form-control' style='word-wrap: normal;'>None</p>

                <label>Current images (click to remove):</label>
                <p class='form-control expandtofit'>
                    @if($post && count($post->images) > 0)
                        @foreach($post->images as $image)
                            <span class='img_container'>
                                <img class='tinyimg @switch($image->rotation)
                                    @case(90) r1 @break
                                    @case(180) r2 @break
                                    @case(270) r3 @break
                                @endswitch' data-id='{{$image->id}}' src='{{$image->src}}' alt='{{$image->alt}}'/>
                                <a class='removeimg' data-id='{{$image->id}}'><img src='/images/del.svg' alt='delete'></a>
                                <a class='rotateimg' data-id='{{$image->id}}'><img src='/images/rot.png' alt='rotate'></a>
                            </span>
                        @endforeach
                    @else
                        None
                    @endif
                </p>
            </div>

            <div class='form-group text-right'>
                <button type="submit" class="btn btn-primary mx-1">
                    @if($post) Edit 
                    @else Post 
                    @endif
                </button>
                <a href='/home'><button type='button' class='btn btn-danger mx-1'>Cancel</button></a>
            </div>
        </form>
    </div>
</div>

<div id='message'>
    <div id='blackground'></div>
    <div id='message-content'>
        <h2>Please be patient!</h2>
        <p>If you have added images, it will take some time to upload and optimize them.</p>
    </div>
</div>

<style>

    #post_header {
        font-family: 'Alegreya', serif;
        font-weight: bold;
        color: #064374;
        margin-bottom: 0;
        margin-top: 0;
        font-size: 1.5em;
    }

    .ql-snow .ql-picker.ql-expanded .ql-picker-options {
        z-index: 5;
    }

    .expandtofit {
        height: auto;
        overflow: hidden;
    }

</style>

<script src='https://cdn.quilljs.com/1.3.6/quill.js'></script>
<script>
    var editor = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Your story goes here!'
    })

    $('form').on('submit', function(){
        $('input[name=content]').val(editor.root.innerHTML)
        $('#message').css('display', 'flex')
        $('#message').children().css('display', 'block')

        //Get list of images to remove
        var toremove = ''
        $('img.removed').each(function(){
            toremove += $(this).attr('data-id') + ','
        })
        toremove = toremove.substring(0, toremove.length - 1)
        $('input[name=removeimgs]').val(toremove)

        //Get list of images to rotate
        var r1 = '', r2 = '', r3 = ''
        $('img.r1').each(function(){
            r1 += $(this).attr('data-id') + ','
        })
        $('img.r2').each(function(){
            r2 += $(this).attr('data-id') + ','
        })
        $('img.r3').each(function(){
            r3 += $(this).attr('data-id') + ','
        })

        //Rotatees
        r1 = r1.substring(0, r1.length - 1)
        $('input[name=r1]').val(r1)

        r2 = r2.substring(0, r2.length - 1)
        $('input[name=r2]').val(r2)

        r3 = r3.substring(0, r3.length - 1)
        $('input[name=r3]').val(r3)

        console.log(r1)
        console.log(r2)
        console.log(r3)

        //Prevent multiple submissions
        $('form').on('submit', function() {
            return false;
        })
    })

    $('.removeimg').on('click', function(){
        $('img.tinyimg[data-id=' + $(this).attr('data-id') + ']').toggleClass('removed')
    })

    $('.rotateimg').on('click', function(){
        let torotate = $('img.tinyimg[data-id=' + $(this).attr('data-id') + ']')
        if(torotate.hasClass('r1')) torotate.removeClass('r1').addClass('r2')
        else if(torotate.hasClass('r2')) torotate.removeClass('r2').addClass('r3')
        else if(torotate.hasClass('r3')) torotate.removeClass('r3')
        else torotate.addClass('r1')
    })

    $('#image_uploader').on('change', function(){
        var files = $('#image_uploader').prop('files')
        if(files.length){
            var filenames = $.map(files, function(val) { return val.name + "; "; })
            $('#upload_list').html(filenames)
        }
        else $('#upload_list').html("None")
    })

    $('#image_uploader').change()
</script>

@endsection
