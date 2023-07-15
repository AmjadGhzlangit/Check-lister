@extends('layouts.app')


@section('content')
<div class="body flex-grow-1 px-3">
<div class="container-lg">
<!-- /.row-->
<div class="card mb-2">         
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">{{ __('Edit CheckList Group') }}</h4>
            </div>
        </div>
        <form action="{{ route('admin.checklist_group.update',$checklist_group) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="my-4">
                <label for="formGroupExampleInput" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" 
                   
                    name="name"
                    value="{{ $checklist_group->name }}">
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

        </form>
    </div>
    <br>
   
</div>
<form action="{{ route('admin.checklist_group.destroy',$checklist_group) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger"
    onclick="return con">{{ __('Delete Checklist Group') }}</button>

</form>
<hr>
<div class="card mb-2">
<div class="card-body">
    <div class="d-flex justify-content-between">
        <div>
            <h4 class="card-title mb-0">{{ __('Tasks') }}</h4>
        </div>
    </div>
   
</div>
</div>
<hr>
<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="card-title mb-0">{{ __('New Task') }}</h4>
               
            </div>
           
        </div>
        <hr>
        <form action="" method="POST">
            @csrf
            <div class="my-4">
                <label class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" 
                    name="name"
                   >
            </div>
            <div class="my-3">
                <label  class="form-label">{{ __('Description') }}</label>
                    <textarea  class="form-control" 
                    name="description"
                    
                    rows="5">
                    </textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Save Task') }}</button>
        </form> 
    </div>
</div>
</div>
</div>
@endsection
