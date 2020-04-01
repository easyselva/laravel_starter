<div class="modal-dialog @if(isset($modal_class)) {{ $modal_class }} @endif" role="document" id="ajax-container">

    <div class="modal-content">

<form id="eform" action='javascript:;' method="post" class="form-horizontal validate_form" autocomplete="off">
    {{ csrf_field() }}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button title="Close (Esc)" type="button" class="mfp-close" style="color:#bcbcbc">×</button>
      
    </div>
    <div class="modal-body">
        <div class="row ">
            <div class="col-md-12">
                <div class="form-group m-form__group">
                    <label> Old Password</label>
                    <input type="password" class="form-control m__input required" id='old_password' name='old_password' placeholder='Enter your old Password'>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="form-group m-form__group">
                    <label> New Password</label>
                    <input type="password" class="form-control m__input required" id='new_password' name='new_password' placeholder='Enter your new Password'>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <div class="form-group m-form__group">
                    <label> Confirm Password</label>
                    <input type="password" class="form-control m__input required" id='confirm_password' name='confirm_password' placeholder='Confirm your password'>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light pull-left ajax-close">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
</div>
</div>
<script>
    $(document).ready(function(){

        $("#eform").validate({
       rules: {
         new_password: "required",
         confirm_password: {
           equalTo: "#new_password"
         },
         new_password: {
           required: true,
           rangelength: [5, 20]
         }
       }
     });

         $("#eform").submit(function(event){
          event.preventDefault();
                if ($('#eform').valid())
                {
                    $.post("{{ url('update_password') }}",
               $("#eform").serialize(),function(data) {
                 if(data==1)
                 {
                 window.location.replace("{{ url('/?msg=success') }}");
                 }
                 else
                 {
                 $("#eform").append("<div class='alert alert-danger '><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+data+"</div>");
                 }
             }
                 );
         }
                 else
                 {
                 return false;
                 }
         });
                 });
</script>
