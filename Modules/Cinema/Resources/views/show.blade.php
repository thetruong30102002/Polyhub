@extends('Backend.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="border-bottom title-part-padding">
                <h4 class="card-title mb-0">detail cinema</h4>
            </div>
            <div class="card-body">
                {{-- content start --}}
                <div>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $cinema->name }}" disabled>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="name" value="{{ $cinema->city->name }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-md-flex align-items-center">
                                    <div class="ms-auto mt-3 mt-md-0">
                                        <a href="{{ route('admin.cinema.edit', $cinema->id) }}">
                                            <button type="button" class="btn btn-primary  rounded-pill px-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-send me-2 fs-4"></i>
                                                    Edit
                                                </div>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                {{-- content end --}}
            </div>
        </div>
    </div>
</div>
@endsection
