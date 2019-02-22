<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div
        id="app"
        style="max-width: 800px; margin: auto;"
    >
        <h1>{{ $article->title }}</h1>

        <div class="body mb-4">{{ $article->body }}</div>

        @auth
            <star-rating
                :initial="{{ $article->ratingFor(auth()->user()) ?: 0 }}"
                action="/articles/{{ $article->id }}/rate"
            ></star-rating>

            Average Rating: {{ $article->rating() }}
        @endauth
    </div>

    <script src="/js/app.js"></script>
</body>
</html>