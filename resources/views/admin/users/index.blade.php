@extends('layouts.app')


@section('content')
<div class="body flex-grow-1 px-3">
<div class="container-lg">
<!-- /.row-->
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
    <h4 class="card-title mb-0">{{ __('Users') }}</h4>
    <hr>
    <div class="d-flex justify-content-between">
        <table class="table table-hover">

            <thead>
                <tr>
                    <th>Registere Date</th>
                    <th>Name</th>
                    <th>Web Site</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)    
              <tr>
                <td>{{$user->created_at }}</td>
                <td>{{__($user->name)  }}</td>
                <td>{{__($user->website)  }}</td>
                <td>{{__($user->email)  }}</td>
              </tr>
              @endforeach
            </tbody>
          </table> 
        
    </div>
    {{ $users->links() }}  
</div>
</div>
@endsection
