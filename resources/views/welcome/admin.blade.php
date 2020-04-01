<div class="row row-no-padding">


        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('student_details.index') }}"><div class="topwidget"  style="background:#dc3545;">@include('icons.academic.admissions')
                        <p class="text-center m-0 mt-3">Admissions</p>
                </div></a>

        </div>
        
        <div class="col-6 col-sm-4 col-md-2 p-2">
        <a href="{{ route('student_details.index') }}"><div class="topwidget" style="background:#28a745;">@include('icons.academic.student')
                <p class="text-center m-0 mt-3">{{ $data->get('no_of_student') }} - Students</p>
                </div></a>
        </div>

        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="{{ route('staff_details.index') }}"><div class="topwidget"  style="background:#fd7e14;">@include('icons.academic.teacher')
                        <p class="text-center m-0 mt-3">{{ $data->get('no_of_staff') }} - Staffs</p>
                </div></a>

        </div>
       
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="#"><div class="topwidget"  style="background:#17a2b8;">@include('icons.academic.exam')
                        <p class="text-center m-0 mt-3">Marks</p>
                </div></a>
        </div>
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="#"><div class="topwidget"  style="background:#e83e8c;">@include('icons.academic.attendance')
                        <p class="text-center m-0 mt-3">Student Attendance</p>
                </div></a>
        </div>
        <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="#"><div class="topwidget"  style="background:#6f42c1;">@include('icons.academic.courses')
                        <p class="text-center m-0 mt-3">Staff Attendance</p>
                </div></a>
        </div>
    </div>

    <div class="row row-no-padding mt-2">

            <div class="col-6 col-sm-4 col-md-2 p-2">
                    <a href="{{ route('class_details.index') }}"><div class="topwidget"  style="background:#5867dd;">@include('icons.academic.ebook')
                            <p class="text-center m-0 mt-3">Class Details</p>
                    </div></a>
            </div>

              
                        
            <div class="col-6 col-sm-4 col-md-2 p-2">
                    <a href="#"><div class="topwidget" style="background:#ffc107;">@include('icons.academic.homeworks')
                    <p class="text-center m-0 mt-3">Assign Courses</p>
                    </div></a>
            </div>
         
            <div class="col-6 col-sm-4 col-md-2 p-2">
                    <a href="#"><div class="topwidget"  style="background:#6610f2;">@include('icons.academic.frontoffice')
                            <p class="text-center m-0 mt-3">Placements</p>
                    </div></a>
            </div>
            <div class="col-6 col-sm-4 col-md-2 p-2">
                    <a href="{{ route('circulars.index') }}"><div class="topwidget"  style="background:#20c997;">@include('icons.academic.circulars')
                            <p class="text-center m-0 mt-3">Circulars</p>
                    </div></a>
            </div>
        
            <div class="col-6 col-sm-4 col-md-2 p-2">
                    <a href="{{ route('events.index') }}"><div class="topwidget"  style="background:#5867dd;">@include('icons.academic.events')
                            <p class="text-center m-0 mt-3">Events</p>
                    </div></a>
            </div>


            <div class="col-6 col-sm-4 col-md-2 p-2">
                    <a href="{{ route('settings') }}"><div class="topwidget"  style="background:#dc3545;">@include('icons.academic.settings')
                            <p class="text-center m-0 mt-3">Settings</p>
                    </div></a>
            </div>


        </div>


        <div class="row row-no-padding mt-2">

                <div class="col-6 col-sm-4 col-md-2 p-2">
                        <a href="#"><div class="topwidget" style="background:#dc3545;">@include('icons.academic.courses')
                                <p class="text-center m-0 mt-3">Courses</p>
                                </div></a>
                        </div>

            
                <div class="col-6 col-sm-4 col-md-2 p-2">
                        <a href="#"><div class="topwidget"  style="background:#28a745;">@include('icons.academic.transport')
                                <p class="text-center m-0 mt-3">Transport</p>
                        </div></a>
        
                </div>
                
             
        
                <div class="col-6 col-sm-4 col-md-2 p-2">
                        <a href="#"><div class="topwidget"  style="background:#fd7e14;">@include('icons.academic.rupee')
                                <p class="text-center m-0 mt-3">Fees</p>
                        </div></a>
        
                </div>
               
                <div class="col-6 col-sm-4 col-md-2 p-2">
                        <a href="#"><div class="topwidget"  style="background:#17a2b8;">@include('icons.academic.gallery')
                                <p class="text-center m-0 mt-3">Gallery</p>
                        </div></a>
                </div>
                <div class="col-6 col-sm-4 col-md-2 p-2">
                        <a href="#"><div class="topwidget"  style="background:#e83e8c;">@include('icons.academic.report')
                                <p class="text-center m-0 mt-3">Reports</p>
                        </div></a>
                </div>
                <div class="col-6 col-sm-4 col-md-2 p-2">
                <a href="JavaScript:void(0);" id="send_absent" target="_blank"><div class="topwidget"  style="background:#6f42c1;">@include('icons.academic.search')
                                <p class="text-center m-0 mt-3">Send absent</p>
                        </div></a>
                </div>
    



    
    </div>