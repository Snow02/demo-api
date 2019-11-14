@extends('admin.master')
@section('title','Add User')
@section('admin')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Add</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">

                <form action="" enctype="multipart/form-data"  id="form-add" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Fullname</label>
                        <input class="form-control" name="name" id="name" placeholder="Please Enter Name" value="{{ old('name') }}" />
                        @if ($errors->has('name'))
                            <p class="error">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" id="username" placeholder="Please Enter Username" value="{{ old('username') }}" />
                        @if ($errors->has('username'))
                            <p class="error">{{ $errors->first('username') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" id="email" placeholder="Please Enter Email" value="{{ old('email') }}" />
                        @if ($errors->has('email'))
                            <p class="error">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Please Enter Password" />
                        @if ($errors->has('password'))
                            <p class="error">{{ $errors->first('password') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Please Enter Phone" />
                        @if ($errors->has('phone'))
                            <p class="error">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Please Enter Address" />
                        @if ($errors->has('address'))
                            <p class="error">{{ $errors->first('address') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Images</label>
                        <input type="file" class="form-control" name="images[]" id="images"  multiple/>

                    </div>
                    <div class="form-group">
                        <label>Authorities</label>
                        <input type="radio" name="role" id="role" value="0">SuperAdmin
                        <input type="radio" name="role" id="role" value="1">Admin
                        <input type="radio" name="role" id="role" checked value="3">Member

                    </div>
                    <button type="submit" class="btn btn-default" id="btn-add">Add</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

    
@endsection