@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>{{$title}}</strong>
                    <a href="{{route('employee.create')}}" class="btn btn-success float-right">Create New</a>
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
                                <th>Company</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th width="300px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($employees) && $employees->count())
                                @foreach($employees as $key => $value)
                                    <tr>
                                        <td>{{ $value->company->name }}</td>
                                        <td>{{ $value->first_name ." ". $value->last_name }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>
                                            <a href="{{ route('employee.edit',$value->id) }}" class="btn btn-success">Edit</a>

                                            <form action="{{ route('employee.destroy',$value->id) }}" method="POST" style="display: inline;">
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
                    {!! $employees->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
