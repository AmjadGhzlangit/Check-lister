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
                <h4 class="card-title mb-0">{{ __('Edit Page') }}</h4>
            </div>
        </div>
        <form action="{{ route('admin.pages.update',$page) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="my-4">
                <label class="form-label">{{ __('Page Title') }}</label>
                <input type="text" class="form-control" 
                    name="title"
                    value="{{ $page->title }}">
            </div>
            <hr>
            <div class="my-3">
                <label  class="form-label">{{ __('Content') }}</label>
                    <textarea  class="form-control" 
                    name="content"
                    rows="5"
                    id="task-textarea"
                    >{{ ($page->content) }}
                    </textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save Page') }}</button>

        </form>
    </div>
    <br>
   
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