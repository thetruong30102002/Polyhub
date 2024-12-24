@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
      <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
      <form class="needs-validation" action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom01">Email</label>
            <input type="email" class="form-control" id="validationCustom01" name="email"
              value="{{old('email')}}"  required/>
              @if ($errors->has('email'))
                <span class="error text-danger">{{ $errors->first('email') }}</span>
              @endif
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom02">Name</label>
            <input type="text" class="form-control" placeholder="Last name" name='name'
              value="{{old('name')}}"  required/>
              @if ($errors->has('name'))
                <span class="error text-danger">{{ $errors->first('name') }}</span>
              @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label" for="validationCustom03">Address</label>
            <input type="text" class="form-control" id="validationCustom03" name='address'   value="{{old('address')}}" />
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom04">Password</label>
            <input type="password" class="form-control" id="validationCustom04" name='password'  required/>
            @if ($errors->has('password'))
                <span class="error text-danger">{{ $errors->first('password') }}</span>
            @endif
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom05">Repassword</label>
            <input type="password" class="form-control" id="validationCustom05" name='re-password'  required/>
            @if ($errors->has('re-password'))
                <span class="error text-danger">{{ $errors->first('re-password') }}</span>
            @endif
          </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="formFile" class="form-label">Avatar</label>
                <input type="file" class="form-control" id="avatar" accept="image/*" onchange="previewImage(event)" name="avatar">
                <img id="avatar-preview" class="form-control" src="#" alt="Preview" style="display: none;"/>
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
                document.getElementById('avatar-preview').src = dataURL;
                document.getElementById('avatar-preview').style.display = 'block';
            } else {
                alert("File không phải là hình ảnh!");
                document.getElementById('avatar-preview').style.display = 'none';
            }
        };
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection