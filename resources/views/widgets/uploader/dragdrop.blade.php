<form action="{{route("uploads.store")}}" method="POST" name="photos" enctype="multipart/form-data"
      class="dropzone" id="photos">
    @csrf
</form>
<script>
    Dropzone.autoDiscover = false; // This is optional in this case
    $(document).ready(function () {
        var myAwesomeDropzone = new Dropzone("form#photos", {
            url: '{{route('uploads.store')}}',
            addRemoveLinks: true,
            maxFiles: 5,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            // Dropzone settings
            init: function () {
                var myDropzone = this;
                this.on("success", function (files, response) {

                    if ( '{{ $attr['route'] }}' == 'edit' ){
                        let photos_input = $('#form-data').find('#photos');
                        let values  = [];
                        if (photos_input.val()) {
                            values = JSON.parse(photos_input.val())
                        }
                        values.push(response[0]);
                        photos_input.val(JSON.stringify(values));

                        photos_input.val(JSON.stringify(values));
                    }
                    else{ 

                        var name = '#photos'
                        $('#document-dropzone').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
                        //Set the upload id in the hidden input
                        let values = []
                        let images = {};
                        if ($(name).val()) {
                            values = JSON.parse($(name).val())
                        }
                        values.push(response[0]);
                        $(name).val(JSON.stringify(values));

                    }


                    
                });
                this.on("error", function (files, response) {

                });
            }
        })
    });

</script>
