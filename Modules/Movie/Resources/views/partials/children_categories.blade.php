@foreach ($categories as $category)
    @if ($category->category_id == $parent_id)
        <option value="{{ $category->id }}" 
            @if (isset($selectedCategories) && in_array($category->id, $selectedCategories)) selected @endif>
            {{ $char . ' ' . $category->name }}
        </option>
        @include('movie::partials.children_categories', [
            'categories' => $categories, 
            'parent_id' => $category->id, 
            'char' => $char . '|---', 
            'selectedCategories' => $selectedCategories ?? []
        ])
    @endif
@endforeach