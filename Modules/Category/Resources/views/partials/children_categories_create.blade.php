@foreach ($categories as $category)
    @if ($category->category_id == $parent_id)
        <option value="{{ $category->id }}">{{ $char . $category->name }}</option>
        @include('category::partials.children_categories_create', ['categories' => $categories, 'parent_id' => $category->id, 'char' => $char.'|---'])
    @endif
@endforeach
