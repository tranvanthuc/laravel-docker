@extends('layouts.app')

@section('content')
    <form action={{route('create.post')}} method="post">
        {{csrf_field()}}
        <label for="title">Title</label>
        <input type="text" name="title">

        <label for="body">Body</label>
        <textarea type="text" name="body"></textarea>

        <label for="tags">Tags</label>
        <input type="text" name="tags">

        <button type="submit">Submit</button>
    </form>
@endsection
