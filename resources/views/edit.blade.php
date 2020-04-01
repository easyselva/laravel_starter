@extends('layouts.page')
@section('title', $collection->get('display_name')) 

@section('body_class','sidebar-open')

@push('pre_css')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}} " />
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote.min.css')}} " />

<style>
    .form-control-feedback {
        color: red;
    }
    .fileinput {
        display: block;
    }

</style>

@endpush 
@push('js')



<script src="{{ asset('assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-sortable/jquery-sortable-min.js') }}"></script>



<script>

$(document).on("click", ".remove", function() {
    $(this).parent().remove();
});



    $(function () {


    



        $('.summernote').summernote({toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ]});


    
    $(".repeater").repeater({initEmpty:true,show:function(){$(this).slideDown()},hide:function(e){$(this).slideUp(e)}});


    $('.sorted_table').sortable({
  containerSelector: 'table',
  itemPath: '> tbody',
  itemSelector: 'tr',
  placeholder: '<tr class="placeholder"/>'
});

      
    $("#update_form").validate({
        ignore: [],
        invalidHandler: function(event, validator) {
                KTUtil.scrollTop();
            },
    });


    $(".select2").select2();
    
    $(".select2tags").select2({  placeholder: "Select...",
    allowClear: true,tags:true, tokenSeparators: [',', ' '], minimumInputLength: 0,
    });	


    $(".date-picker").datepicker({format: 'dd/mm/yyyy',todayHighlight:!0 ,orientation:"bottom left",autoclose:true});

    $(".time-picker").timepicker();


    $(".date-time-picker").datetimepicker({format:"dd/mm/yyyy hh:ii",todayHighlight:!0,autoclose:!0,pickerPosition:"bottom-left"});


    @foreach($rows as $row)
    @foreach($row as $r)
    @if(isset($r['url']))
    $('#{{$r['id']}}').select2({
        placeholder: "{{ $r['placeholder'] }}",
        minimumInputLength: 2,
        ajax: {
            url: '{{ url($r['url']) }}',
            dataType: 'json',
            data: function (params) {
                return {
                    q: $.trim(params.term)
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    @endif
    @endforeach
    @endforeach


    $("#delete_btn").click(function (event) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure want to delete?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',


        }).then((result) => {
            if (result.value) {
                $('#delete_form').submit();
            } else {
                Swal.fire("Cancelled", "", "error");
            }
        });
    });


    $("#update_btn").click(function (event) {
        event.preventDefault();
        $("#update_form").submit();
    });

});

</script>

@endpush


@section('content')


<div class="container-fluid p-4">


    @if($collection->get('form_type')=="Create")
     @if(isset($model_name)) 
     {{ Form::model($model_name,['url' => $collection->get('url'),'id'=>'update_form','enctype'=>'multipart/form-data','class'=>'form-vertical
    validate_form', 'method' => 'post','autocomplete'=>'off']) }} 
    @else 
    {{ Form::open(['url' => $collection->get('url'),'id'=>'update_form','enctype'=>'multipart/form-data','class'=>'form-vertical
    validate_form', 'method' => 'post','autocomplete'=>'off']) }} 
    @endif 
    @else 
    
    @if($collection->get('include_delete')=="yes")

    @if($collection->get('delete_url')!="")
          {!! Form::open(['method' => 'DELETE','id'=>'delete_form', 'url' => $collection->get('delete_url')  ])
       !!} 
    @else 
    {!! Form::open(['method' => 'DELETE','id'=>'delete_form', 'route' => [$collection->get('url').'.destroy', $model_name->id]])
    !!} 
    @endif 

    {{ Form::close() }}


    @endif 


    @if($collection->get('update_url')!="")
     {!! Form::model($model_name, ['url' => $collection->get('update_url') ,'enctype'=>'multipart/form-data', 'method' =>'put','id'=>'update_form', 'class' => 'form-horizontal validate_form','autocomplete'=>'off']) !!} 

    @else 
    {!! Form::model($model_name, ['route' => [$collection->get('url').'.update', $model_name->id],'enctype'=>'multipart/form-data',
    'method' =>'put','id'=>'update_form', 'class' => 'form-horizontal validate_form','autocomplete'=>'off']) !!} 
  
    @endif 

    @endif



    <div class="card">
            <div class="card-header">
                <div class="card-head-left">

                    <div class="card-title">
                        {{ $collection->get('form_type') }} {{ $collection->get('display_name') }}
                    </div>
                </div>
                <div class="card-head-right">
                        <div class="card-actions">


                            <button onclick="window.history.go(-1); return false;" type="button" name="back" class="btn btn-light btn-icon-sm"><i class="la la-long-arrow-left"></i> Back</button>                      
                            
                            
                            @if($collection->get('form_type')=="Create") 
                            
                            @if(Helpers::has_permission($collection->get('module_id').'_add'))

                            <button class="btn btn-primary"><i class="la la-check"></i> Create</button> @endif
                             @else 
                             
                             @if(Helpers::has_permission($collection->get('module_id').'_update'))

                            <button id="update_btn" class="btn btn-primary"><i class="la la-check"></i> Update</button>
                             @endif


                            @if($collection->get('include_delete')=="yes")
                            
                            @if(Helpers::has_permission($collection->get('module_id').'_delete'))
                            <button id="delete_btn" class="btn btn-danger ">x Delete</button> 
                            @endif 


                            @endif
                            @endif


                            </ul>


                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-outline-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <ul style="margin: 0px;">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @include("form")
            </div>
        </div>
  

    {{ Form::close() }}

</div>
@endsection
