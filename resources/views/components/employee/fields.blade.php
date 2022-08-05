<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('name', 'Name') }}
            {{ form::text('name', $employee->name, ['class' => 'form-control', 'placeholder' => 'Name']) }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('email', 'Email') }}
            {{ form::text('email', $employee->email, ['class' => 'form-control', 'placeholder' => 'Email']) }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            {{ form::label('password', 'Password') }}
            {{ form::text('password', $employee->password, ['class' => 'form-control', 'placeholder' => 'Pasword']) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {{ form::label('company', 'Company') }}
            {{ form::select('company_id', $companies, $employee->company_id, ['class' => 'select2 form-control templatingSelect2', 'style' => 'height: 100px']) }}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.templatingSelect2').select2({
            theme: "bootstrap4",
        });
    });
</script>
