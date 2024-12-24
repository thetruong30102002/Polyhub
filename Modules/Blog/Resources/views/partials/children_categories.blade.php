@foreach ($categories as $category)
    @if ($category->category_id == $parent_id)
        <option value="{{ $category->id }}" @if(isset($selectedCategory) && $selectedCategory == $category->id) selected @endif>
            {{ $char . $category->name }}
        </option>
        @include('blog::partials.children_categories', [
            'categories' => $categories,
            'parent_id' => $category->id,
            'char' => $char . '|---',
            'selectedCategory' => $selectedCategory ?? null
        ])
    @endif
@endforeach