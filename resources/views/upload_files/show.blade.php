@extends('upload_files.view')

@section('page_content')
<div class="card p-4 shadow-sm">
  <div class="row">
    <div class="form-group col-md-6">
      <label>File Name:</label>
      <p>{{ $file->name }}</p>
    </div>
    <div class="form-group col-md-6">
      <label>Uploaded By:</label>
      <p>{{$file->uploader->name}}</p>
    </div>
    <div class="form-group col-md-6">
      <label>Uploaded At:</label>
      <p>{{ $file->created_at->format('d M Y, h:i A') }}</p>
    </div>
    <div class="form-group col-md-6">
      <label>Details:</label>
      <p>{{ $file->details }}</p>
    </div>
    <div class="form-group col-md-12">
      <div style="text-align:center;"><label>File Preview:</label><br></div>
      <div style="display:flex; justify-content: center;"><img src="{{ asset('storage/' . $file->path) }}" alt="File" width="50%" height="90%"></div>
    </div>
  </div>
</div>
@endsection
