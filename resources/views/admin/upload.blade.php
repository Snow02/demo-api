
@extends('admin.master')
@section('title','Product Add')
@section('admin')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Upload Image</h1>
            </div>
            <!-- /.col-lg-12 -->
            <form action="" method="POST" enctype="multipart/form-data" id="form-upload">
                <div class="col-lg-7" style="padding-bottom:120px">
                    @csrf
                    <div class="form-group">

                        {{--@for ($i = 1; $i <=3 ; $i++)--}}
                            {{--<label for="" class="lbl-img">Image  {{ $i }}</label>--}}
                            {{--<input type="file" name="file[]" id="file">--}}
                        {{--@endfor--}}
                        {{--<button type="button" class="btn btn-primary" id="add-img">Add Images Upload</button>--}}
                        {{--<div id="insert"></div>--}}

                        <input type="file" name="images[]" id="images" multiple>
                    </div>
                    <button type="submit" class="btn btn-default" id="btn-upload">Upload Images</button>
                    <p class="success"></p>
                </div>
            </form>
        </div>
             <!-- /.row -->
         </div>
         <!-- /.container-fluid -->
     </div>
     <!-- /#page-wrapper -->

 </div>
 <!-- /#wrapper -->

 @endsection