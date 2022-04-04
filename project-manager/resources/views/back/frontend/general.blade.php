@extends('back.layouts.master')
@section('title', 'General settings')

@section('master')
<form action="{{route('back.frontend.general')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card border-light mt-3 shadow">
        <div class="card-body">
            <div class="form-group">
                <label><b>Display Scrolling Text</b></label>
                <input type="text" class="form-control form-control-sm" name="display_scrolling_text" value="{{$settings_g['display_scrolling_text'] ?? old('display_scrolling_text')}}">
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success">Create</button>
            <br>
            <small><b>NB: *</b> marked are required field.</small>
        </div>
    </div>
</form>
@endsection

@section('footer')
<script>
    // Uploaded image get url
    function readURLFavicon(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.uploaded_img_favicon').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".image_upload_favicon").change(function(){
        readURLFavicon(this);
    });

    // Uploaded image get url
    function readURLLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.uploaded_img_hb_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".image_upload_hb_image").change(function(){
        readURLLogo(this);
    });

    function readURLog(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.uploaded_img_og').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".image_upload_og").change(function(){
        readURLog(this);
    });
</script>
@endsection
