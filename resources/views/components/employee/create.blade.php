@extends("layouts.index")
@section("content")
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Employee</h3>
                        </div>
                        <div class="card-body">
                            {!! form::open(['route'=>['employees.store',$employee],'id'=>'form-data'] ) !!}
                            @method('POST')
                            {{csrf_field()}}
                            @include('components.employee.fields')
                            <input type="hidden" id="photos" name="photos" value="{{ $employee->image_id}}">
                            {!!form::close()!!}
                            @include('widgets.uploader.dragdrop' , $attr = ['route' => 'create'] )
                            <button type="submit" class="btn btn-block btn-success" onclick="$('#form-data').submit()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


