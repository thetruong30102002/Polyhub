@extends('Backend.layouts.app')

@section('content')
    <div class="mx-2">
        <div class="card shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body d-flex align-items-center justify-content-between p-4">
                <a href="{{ route('voucher.list') }}">
                    <h4 class="fw-semibold mb-0"> {{ $title }} </h4>
                </a>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-4 pb-2 align-items-center">
                    <h5 class="mb-0"> {{ $title2 }} </h5>
                </div>
                <form action="{{ route('voucher.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div>
                        <div class="card-body">
                          
                            <div class="row pt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Code</label>
                                        <input type="text" name="code" id="firstName" value=" {{ old('code') }} " class="form-control" placeholder="VOUCHER..." />
                                        <span class="text-danger">{{ $errors->first('code') }}</span>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Type</label>
                                        <select class="form-select" name="type">
                                            <option value="">Select a Type</option>
                                            <option value="Fixed" {{ old('type') == 'Fixed' ? 'selected' : ''}}>Fixed</option>
                                            <option value="Percent" {{ old('type') == 'Percent' ? 'selected' : ''}}>Percent</option>
                                        </select>

                                    </div>
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Amount</label>
                                        <input type="number" id="" class="form-control" value=" {{ old('amount') }} " name="amount" />

                                    </div>
                                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Start Day</label>
                                        <input type="date" id="" class="form-control" value=" {{ old('start_date') }} " name="start_date" />

                                    </div>
                                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">End Day</label>
                                        <input type="date" id="" class="form-control" value=" {{ old('end_date') }} " name="end_date" />

                                    </div>
                                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Usage Limit</label>
                                        <input type="number" id="" class="form-control" value=" {{ old('usage_limit') }} " name="usage_limit" min="1" max="30" />

                                    </div>
                                    <span class="text-danger">{{ $errors->first('usage_limit') }}</span>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Used</label>
                                        <input type="number" id="" class="form-control" value=" {{ old('used') }} " name="used" />
                                    </div>
                                    <span class="text-danger">{{ $errors->first('used') }}</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 has-success">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status">
                                            <option value="">Select a Status</option>
                                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : ''}}>Active</option>
                                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : ''}}>Inactive</option>
                                        </select>

                                    </div>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                                <!--/span-->
                            </div>

                        </div>

                        <div class="form-actions">
                            <div class="card-body border-top">
                                <button type="submit" class="btn btn-success rounded-pill px-4">
                                    Save
                                </button>
                                <a href=" {{ route('voucher.list') }} ">
                                    <button type="button" class="btn bg-danger-subtle text-danger rounded-pill px-4 ms-6">
                                        Cancel
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
