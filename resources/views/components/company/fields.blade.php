<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('name','Name')}}
            {{form::text('name', $company->name ,['class'=>'form-control','placeholder'=>'Name'])}}
        </div>
    </div>
    <div class="col-sm-12">
        <!-- textarea -->
        <div class="form-group">
            {{ form::label('address','Adress')}}
            {{form::textarea('address', $company->address ,['class'=>'form-control','placeholder'=>'Address'])}}
        </div>
    </div>
</div>


