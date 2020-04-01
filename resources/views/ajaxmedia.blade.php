<div class="kt-portlet kt-portlet--tabs" style="width:100%;max-width:800px;margin:0px auto;">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#upload_media" role="tab" aria-selected="true">
                      Upload Media
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#media_library" role="tab" aria-selected="false">
                          Media Library
                        </a>
                    </li>
                   
                </ul>

                <button title="Close (Esc)" type="button" class="mfp-close" style="color:#bcbcbc">×</button>


            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content">
             
                <div class="tab-pane active" id="upload_media" role="tabpanel">
         
                        {{ Form::open(['url' => route('medias.store'),'id'=>'dropzone','enctype'=>'multipart/form-data','class'=>'form-vertical validate_form dropzone', 'method' => 'post','autocomplete'=>'off']) }} 
 



                        {{ Form::close() }}
                        
                </div>
                <div class="tab-pane" id="media_library" role="tabpanel">
                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
             
            </div>      
        </div>
    </div>

<script src="{{ asset('assets/vendors/dropzone/dropzone.js') }}"></script>

    
<script type="text/javascript">
    Dropzone.options.dropzone =
     {
        maxFilesize: 2,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        timeout: 5000,
        success: function(file, response) 
        {
            console.log(response);
        },
        error: function(file, response)
        {
           return false;
        }
};
</script>

    