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
                <h4 class="card-title mb-0">{{ __('Edit CheckList') }}</h4>
            </div>
        </div>
        <form action="{{ route('admin.checklist_group.checklist.update',[$checklist_group,$checklist]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="my-4">
                <label for="formGroupExampleInput" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" 
                   
                    name="name"
                    value="{{ $checklist->name }}">
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

        </form>
    </div>
    <br>
   
</div>
<form action="{{ route('admin.checklist_group.checklist.destroy',[$checklist_group,$checklist]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger"
    onclick="return con">{{ __('Delete Checklist') }}</button>

</form>
<hr>
<div class="card mb-2">
    @if (session('task_added') )
    <div class="alert alert-success">
        {{ session('task_added') }}
    </div>
    @elseif (session('task_delete'))
    <div class="alert alert-success">
        {{ session('task_delete') }}
    </div>
    @elseif (session('task_updated'))
    <div class="alert alert-success">
        {{ session('task_updated') }}
    </div>
@endif
<div class="card-body">
    <h4 class="card-title mb-0">{{ __('List of Tasks') }}</h4>
    <hr>
    <div class="d-flex justify-content-between">
        <table class="table table-hover">
            <tbody>
                @foreach ($checklist->tasks as $task)    
              <tr>
                <td><h5>{{__($task->name)  }}</h5></td>
                <td><a class="btn btn-primary" href="{{ route('admin.checklist.task.edit',[$checklist,$task]) }}">
                    Edit
                    </a>
                </td>

                   <td> <form action="{{ route('admin.checklist.task.destroy',[$checklist,$task]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                        onclick="return con">{{ __('Delete Checklist') }}</button>                   
                    </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>   
    </div>
</div>
</div>
<hr>
<div class="card mb-2">
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
                <h4 class="card-title mb-0">{{ __('New Task') }}</h4>          
            </div>      
        </div>
        <hr>
        <form action="{{ route('admin.checklist.task.store', $checklist) }}" method="POST">
            @csrf
            <div class="my-4">
                <label class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" 
                    name="name"
                    value="{{ old('name') }}"
                   >
            </div>
            <div class="my-3">
                <label  class="form-label">{{ __('Description') }}</label>
                    <textarea  class="form-control" 
                    name="description"
                    rows="5"
                    id="task-textarea"
                    >{{ old('description') }}
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

@section('scripts')
<script>
    ClassicEditor
        .create( document.querySelector( '#task-textarea' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection