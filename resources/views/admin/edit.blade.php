@extends('admin.master')
@section('title','User Edit')
@section('admin')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Edit</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->

            <div class="col-lg-7" style="padding-bottom:120px">
                @if (session('edit'))
                    <p class="success">{{ session('edit')}}</p>
                @endif

                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{$user->id}}" id="user-id">

                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" value="{{ $user->username }}" disabled />
                    </div>
                    <div class="form-group">
                        <label>Fullname</label>
                        <input class="form-control" name="name" id="name" value="{{ old('name',isset($user)? $user->name:null) }}" />
                    </div>
                    @if ($errors->has('fullname'))
                        <p class="error">{{ $errors->first('fullname') }}</p>
                    @endif

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Please Enter Email" value="{{ old('email',isset($user)? $user->email:null) }}" />
                        @if ($errors->has('email'))
                            <p class="error">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="email" class="form-control" name="address" id="address" placeholder="Please Enter Email" value="{{ old('address',isset($user)? $user->address:null) }}" />
                        @if ($errors->has('address'))
                            <p class="error">{{ $errors->first('address') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="email" class="form-control" name="phone" id="phone" placeholder="Please Enter Email" value="{{ old('phone',isset($user)? $user->phone:null) }}" />
                        @if ($errors->has('phone'))
                            <p class="error">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-default" id="btn-edit">Edit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <p id="errorLogin" class="error"></p>

                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>

@endsection