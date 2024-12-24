@extends('Backend.layouts.app')
@section('content')
<div class="card">
    <div class="border-bottom title-part-padding">
      <h4 class="card-title mb-0">{{$title}}</h4>
    </div>
    <div class="card-body">
      <form class="needs-validation" action="{{route('foodcombos.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom01">Name</label>
            <input type="text" class="form-control" id="validationCustom01" name="name" id="name"
            value="{{old('name')}}">
              @if ($errors->has('name'))
                <span class="error text-danger">{{ $errors->first('name') }}</span>
              @endif
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="validationCustom02">Price</label>
            <input type="number" class="form-control" name="price" id="price"
              value="{{old('price')}}">
              @if ($errors->has('price'))
                <span class="error text-danger">{{ $errors->first('price') }}</span>
              @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label" for="validationCustom03">Description</label>
            <textarea name="description" id="description" class="form-control" value="{{old('description')}}" ></textarea>
            @if ($errors->has('description'))
            <span class="error text-danger">{{ $errors->first('description') }}</span>
          @endif
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
              <label for="avatar" class="form-label">Avatar</label>
              <input type="file" class="form-control" id="avatar" accept="image/*" onchange="previewImage(event)" name="avatar">
              @if ($errors->has('avatar'))
                  <span class="error text-danger">{{ $errors->first('avatar') }}</span>
              @endif
              <img id="avatar-preview" class="form-control mt-2" src="#" alt="Preview" style="display: none; width: 150px; height: 150px;"/>
          </div>
      </div>
        <button class="btn btn-primary mt-3 rounded-pill px-4" type="submit">
          Submit form
        </button>
        <a href="{{ route('foodcombos.index') }}" class="btn btn-secondary  mt-3 rounded-pill px-4">Back</a>
      </form>
    </div>
  </div>

  <script>
    function previewImage(event) {
    var input = event.target;
    var file = input.files[0];
    var preview = document.getElementById('avatar-preview');
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>
@endsection