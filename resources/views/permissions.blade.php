
<div class="modal-dialog @if(isset($modal_class)) {{ $modal_class }} @endif" role="document" id="ajax-container">

<div class="modal-content">


{{ Form::open(['url' => $collection->get('url'),'id'=>'update_form', 'files' => true,'class'=>'form-vertical
validate_form', 'method' => 'post','autocomplete'=>'off']) }}


<div class="modal-header">
            <h5 class="modal-title">Permissions</h5>
            <button title="Close (Esc)" type="button" class="mfp-close" style="color:#bcbcbc">×</button>
        </div>
        <div class="modal-body">

               <div class="table-responsive">
               <table id="s-table" class="table table-striped table-bordered table-hover" >

<tr><th>S.No</th><th>Module</th><th>View</th><th>Add</th><th>Update</th><th>Delete</th></tr>

@php($sno=1)
@foreach($modules as $m)

<input type="hidden" name="module_id[]" value="{{ $m->id }}" />


<tr><td>{{ $sno++ }}</td><td>{{ $m->name }}</td>
<td class="text-center"> <label class="m__checkbox">{!!  Form::checkbox('can_view_'.$m->id, 'value', $m->can_view==1 ? true: false); !!}<span></span></label></td>

<td  class="text-center"> <label class="m__checkbox">{!!  Form::checkbox('can_add_'.$m->id, 'value', $m->can_add==1 ? true: false); !!}<span></span></label></td>

<td  class="text-center"> <label class="m__checkbox">{!!  Form::checkbox('can_update_'.$m->id, 'value', $m->can_update==1 ? true: false); !!}<span></span></label></td>

<td  class="text-center"> <label class="m__checkbox">{!!  Form::checkbox('can_delete_'.$m->id, 'value', $m->can_delete==1 ? true: false); !!}<span></span></label></td>
</tr>



@endforeach


               </table>
               </div>

        </div>
        <div class="modal-footer">

                <button type="button" class="btn btn-clean pull-left ajax-close" >Close</button>

                
                @if(Helpers::has_permission($collection->get('module_id').'_update'))
                <button id="update_btn" type="submit" class="btn btn-primary "><i class="fa fa-check"></i> 
                Update 
                </button> 
                @endif
        </div>
        {{ Form::close() }}

                </div>      </div>
<script>
    $(function () {


        $("#update_form").validate({
            ignore: []
        });

  


        $("#update_btn").click(function (event) {

            $("#update_btn").attr("disabled", true);
            $("#update_btn").toggleClass("m__spinner");

            event.preventDefault();

            var frm = $('#update_form');

            var formData = new FormData($('#update_form')[0]);

            if (frm.valid())
                {
                $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData:false, // To send DOMDocument or non processed data file it is set to false

                success: function (response) {
                    $("#update_btn").toggleClass("m__spinner");
                    $("#update_btn").attr("disabled", false);

                    if (response.status === true) {
                        toastr.success(response.notification);

                        if (response.hasOwnProperty('reload')) {
                            location.reload();
                        }

                        $.magnificPopup.close();


                        $('#s-table').DataTable().ajax.reload();
                    } else {

                        toastr.error(response.notification);
                    }

                },
                error: function (data) {
                    $("#update_btn").toggleClass("m__spinner");
                    $("#update_btn").attr("disabled", false);
                    toastr.error("Oops... Something went wrong!" + data);
                },
            });


                }else{
                    $("#update_btn").toggleClass("m__spinner");
                    $("#update_btn").attr("disabled", false);
                }


        });






    });

</script>


@if(isset($custom_scripts))
@include($custom_scripts)
@endif
