@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="{{route('s3.upload')}}" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                <input type="file" name="fileUpload">
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
@endsection

@section('bottom.js')
    <script src="{{mix('js/firebase/messaging.js')}}"></script>
    <script src="{{mix('js/firebase/create-post.js')}}"></script>
@endsection
