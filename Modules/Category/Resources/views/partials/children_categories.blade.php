{{-- partials/child_categories.blade.php --}}

@foreach ($categories as $category)
    @if ($category->category_id == $parent_id)
        <tr>
            <td>{{ $char . $category->name }}</td>
            <td>{{ $category->created_at }}</td>
            <td>{{ $category->updated_at }}</td>
            <td>
                <div class="dropdown dropstart">
                    <a href="#" class="text-muted " id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ti ti-dots-vertical fs-5"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('categories.show', ['category' => $category->id]) }}"><i
                                class="fs-4 ti ti-plus"></i>Detail</a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('categories.edit', ['category' => $category->id]) }}"><i
                                class="fs-4 ti ti-edit"></i>Edit</a>
                        </li>
                        <li>
                            <form action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" style="border: none; background-color: unset; width: 100%; padding: 0 0 0 0">
                                    <a class="dropdown-item d-flex align-items-center gap-3" type="submit"><i
                                class="fs-4 ti ti-trash"></i>Delete</a> 
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        
        @include('category::partials.children_categories', ['categories' => $categories, 'parent_id' => $category->id, 'char' => $char.'|---'])
    @endif
@endforeach
