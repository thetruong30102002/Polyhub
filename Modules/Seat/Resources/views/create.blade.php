@extends('Backend.layouts.app')
@section('content')
    {{-- nav start --}}
    <div class="card shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body d-flex align-items-center justify-content-between p-4">
            <h4 class="fw-semibold mb-0">Add new</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../dark/index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">seat</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- nav end --}}


    <section class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Add new seat</h5>
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col input-group">
                            <span class="input-group-text">Hàng</span>
                            <select name="row" class="form-select" id="inputGroupSelect04">
                                <option value="a">a</option>
                                <option value="b">b</option>
                                <option value="c">c</option>
                                <option value="d">d</option>
                                <option value="e">e</option>
                                <option value="f">f</option>
                                <option value="g">g</option>
                            </select>
                        </div>
                        <div class="col input-group">
                            <span class="input-group-text">Cột</span>
                            <select name="column" class="form-select" id="inputGroupSelect04">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12 my-4">
                            <div class="d-md-flex align-items-center">
                                <div class="ms-auto mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-primary  rounded-pill px-4">
                                        <div class="d-flex align-items-center">
                                            Submit
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><span class="text-danger">{{ $error }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </section>
@endsection
