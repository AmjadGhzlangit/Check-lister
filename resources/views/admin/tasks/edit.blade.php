@extends('layouts.app')


@section('content')
<div class="body flex-grow-1 px-3">
<div class="container-lg">
<!-- /.row-->
<div class="card mb-2">
          @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
        </div>
          @endif
        @if ($errors->storetask->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->storetask->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">{{ __('Edit Task') }}</h4>
            </div>
        </div>
        <form action="{{ route('admin.checklist.task.update',[$checklist,$task]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="my-4">
                <label for="formGroupExampleInput" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" 
                    name="name"
                    value="{{ $task->name }}">
            </div>
            <div class="my-3">
                <label  class="form-label">{{ __('Description') }}</label>
                    <textarea  class="form-control" 
                    name="description"
                    rows="5"
                  
                    >{{ $task->description }}
                    </textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Save Task') }}</button>
        </form>
    </div>
    <br>
   
</div>
</div>
</div>
@endsection
