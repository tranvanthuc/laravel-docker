<div class="panel-heading">
    Articles
    <small>({{ $articles->count() }})</small>
</div>

<div id="list-article">
    @forelse ($articles as $index => $article)
        <article>
            <div><strong>{{$index+1}}. {{$article->user['name']}}</strong> (email: {{$article->user['email']}})</div>
            <h4 for="title">Title</h4>
            <div>{{ $article->title }}</div>

            <h4 for="desc">Description</h4>
            <p>{{ $article->body }} </p>

            <h4 for="tags">Tags</h4>
            <p class="well">{{implode(",",$article->tags)}}</p>
        </article>
    @empty
        <p>No articles found</p>
    @endforelse

</div>
