@extends('Backend.layouts.app')

@section('content')
    {{-- <div class="mx-2">
        <div class="card shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <h4 class="fw-semibold mb-0"> {{ $title }} </h4>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-4 pb-2 align-items-center">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="mb-0"> {{ $title2 }} </h5>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('attributevalue.search') }}" onsubmit="true" method="post"
                                class="form-check">
                                @csrf
                                <input type="text" name="text" id="firstName" class="form-control">
                                <button type="submit" hidden>Search</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mb-4 pb-2 align-items-center ">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('attributevalue.create') }}"  
                                class="btn d-block btn-success px-7 py-8 col-4">Add
                                new</a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('attributevalue.bin') }}"
                                class="btn d-block btn-danger px-7 py-8 col-4">Trash</a>
                        </div>
                    </div>

                </div>

                <div class="table-responsive pb-4">

                    <table class="table align-middle text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                    </div>
                                </th>
                                <th scope="col">ID
                                      <a href=""><iconify-icon icon="material-symbols:arrow-drop-up"></iconify-icon></a>
                                    <a href=""><iconify-icon icon="material-symbols:arrow-drop-down"></iconify-icon></a>
                                </th>
                                <th scope="col">Movie
                                      <a href=""><iconify-icon icon="material-symbols:arrow-drop-up"></iconify-icon></a>
                                    <a href=""><iconify-icon icon="material-symbols:arrow-drop-down"></iconify-icon></a>
                                </th>
                                <th scope="col">Name
                                      <a href=""><iconify-icon icon="material-symbols:arrow-drop-up"></iconify-icon></a>
                                    <a href=""><iconify-icon icon="material-symbols:arrow-drop-down"></iconify-icon></a>
                                </th>
                                <th scope="col">Value
                                      <a href=""><iconify-icon icon="material-symbols:arrow-drop-up"></iconify-icon></a>
                                    <a href=""><iconify-icon icon="material-symbols:arrow-drop-down"></iconify-icon></a>
                                </th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($page as $item)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                        </div>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>

                                        @forelse ($listattr as $item2)
                                            @forelse ($movie as $item3)
                                                @if ($item->attribute_id == $item2->id && $item2->movie_id == $item3->id)
                                                    {{ $item3->name }}
                                                @else
                                                @endif
                                            @empty
                                            @endforelse
                                        @empty
                                        @endforelse

                                    </td>
                                    <td>
                                        {{-- <h6 class="fw-semibold mb-0 fs-4">{{ $item->name }}</h6> 
                                        @forelse ($listattr as $item2)
                                            @if ($item->attribute_id == $item2->id)
                                                {{ $item2->name }}
                                            @endif
                                        @empty
                                        @endforelse
                                    </td>
                                    <td>
                                        {{ $item->value }}
                                    </td>

                                    <td>
                                        <a href="{{ route('attributevalue.show', $item->id) }}"
                                            class="btn btn-primary">Detail</a>
                                        <a href="{{ route('attributevalue.edit', $item->id) }}"
                                            class="btn btn-warning">Edit</a>
                                        <div>
                                            <form action="{{ route('attributevalue.delete', $item->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Delete now?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                            @endforelse

                        </tbody>
                    </table>
                    <div class="my-3 align-center">
                        {{ $page->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="d-md-flex justify-content-between mb-9">
                        <div class="mb-9 mb-md-0">
                            <h5 class="card-title">Latest reviews</h5>
                            <p class="card-subtitle mb-0">Reviewd received across all channels</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <form class="position-relative me-3 w-100">
                                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                    placeholder="Search">
                                <i
                                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                            <div class="dropdown">
                                <a href="#" class="btn border shadow-none px-3" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-5"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="attributevalue.create"><i
                                                class="fs-4 ti ti-plus"></i>Add</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="attributevalue.edit"><i
                                                class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="attributevalue.destroy"><i
                                                class="fs-4 ti ti-trash"></i>Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive overflow-x-auto latest-reviews-table">
                        <table class="table mb-0 align-middle text-nowrap">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="ps-0">
                                        #
                                    </th>
                                    <th scope="col">ID
                                        
                                  </th>
                                  <th scope="col">Movie
                                      
                                  </th>
                                  <th scope="col">Name
                                       
                                  </th>
                                  <th scope="col">Value
                                        
                                  </th>
                                    
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($page as $item)
                                <tr>
                                    <td class="ps-0">
                                        <div class="form-check mb-0 flex-shrink-0">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center product text-truncate">
                                           
                                            <div class=" product-title">
                                                <h6 class="fs-4 mb-0 text-truncate-2"> {{ $item->id }} </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center text-truncate">
                                           
                                            <div class="">
                                                @forelse ($listattr as $item2)
                                            @forelse ($movie as $item3)
                                                @if ($item->attribute_id == $item2->id && $item2->movie_id == $item3->id)
                                                   
                                                    <h5 class="mb-1 fs-4"> {{ $item3->name }} </h5>
                                                @else
                                                @endif
                                            @empty
                                            @endforelse
                                        @empty
                                        @endforelse
                                                
                                               
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-reviews">
                                            @forelse ($listattr as $item2)
                                            @if ($item->attribute_id == $item2->id)
                                            <h6 class="fs-4 mb-0 text-truncate-2"> {{ $item2->name }} </h6>
                                            @endif
                                        @empty
                                        @endforelse
                                          
                                        </div>
                                    </td>
                                    <td>
                                        <div class="product-reviews">
                                            
                                            <h6 class="fs-4 mb-0 text-truncate-2"> {{ $item->value }} </h6>
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="dropdown dropstart">
                                            <a href="#" class="text-muted " id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical fs-5"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('attributevalue.show', $item->id) }}"><i class="fs-4 ti ti-plus"></i>Detail</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-3"
                                                        href="{{ route('attributevalue.edit', $item->id) }}"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('attributevalue.delete', $item->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="id"
                                                            value="{{ $item->id }}">
                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center gap-3"
                                                            onclick="return confirm('Delete now?')"><i
                                                                class="fs-4 ti ti-trash"></i> Delete </button>
                                                    </form>
                                                </li>

                                                
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-10">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
