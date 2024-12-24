@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
      <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
      <form class="needs-validation" action="{{route('user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom01">Email</label>
            <input type="email" class="form-control" id="validationCustom01" name="email"
              value="{{$user->email}}" required />
            @if ($errors->has('email'))
              <span class="error text-danger">{{ $errors->first('email') }}</span>
            @endif
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom02">Name</label>
            <input type="text" class="form-control" placeholder="Last name" name='name'
              value="{{$user->name}}" required />
              @if ($errors->has('name'))
              <span class="error text-danger">{{ $errors->first('name') }}</span>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label" for="validationCustom03">Address</label>
            <input type="text" class="form-control" id="validationCustom03" name='address' value="{{$user->address}}"/>
          </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="formFile" class="form-label">Avatar</label>
                <input class="form-control" type="file" id="formFile" name='avatar' onchange="previewImage(event)"/>
                <img  id="avatar-preview" src="{{ asset('storage/' . str_replace('public/', '', $user->avatar)) }}" alt="" class="form-control">
            </div>
        </div>
        <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">
          Submit form
        </button>
      </form>
    </div>
  </div>
  
<script>
    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var dataURL = reader.result;
            var img = new Image();
            img.src = dataURL;
            img.onload = function() {
                if (img.width > 0 && img.height > 0) {
                    console.log(123);
                    document.getElementById('avatar-preview').src = dataURL;
                } else {
                    alert("File không phải là hình ảnh!");  
                }
            };
        };
        reader.readAsDataURL(input.files[0]);
    }
    </script>
@endsection