@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>{{$title}}</strong>
                    <a href="{{route('menu.create')}}" class="btn btn-success float-right">Create New</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>URL</th>
                                <th width="300px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($menus) && $menus->count())
                                @foreach($menus as $key => $value)
                                    <tr>
                                        <td>{{ $value->url }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>
                                            <a href="{{ route('menu.edit',$value->id) }}" class="btn btn-success">Edit</a>

                                            <form action="{{ route('menu.destroy',$value->id) }}" method="POST" style="display: inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10">There are no data.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $menus->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
