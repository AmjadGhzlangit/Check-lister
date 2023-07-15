@extends('layouts.app')

@section('content')
<div class="body flex-grow-1 px-3">
<div class="container-lg">
<!-- /.row-->
<div class="card mb-4">
            
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
                <h4 class="card-title mb-0">{{ __('Create CheckList Group') }}</h4>
            </div>
        </div>
        <form action="{{ route('admin.checklist_group.store') }}" method="POST">
            @csrf
            <div class="my-4">
                <label for="formGroupExampleInput" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control" 
                    placeholder="{{ __('CheckList Group Name') }}"
                    name="name">
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

        </form>
    </div>
</div>
</div>
</div>
<!-- /.card.mb-4-->
@endsection
