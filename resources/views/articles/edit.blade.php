@extends('layout.index')

@section('content')
    <form action={{route('edit.post', ['id' => $article->id])}} method="post">
        {{csrf_field()}}
        <label for="title">Title</label>
        <input type="text" name="title" value={{$article->title}}>

        <label for="body">Body</label>
        <textarea type="text" name="body">{{$article->body}}</textarea>

        <label for="tags">Tags</label>
        <input type="text" name="tags" value="{{implode(",",$article->tags)}}">

        <input type="hidden" value="1" name="user_id">
        <button type="submit">Submit</button>
    </form>
@endsection
