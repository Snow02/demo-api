@extends('admin.master')
@section('title','List Admin')
@section('admin')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>List</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @if (session('delete'))
                <p class="success">{{ session('delete') }}</p>
            @endif
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>

                    <tr align="center">
                        <th>STT</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>


                    
                    
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

    @endsection