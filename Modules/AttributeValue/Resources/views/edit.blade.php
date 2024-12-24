
@extends('Backend.layouts.app')

@section('content')
    <div class="mx-2">
        <div class="card shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <a href="{{ route('attributevalue.list') }}">
                    <h4 class="fw-semibold mb-0"> {{ $title }} </h4>
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-4 pb-2 align-items-center">
                    <h5 class="mb-0"> {{ $title2 }} </h5>
                </div>
                <form action="{{ route('attributevalue.update', $attrV->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div>
                        <div class="card-body">
                            <div class="row pt-3">

                                <!-- Movie Select -->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Movie</label>
                                        <select class="form-select" name="attribute_id" id="attributeSelect">
                                            <option value="">Select a Movie</option>

                                            @forelse ($listattr as $item2)
                                                @forelse ($movie as $item3)
                                                    @if ($item2->movie_id == $item3->id)
                                                        <option value="{{ $item2->id }}" data-name="{{ $item2->name }}"
                                                            @if ($attrV->attribute_id == $item2->id) selected @endif>
                                                            {{ $item3->name . ' - ' . $item2->name }}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option value="">No movies available</option>
                                                @endforelse
                                            @empty
                                                <option value="">No attributes available</option>
                                            @endforelse

                                        </select>
                                        <span class="text-danger">{{ $errors->first('movie_id') }}</span>
                                    </div>
                                </div>

                                <!-- Value Input -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Value</label>
                                        <div id="inputContainer">
                                            @if ($listattr->firstWhere('id', $attrV->attribute_id)->name === 'Image')
                                                <input type="file" name="value" id="valueInput" class="form-control" />
                                                <div>
                                                    <img src="{{ asset($attrV->value) }}" alt="" width="100px">
                                                </div>
                                            @elseif ($listattr->firstWhere('id', $attrV->attribute_id)->name === 'Rating')
                                                <input type="number" name="value" value="{{ $attrV->value }}"
                                                    id="valueInput" class="form-control" min="1" max="5"
                                                    step="1" />
                                            @else
                                                <input type="text" name="value" value="{{ $attrV->value }}"
                                                    id="valueInput" class="form-control" />
                                            @endif

                                        </div>
                                        <span class="text-danger">{{ $errors->first('value') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="card-body border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-4">Save</button>
                                <a href="{{ route('attributevalue.list') }}">
                                    <button type="button"
                                        class="btn bg-danger-subtle text-danger rounded-pill px-4 ms-6">Cancel</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('attributeSelect').addEventListener('change', function() {
                    var selectedOption = this.options[this.selectedIndex];
                    var itemName = selectedOption.getAttribute('data-name');
                    var inputContainer = document.getElementById('inputContainer');

                    if (itemName === 'Image') {
                        inputContainer.innerHTML = `
                    <input type="file" name="value" id="valueInput" class="form-control" />
                    <div>
                        <img src="{{ asset($attrV->value) }}" alt="" width="100px">
                    </div>
                `;
                    } else if (itemName === 'Rating') {
                        inputContainer.innerHTML = `
                    <input type="number" name="value" value="{{ $attrV->value }}" max="5" min="1" id="valueInput" class="form-control" />
                `;
                    } else {
                        inputContainer.innerHTML = `
                    <input type="text" name="value" value="{{ $attrV->value }}" id="valueInput" class="form-control" />
                `;
                    }
                    
                    });
    </script>
@endsection
