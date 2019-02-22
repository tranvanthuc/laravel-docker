@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <input type="text" placeholder="Search " id="search">
                <button id="load-more">Load more</button>
                <button id="btn-create-post">Button Create Article</button>
                <div class="panel-body">
                    @include('articles.list')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom.js')
    <script src="{{mix('js/firebase/messaging.js')}}"></script>
    <script src="{{mix('js/firebase/create-post.js')}}"></script>
@endsection
