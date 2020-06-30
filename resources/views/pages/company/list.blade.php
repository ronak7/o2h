@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>{{$title}}</strong>
                    <a href="{{route('company.create')}}" class="btn btn-success float-right">Create New</a>
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
                                <th>Email</th>
                                <th>Logo</th>
                                <th width="300px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($companies) && $companies->count())
                                @foreach($companies as $key => $value)
                                    <tr>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>
                                            @if ($value->logo != "")
                                            <img src="{{URL::asset("storage/".$value->logo)}}" alt="logo" height="50" width="50">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('company.edit',$value->id) }}" class="btn btn-success">Edit</a>

                                            <form action="{{ route('company.destroy',$value->id) }}" method="POST" style="display: inline;">
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
                    {!! $companies->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
