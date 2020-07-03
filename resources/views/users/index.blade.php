@extends('admin.layout.main')
@section('content')

<div class="content-wrapper">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="panel-heading main-color-bg">
              <h3 class="panel-title">Users Management</h3>
            </div>
          </div>
          <div class="card-body">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
              <p>{{ $message }}</p>
            </div>
            @endif

            <div class="panel panel-default">

              <div class="row">

                <a class="btn btn-info" href="{{ route('users.create') }}" style="margin-left: 20px !important;">Add
                  User</a>
              </div>
              <br><br>
              <div class="panel-body">
                <table class="table table-bordered">
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th width="280px">Action</th>
                  </tr>
                  @foreach ($data as $key => $user)
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                      @if(!empty($user->getRoleNames()))
                      @foreach($user->getRoleNames() as $v)
                      @if ($v == 'Producer')
                      <label class="badge badge-warning">{{ $v }}</label>
                      @elseif($v == 'Artist')
                      <label class="badge badge-success">{{ $v }}</label>
                      @elseif( $v == 'Normal User')
                      <label class="badge badge-info">{{ $v }}</label>
                      @elseif($v == 'Super-Admin')
                      <label class="badge badge-danger">{{ $v }}</label>
                      @endif                     
                      @endforeach
                      @endif
                    </td>
                    <td>
                      <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                      <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                      {!! Form::open(['method' => 'DELETE','route' => ['users.destroy',
                      $user->id],'style'=>'display:inline']) !!}
                      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                      {!! Form::close() !!}
                    </td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>

            {!! $data->render() !!}
          </div>user
        </div>
      </div>
    </div>

  </div>
</div>
</div>
@endsection