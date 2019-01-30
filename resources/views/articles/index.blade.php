@extends('layout.index')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-primary">
                <input type="text" placeholder="Search " id="search">
                <button id="load-more">Load more</button>
                <div class="panel-body">
                    @include('articles.list')
                </div>
            </div>
        </div>
    </div>
@endsection
