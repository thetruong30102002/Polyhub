@foreach ($movies as $movie)
    @if ($movie->parent_id == $parent_id)
        <option value="{{ $movie->id }}" 
            @if (in_array($movie->id, $selectedMovies)) selected @endif>
            {{ $char }} {{ $movie->name }}
        </option>
        @include('actor::partials.children_movies', [
            'movies' => $movies,
            'parent_id' => $movie->id,
            'char' => $char . '|---',
            'selectedMovies' => $selectedMovies
        ])
    @endif
@endforeach
