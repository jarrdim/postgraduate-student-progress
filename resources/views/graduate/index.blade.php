@include('dashboard.header')
@include('dashboard.navsidebar')

<style>




</style>
<div class="container p-3">
    @if(session('message'))
    <div class="alert {{session('alert-class')}} text-center">{{session('message')}}</div>
    @endif
</div>


    <div class="spinner-container d-none">
        <div class="spinner-border text-primary spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!--TOAST-->

    



<div id="toastBox" class="d-none">
    
<div class="toastmsg text-light bg-info">

</div>
</div>

<div class="container-fluid ">
  <div class="row justify-content-center text-center ">
    <!--APPROVED DOCUMENTS-->
    <div class="col-xl-2 nav-tab col-md-12 mb-4 " onclick = "viewApproved()">
      <div class="nav-linkj">
        <div class="card border-left-success tab-1 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div  class="text-xs font-weight-bold text-success h5 text-uppercase mb-1">
                  APPROVED DOCUMENTS</div>

              </div>
          
            </div>
            <div class="font-weight-bold text-center"> {{$approved}}  <i class="fas fa-file"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 nav-tab col-md-12 mb-4" onclick = "viewPending()">
      <div class="nav-linkk" >
        <div class="card border-left-info tab-2 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-info h5 text-uppercase mb-1">
                  PENDING APPROVALS</div>

              </div>
          
            </div>
            <div class="font-weight-bold text-center">{{$pendingApproval}} <i class="fas fa-file"></i> </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 nav-tab col-md-12 mb-4" onclick = "viewCompleted()">
      <div class="nav-linkl" >
        <div class="card border-left-secondary tab-5 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-secondary h5 text-uppercase mb-1">
                COMPLETED STUDENTS</div>

              </div>
          
            </div>
            <div class="font-weight-bold text-center">{{$completedCount}} <i class="fas fa-users"></i> </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 nav-tab col-md-12 mb-4 " onclick = "viewRejected()">
      <div class="nav-linkl" >
        <div class="card border-left-danger tab-3 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-danger h5 text-uppercase mb-1">
                  REJECTED DOCUMENTS</div>

              </div>
        
            </div>
            <div class="font-weight-bold text-center">{{$rejectedCount}}  <i class="fas fa-file"></i></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 nav-tab col-md-12 mb-4 " onclick="remainingStudents()">
      <div class="nav-linkl" >
        <div class="card border-left-danger tab-4 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-danger h5 text-uppercase mb-1">
                  REMAINING STUDENTS</div>

              </div>
           
            </div>
            <div class="font-weight-bold text-center">{{$remainingCount}}  <i class="fa fa-users"></i> </div>
          </div>
        </div>
      </div>
    </div>
     

  </div>
</div>


<div class="d-none" id="approved">
@if(!empty($rows))
<!--APPROVED DOCUMENTS-->
<div class="container mt-2 card">
  <!-- /.card-header -->
  <div class="mt-2 h5 text-center font-weight-bold text-success">APPROVALED BY DEAN</div>

          <!--APPROVAL GUIDLINES MODEL Modal -->
          <div class="modal fade" id="approvalGuidline" tabindex="-1" aria-labelledby="approvalGuidline"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <div class="font-weight-bold">APPROVAL GUIDLINES</div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              1. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa sit iusto veritatis 
              <br>2. omnis quas in mollitia reiciendis. Sint, aliquid corrupti quibusdam itaque expedita ut

                <br>3. voluptates similique eius, deserunt eligendi dolore?
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                
              </div>
            </div>
          </div>
        </div>

        <!--END MODEL-->
  <div class="card-body table-responsive p-0">
    <table id="searchTable1" class="table   table-striped table-hover text-nowrap">
      <thead>
        <tr>
          <th>ID</th>
          <th>Student No</th>
          <th>Student Name</th>
          <th>Submitted</th>
          <th>Checklist</th>
          <th>Document</th>
          
         
          <th>Action</th>
          <th class="text-center">Action</th>
          
        </tr>
      </thead>
      <tbody>
      @php
        $autoIncrementId = 1;
        @endphp
        @foreach ($rows as $row )
                    

        <tr>
          <td>#{{ $autoIncrementId}}</td>
          <td>{{$row->student_number}}</td>
          <td>{{$row->other_names}}</td>

       

          <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}</td>
          <td>
          <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#approvalGuidline">
                  View approval guidlines
            </button>
          </td>
          
          <td>
              @if(file_exists('uploads/'.$row->file))
              <div onclick="download('{{ $row->file }}')" class="btn btn-info">download</div>
              @else
              <div class='text-danger'>N/A</div>
              @endif
            </td>
            <td><button type="button" data-row-id="{{$row->file_id}}" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Reject
              </button>
            <td>
              <div onclick="approve('{{$row->file_id}}')" class="btn btn-success  approve">Approve</div>
            </td>
        </tr>
        @php
        $autoIncrementId++;
        @endphp
        @endforeach

      </tbody>
    </table>

            <!-- REJECT MODEL -->

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="alert msg text-center alert-danger">Are you sure you want to reject?</div>
                    <textarea  placeholder="Remarks" class="w-100" id="w3review" name="remarks" rows="4" cols="50"></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <div id="modalFinishButton"  class="btn btn-primary">Finish</div>
                  </div>
                </div>
              </div>
            </div>

            <!--END MODEL-->
  </div>
  <!-- /.card-body -->
</div>
@endif
</div>


<!---PENDING APPROVAL--->
<div class="d-none" id="pending">
@if(!empty($pendings))
<div class="container mt-3 mb-4 card" >
  <div class="mt-2 h5 text-center font-weight-bold text-warning">PENDING APPROVALS</div>
  <div class="card-body table-responsive p-0">

    <table id="searchTable2" class="table    table-hover text-nowrap">

      <thead>
        <tr>
          <th>ID</th>
          <th>Student No</th>
          <th>Student Name</th>
          <th>Student Email</th>
          <th>Phone</th>
          <th>Status</th>
        </tr>
      </thead>
      @php
        $autoIncrementId = 1;
        @endphp
      @foreach ($pendings as $row )

      <tbody>
        <td>#{{$autoIncrementId}}</td>
        <td>{{$row->student_number}}</td>
        <td>{{$row->other_names}}</td>
        <td>{{$row->primary_email}}</td>
        <td>{{$row->primary_phone_no}}</td>
        <td class="text-danger">Pending</td>
      </tbody>
      @php
        $autoIncrementId++;
        @endphp
      @endforeach
    </table>
  </div>
</div>
@endif
</div>

<!---COMPLETED STUDENTS--->
<div class="d-none" id="completed">
@if(!empty($completed))
<div class="container mt-3 mb-4 card" >
  <div class="mt-2 h5 text-center font-weight-bold text-warning">COMPLETED STUDENTS</div>
  <div class="card-body table-responsive p-0">

    <table id="searchTable3" class="table    table-hover text-nowrap">

      <thead>
        <tr>
          <th>ID</th>
          <th>Student No</th>
          <th>Student Name</th>
          <th>Student Email</th>
          <th>Phone</th>
          <th>Status</th>
        </tr>
      </thead>
      @php
        $autoIncrementId = 1;
        @endphp
      @foreach ($completed as $row )

      <tbody>
        <td>#{{$autoIncrementId}}</td>
        <td>{{$row->student_number}}</td>
        <td>{{$row->other_names}}</td>
        <td>{{$row->primary_email}}</td>
        <td>{{$row->primary_phone_no}}</td>
        <td class="text-success">Completed</td>
      </tbody>
      @php
        $autoIncrementId++;
        @endphp
      @endforeach
    </table>
  </div>
</div>
@endif
</div>

<!---REJECTED RECORDS (DOCUMENTS)--->
<div class="d-none" id="rejected">
@if(!empty($rejectedDocuments))
<div class="container mt-3 mb-4 card" >
  <div class="mt-2 h5 text-center font-weight-bold text-danger">REJECTED DOCUMENTS</div>
  <div class="card-body table-responsive p-0">

    <table id="searchTable4" class="table    table-hover text-nowrap">

      <thead>
        <tr>
          <th>ID</th>
          <th>Student No</th>
          <th>Student Name</th>
          <th>Student Email</th>
          <th>Phone</th>
          <th>Status</th>
        </tr>
      </thead>
      @php
        $autoIncrementId = 1;
        @endphp
      @foreach ($rejectedDocuments as $row )

      <tbody>
        <td>#{{$autoIncrementId}}</td>
        <td>{{$row->student_number}}</td>
        <td>{{$row->other_names}}</td>
        <td>{{$row->primary_email}}</td>
        <td>{{$row->primary_phone_no}}</td>
        <td class="text-danger">Rejected</td>
      </tbody>
      @php
        $autoIncrementId++;
        @endphp
      @endforeach
    </table>
  </div>
</div>
@endif
</div>


<!---REMAINING STUDENTS--->
<div class="d-none" id="remainingStudent">
@if(!empty($remaingStudents))
<div class="container mt-3 mb-4 card" >
  <div class="mt-2 h5 text-center font-weight-bold text-info">REMAINING STUDENTS</div>
  <div class="card-body table-responsive p-0">

    <table id="searchTable5" class="table    table-hover text-nowrap">

      <thead>
        <tr>
          <th>ID</th>
          <th>Student No</th>
          <th>Student Name</th>
          <th>Student Email</th>
          <th>Phone</th>
          <th>Status</th>
        </tr>
      </thead>
      @php
        $autoIncrementId = 1;
        @endphp
      @foreach ($remaingStudents as $row )

      <tbody>
        <td>#{{$autoIncrementId}}</td>
        <td>{{$row->student_number}}</td>
        <td>{{$row->other_names}}</td>
        <td>{{$row->student_email}}</td>
        <td>+{{$row->student_phone}}</td>
        <td class="text-danger">Await</td>
      </tbody>
      @php
        $autoIncrementId++;
        @endphp
      @endforeach
    </table>
  </div>
</div>
@endif
</div>

@include('dashboard.footer')



<script>


$(document).ready(function () {
    $('#searchTable1').DataTable();
    $('#searchTable2').DataTable();
    $('#searchTable3').DataTable();
    $('#searchTable4').DataTable();
    $('#searchTable5').DataTable();
  });



    var tab1 = document.querySelector(".tab-1");
    tab1.classList.add("border-bottom-primary");
    var tab2 = document.querySelector(".tab-2");
    var tab3 = document.querySelector(".tab-3");
    var tab4 = document.querySelector(".tab-4");
    var tab5 = document.querySelector(".tab-5");

    var approved = document.querySelector("#approved");
    approved.classList.remove('d-none');
  function viewApproved()
  {
    tab1.classList.add("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");
    tab4.classList.remove("border-bottom-primary");
    tab5.classList.remove("border-bottom-primary");

    var pending = document.querySelector("#pending");
    pending.classList.add('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.remove('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.add('d-none');
    var remainingStudent = document.querySelector("#remainingStudent");
    remainingStudent.classList.add('d-none');

    var completed = document.querySelector("#completed");
    completed.classList.add('d-none');
  }
  function viewCompleted()
  {
    tab1.classList.remove("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");
    tab4.classList.remove("border-bottom-primary");
    tab5.classList.add("border-bottom-primary");

    var pending = document.querySelector("#pending");
    pending.classList.add('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.add('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.add('d-none');
    var remainingStudent = document.querySelector("#remainingStudent");
    remainingStudent.classList.add('d-none');
    var completed = document.querySelector("#completed");
    completed.classList.remove('d-none');
  }
  function viewPending()
  {
    tab2.classList.add("border-bottom-primary");
    tab1.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");
    tab4.classList.remove("border-bottom-primary");
    tab5.classList.remove("border-bottom-primary");
    
   
    var pending = document.querySelector("#pending");
    pending.classList.remove('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.add('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.add('d-none');
    var remainingStudent = document.querySelector("#remainingStudent");
    remainingStudent.classList.add('d-none');

    var completed = document.querySelector("#completed");
    completed.classList.add('d-none');
  }
  function viewRejected()
  {
   
    tab3.classList.add("border-bottom-primary");
    tab1.classList.remove("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab4.classList.remove("border-bottom-primary");
    tab5.classList.remove("border-bottom-primary");

    var pending = document.querySelector("#pending");
    pending.classList.add('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.add('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.remove('d-none');
    var remainingStudent = document.querySelector("#remainingStudent");
    remainingStudent.classList.add('d-none');

    var completed = document.querySelector("#completed");
    completed.classList.add('d-none');
  }
  function remainingStudents()
  {
    tab4.classList.add("border-bottom-primary");
    tab1.classList.remove("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");
    tab5.classList.remove("border-bottom-primary");

    var remainingStudent = document.querySelector("#remainingStudent");
    remainingStudent.classList.remove('d-none');
    var pending = document.querySelector("#pending");
    pending.classList.add('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.add('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.add('d-none');

    var completed = document.querySelector("#completed");
    completed.classList.add('d-none');
  }



      function download(file)
    {
        //alert(file);   
        $.ajax({
            url: "{{ route('graduate_download') }}",
            method:'GET',
            data:{filename:file},
            dataType:'json',
            success: function(response) {
             
            if (response.success) {
                // Create a temporary anchor element and initiate download

                var link = document.createElement('a');
                link.href ="{{url('/')}}/"+ response.url;
                link.download = file;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // Handle the error (e.g., file not found)
                console.log(response.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX error
            console.log(error);
        }
    });
}
function approve(id)
  {

    var userResponse = window.confirm("Do you want to continue?");
    if (userResponse) {
      // Code to execute if the user clicks "OK" (Continue)
      
    } else {
      // Code to execute if the user clicks "Cancel"
      //alert("You clicked Cancel. The process is canceled.");
      return;
    }
    
    var spinnerContainer = document.querySelector(".spinner-container");
    spinnerContainer.classList.remove('d-none');
      
      $.ajax({
          url: "{{ route('graduate_approve') }}",
          method:'GET',
          data:{file_id:id},
          dataType:'json',
          success: function(response) {
          
          if (response.success) {
              // Create a temporary anchor element and initiate download
        

              // Call the showtoast function after a delay
             spinnerContainer.classList.remove('d-none');
            showtoast(response.success);
            
            

          }
          if(response.error){
            spinnerContainer.classList.remove('d-none');
            showtoastError(response.error);
          }
      },
      error: function(xhr, status, error) {
          // Handle AJAX error
       
      }
  });
}

document.addEventListener("click", function (event) {
    const clickedElement = event.target;
    if (clickedElement && clickedElement.dataset.rowId) {
        currentRowId = clickedElement.dataset.rowId;
        const modalFinishButton = document.getElementById("modalFinishButton");
        modalFinishButton.onclick = function () {
          reject(currentRowId);
        };
    }
  });

function reject(id)
  {
  
    var spinnerContainer = document.querySelector(".spinner-container");

    var remarks = document.querySelector("textarea");
    var msg = document.querySelector(".msg");
    if(remarks.value != "")
    {
      remarksmsg = remarks.value;
    }
    else{
      msg.innerHTML = "Remarks field is required !";
      return;
      
    }

    spinnerContainer.classList.remove('d-none');
      
      $.ajax({
          url: "{{ route('graduate_reject') }}",
          method:'GET',
          data:{file_id:id,  remarks: remarksmsg},
          dataType:'json',
          success: function(response) {
          if (response.success) {
              // Create a temporary anchor element and initiate download
        
              // Call the showtoast function after a delay
              spinnerContainer.classList.remove('d-none');

              showtoast(response.success);
            
          }
          if(response.error)
          {
           spinnerContainer.classList.remove('d-none');
         
          showtoastError(response.error);
          } 
          if(response.errorMSG)
          {
          
            spinnerContainer.classList.add('d-none');
            msg.innerHTML = response.errorMSG;
          }
       
      },
      error: function(xhr, status, error) {
          // Handle AJAX error
          console.log(error);
      }
  });
}

function showtoast(msg)
{
  
    var box = document.querySelector("#toastBox");
    box.classList.remove('d-none');
    var toast = document.querySelector(".toastmsg");
    toast.innerHTML = msg;
    setTimeout(()=>{
        
       box.classList.add("d-none");
       location.reload();
    },600);

}
function showtoastError(msg)
{
  
    var box = document.querySelector("#toastBox");
    box.classList.remove('d-none');
    var toast = document.querySelector(".toastmsg");

     toast.classList.remove('bg-info');
    toast.classList.add('bg-danger');
    toast.innerHTML = msg;
    setTimeout(()=>{
        
       box.classList.add("d-none");
      location.reload();
    },600);

}
</script>


