@include('dashboard.header')
@include('dashboard.navsidebar')





<div class="container p-3">
    @if(session('message'))
    <div class="alert {{session('alert-class')}} text-center">{{session('message')}}</div>
    @endif
</div>


<div class="upload container text-center">
    <div class="row">
        <div class="col-md-12 t">
        <!---START-->
        @if(!empty($status))
            @if( $status == 3)
    
            @else
            <div class="containerl prog-container mx-auto">
            <div class="progress-bar-css d-flex ">
                <div class="step">
                    <p>
                        Pending
                    </p>
                    <div class="bullet">
                        <span>1</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>
                       Raised
                    </p>
                    <div class="bullet">
                        <span>2</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>
                        progress
                    </p>
                    <div class="bullet">
                        <span>3</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>
                        .....
                    </p>
                    <div class="bullet">
                        <span>4</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
                <div class="step">
                    <p>
                        Approved
                    </p>
                    <div class="bullet">
                        <span>5</span>
                    </div>
                    <div class="check fas fa-check"></div>
                </div>
            </div>
        </div>
            @endif
        @endif

        <!--STOP-->

        </div>
    </div>
    <form action="{{ route('upload') }}" enctype="multipart/form-data" method="post"
        class="upload-files card text-center p-2">
        @csrf

        @if(!empty($status))
        <input class="input-status" type="hidden" value="{{$file_id}}">
  
        @if($status == 1)
       
        <div class=" " id="drop">
            <i class="fa fa-file-text-o pointer-none" aria-hidden="true"></i>
            <p class="pointer-none text-primary"><b>STATUS PENDING</b><br /></p>

            <div class="text-center mt-1">
                <div href="" id="triggerFile"></div>
                <div class="bg-light mb-3" id="uploadImg" type="file" name="file">
                    <div>Please confirm the submission !</div>
                </div>
            </div>
            <div>
                {{$file_name}}
            </div>

            <footer>
                @if(!empty($file_id))
                <a href="{{ url('/') }}/student/change/{{$file_id}}/{{$status}}" class="btn btn-info mt-3">CHANGE</a>
                <a href="{{ url('/') }}/student/submit/{{$file_id}}" class="btn btn-success mt-3">PLEASE CONFIRM THE
                    SUBMISSION</a>
                @endif
            </footer>
        </div>
        @elseif($status == 3)
       
        <div class=" " id="drop">
            @if($errors->has('file'))
            <span class="errormsg alert alert-danger text-danger">{{ $errors->first('file') }}</span>
            @endif
            <p class="pointer-none text-danger"><b>YOUR DOCUMENT WAS REJECTED PLEASE UPLOAD ANOTHER DOCUMENT</b><br /></p>
            <i class="fa fa-file-text-o pointer-none" aria-hidden="true"></i>
            <p class="pointer-none"><b>Drag and drop</b> file here <br /></p>
            or
            <div class="text-center mt-1">
                <div href="" id="triggerFile"></div>
                <input class="bg-light mb-3" id="uploadImg" type="file" name="file">
                <div>to begin the upload</div>
            </div>
        </div>
        <footer class="mt-3">
            <input type="submit" name="submit" value="UPLOAD DOCUMENT" class="btn btn-success">
        </footer>
        @else

        <div class=" " id="drop">
            <i class="fa fa-file-text-o pointer-none" aria-hidden="true"></i>
            @if(!empty($statusName))
            <p class="pointer-none text-primary"><b>{{$statusName}}</b><br /></p>
            @endif
            <div class="text-center mt-1">
                <div href="" id="triggerFile"></div>
            <div class="mt-2 mb-2">
                {{$file_name}}
            </div>
                <div class="bg-light mb-3" id="uploadImg" type="file" name="file">
                    @if($status == 4)
                        SUCCESS
                    @else
                    <div>Document submitted for review</div>
                    @endif
                    
                </div>
            </div>





            <footer>
                @if(!empty($file_id))

                <div class="btn btn-success mt-3 disabled">SUBMITTED</div>
                @endif
            </footer>
        </div>
        @endif
        @else
        <div class=" " id="drop">
            @if($errors->has('file'))
            <span class="errormsg alert alert-danger text-danger">{{ $errors->first('file') }}</span>
            @endif
            <i class="fa fa-file-text-o pointer-none" aria-hidden="true"></i>
            <p class="pointer-none"><b>Drag and drop</b> file here <br /></p>
            or
            <div class="text-center mt-1">
                <div href="" id="triggerFile"></div>
                <input class="bg-light mb-3" id="uploadImg" type="file" name="file">
                <div>to begin the upload</div>
            </div>
        </div>
        <footer class="mt-3">
            <input type="submit" name="submit" value="UPLOAD DOCUMENT" class="btn btn-success">
        </footer>
        <div class="input-status" type="hidden"><div>
        @endif
        
    </form>

</div>
@include('dashboard.footer')
<script>
    $(document).ready(function () {
    // Init
    // trigger input
    $("#triggerFile").on("click", function (evt) {
        evt.preventDefault();
        $("input[type=file]").click();
    });

    // drop events
    $("#drop").on("dragleave", function (evt) {
        $("#drop").removeClass("active");
        evt.preventDefault();
    });

    $("#drop").on("dragover dragenter", function (evt) {
        $("#drop").addClass("active");
        evt.preventDefault();
    });

    $("#drop").on("drop", function (evt) {
        evt.preventDefault();
        const files = evt.originalEvent.dataTransfer.files;
        if (files.length === 1) { // Check if only one file is dropped
            $("input[type=file]")[0].files = files;
            $("footer").addClass("hasFiles");
        }
        $("#drop").removeClass("active");
    });

    //console.log('Document is ready');


    
    var statusRoute = "{{ route('status') }}";

    const progressCheck = document.querySelectorAll(".step .check");
    const progressText = document.querySelectorAll(".step p");
    const bullet = document.querySelectorAll(".step .bullet");
    let current = 1;

    
    var id = document.querySelector('.input-status').value;
  


    $.ajax({
        url: statusRoute,
        method: 'GET',
        data: { student_id: id },
        dataType: 'json',
        success: function (response) {

            //alert(response.ss);

            if(response.level_id == 1 && response.status == 1)
            {
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                
                
              
            }
            if(response.level_id == 1 && response.status == 3)
            {
            
                if (current >= 1 && current <= bullet.length) {
                    bullet[current - 1].classList.add("active");
                    progressCheck[current - 1].classList.add("reject");
                    progressText[current - 1].classList.add("reject");
                }
               
             

            }
            if(response.level_id == 2)
            {
                
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                // current = 2;
                // bullet[current - 1].classList.add("active");
                // progressCheck[current - 1].classList.add("active");
                // progressText[current - 1].classList.add("active");
                
             
            }
            if(response.level_id == 3)
            {
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 2;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                // current = 3;
                // bullet[current - 1].classList.add("active");
                // progressCheck[current - 1].classList.add("active");
                // progressText[current - 1].classList.add("active");
                
            }
            if(response.level_id == 4)
            {
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 2;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 3;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
           
            }
    
            if(response.level_id == 5 && response.status == 2)
            {
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 2;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 3;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 4;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                
              
            }
            if(response.level_id == 6 && response.status == 4)
            {
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 2;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 3;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 4;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current = 5;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                
              
            }
            if (response.success) {
                // Handle success
            }
            if (response.error) {
                // Handle error
            }
        },
        error: function (xhr, status, error) {
            console.log("AJAX error:");
        }
    });
});

</script>

