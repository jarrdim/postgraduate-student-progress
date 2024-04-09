@include('dashboard.header')
@include('dashboard.navsidebar')

<style>




</style>



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

<!---TABS-->

<div class="container mt-3">
  <div class="row gy-2">
    <div class="col-xl-4 nav-tab col-md-6 mb-4" onclick="viewApproved()">
      <div class="nav-link">
        <div class="card border-left-success tab-1 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-success h5 text-uppercase mb-1">
                  APPROVED DOCUMENTS</div>

              </div>
              <div class="col-auto me-2">
                <i class="fa fa-users"></i>
              </div>
            </div>
            <div class="font-weight-bold text-center"> {{$approved}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 nav-tab col-md-6 mb-4 " onclick="viewPending()">
      <div class="nav-link">
        <div class="card border-left-info tab-2 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-info h5 text-uppercase mb-1">
                  PENDING APPROVALS</div>

              </div>
              <div class="col-auto me-2">
                <i class="fa fa-users"></i>
              </div>
            </div>
            <div class="font-weight-bold text-center">{{$pendingApproval}} </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 nav-tab col-md-6 mb-4 " onclick="viewRejected()">
      <div class="nav-link">
        <div class="card border-left-danger tab-3 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-danger h5 text-uppercase mb-1">
                  REJECTED DOCUMENTS</div>

              </div>
              <div class="col-auto me-2">
                <i class="fa fa-users"></i>
              </div>
            </div>
            <div class="font-weight-bold text-center">{{$rejectedCount}} </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!---->







@if(empty($rows) && empty($pendings) && empty($rejectedDocuments))
<div class="container mt-2 card">
  <div class="callout callout-info">
    <h5 class="text-danger"><i class="fas fa-info"></i> Note:</h5>
    No records found
  </div>
</div>
@endif


<!---APPROVED RECORD-->
<div class="d-none" id="approved">
  @if(!empty($rows))



  <div class="container mt-2 card ">
    <!-- /.card-header -->
    <div class="mt-2 h5 text-center font-weight-bold text-info">APPROVED DOCUMENT </div>

    <!--APPROVAL GUIDLINES MODEL Modal -->
    <div class="modal fade" id="approvalGuidline" tabindex="-1" aria-labelledby="approvalGuidline" aria-hidden="true">
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
      <table id="hodtable" class="table   table-striped table-hover text-nowrap">
        <thead>
        
          <tr>
            <th>ID</th>
            <th>Student No</th>
            <th>Student Name</th>
            <th>Submitted</th>
            <th>Checklist</th>
            <th>Document</th>
            <th class="text-center">Action</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @php
        $autoIncrementId = 1;
        @endphp

          @foreach ($rows as $row )
          <tr>
            <td>#{{$autoIncrementId}}</td>
            <td>{{$row->student_number}}</td>
            <td>{{$row->other_names}}</td>
            <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}</td>
            <td>
              <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#approvalGuidline">
                View approval guidlines
              </button>
            </td>

            @if(!empty($row->status_id))
            @if($row->status_id == 1)

            <td>
              @if(file_exists('uploads/'.$row->file))
              <div class="btn btn-info disabled">Pending</div>
              @else
              <div class='text-danger'>N/A</div>
              @endif
            </td>
            <td class="text-primary">Pending</td>
            <td>
              <div class="btn   btn-dark disabled">Pending</div>
            </td>
            <td>
              <div class="btn btn-dark  approve disabled">Pending</div>
            </td>
            @endif

            @if($row->status_id == 2)

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
              <!--  REJECT Modal -->

              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">

                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="alert msg text-center alert-danger">Are you sure you want to reject?</div>
                      <textarea placeholder="Remarks" class="w-100" id="w3review" name="remarks" rows="4"
                        cols="50"></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <div id="modalFinishButton" class="btn btn-primary">Reject</div>
                    </div>
                  </div>
                </div>
              </div>

              <!--END MODEL-->

            </td>
            <td>
              <div onclick="approve('{{$row->file_id}}')" class="btn btn-success  approve">Approve</div>
            </td>
            @endif

            @else()
            <td class="text-warning" colspan=2>N\A</td>
            @endif





          </tr>
          @php
        $autoIncrementId++;
        @endphp
          @endforeach

        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  @endif
</div>

<!---PENDING APPROVAL--->
<div class="d-none" id="pending">
  @if(!empty($pendings))
  <div class="container mt-3 mb-4 card ">
    <div class="mt-2 h5 text-center font-weight-bold text-warning">PENDING APPROVALS</div>
    <div class="card-body table-responsive p-0">

      <table id="hodtable1" class="table    table-hover text-nowrap">

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

        

        <tbody>
        @php
        $autoIncrementId = 1;
        @endphp
        @foreach ($pendings as $row )
        <tr>
          <td>#{{$autoIncrementId}}</td>
          <td>{{$row->student_number}}</td>
          <td>{{$row->other_names}}</td>
          <td>{{$row->primary_email}}</td>
          <td>{{$row->primary_phone_no}}</td>
          <td class="text-danger">Pending</td>
        </tr>
        @php
        $autoIncrementId++;
        @endphp
        @endforeach
        </tbody>
        
      </table>
    </div>
  </div>
  @endif
</div>
<!---REJECTED RECORDS (DOCUMENTS)--->
<div class="d-none" id="rejected">
  @if(!empty($rejectedDocuments))
  <div class="container mt-3 mb-4 card ">
    <div class="mt-2 h5 text-center font-weight-bold text-danger">REJECTED DOCUMENTS</div>
    <div class="card-body table-responsive p-0">

      <table id="hodtable2" class="table    table-hover text-nowrap">

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
       

        <tbody>

        @php
        $autoIncrementId = 1;
        @endphp
        @foreach ($rejectedDocuments as $row )
          <tr>
          <td>#{{$autoIncrementId}}</td>
          <td>{{$row->student_number}}</td>
          <td>{{$row->other_names}}</td>
          <td>{{$row->primary_email}}</td>
          <td>{{$row->primary_phone_no}}</td>
          <td class="text-danger">Rejected</td>
        </tr>
        @php
        $autoIncrementId++;
        @endphp
        @endforeach
        </tbody>
       
      </table>
    </div>
  </div>
  @endif
</div>

@include('dashboard.footer')





<script>


  var tab1 = document.querySelector(".tab-1");
  tab1.classList.add("border-bottom-primary");
  var tab2 = document.querySelector(".tab-2");
  var tab3 = document.querySelector(".tab-3");

  var approved = document.querySelector("#approved");
  approved.classList.remove('d-none');

  $(document).ready(function () {



    $('#hodtable1').DataTable();
    $('#hodtable2').DataTable();

    $('#hodtable').DataTable();
  });

  function viewApproved() {
    tab1.classList.add("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");

    var pending = document.querySelector("#pending");
    pending.classList.add('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.remove('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.add('d-none');
  }
  function viewPending() {
    tab2.classList.add("border-bottom-primary");
    tab1.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");

    var pending = document.querySelector("#pending");
    pending.classList.remove('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.add('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.add('d-none');
  }
  function viewRejected() {

    tab3.classList.add("border-bottom-primary");
    tab1.classList.remove("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    var pending = document.querySelector("#pending");
    pending.classList.add('d-none');
    var approved = document.querySelector("#approved");
    approved.classList.add('d-none');
    var rejected = document.querySelector("#rejected");
    rejected.classList.remove('d-none');
  }




  function download(file) {
    //alert(file);   
    $.ajax({
      url: "{{ route('hod_download') }}",
      method: 'GET',
      data: { filename: file },
      dataType: 'json',
      success: function (response) {

        if (response.success) {
          // Create a temporary anchor element and initiate download

          var link = document.createElement('a');
          link.href = "{{url('/')}}/" + response.url;
          link.download = file;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        } else {
          // Handle the error (e.g., file not found)

        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX error
        console.log(error);
      }
    });
  }
  function approve(id) {

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
      url: "{{ route('hod_approve') }}",
      method: 'GET',
      data: { file_id: id },
      dataType: 'json',
      success: function (response) {

        if (response.success) {
          // Create a temporary anchor element and initiate download


          // Call the showtoast function after a delay
          spinnerContainer.classList.remove('d-none');
          showtoast(response.success);



        } else {
          // Handle the error (e.g., file not found)
          // console.log(response.message);
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX error
        console.log(error);
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
  function reject(id) {

    var spinnerContainer = document.querySelector(".spinner-container");

    var remarks = document.querySelector("textarea");
    var msg = document.querySelector(".msg");
    if (remarks.value != "") {
      remarksmsg = remarks.value;
    }
    else {
      msg.innerHTML = "Remarks field is required !";
      return;

    }
    spinnerContainer.classList.remove('d-none');

    $.ajax({
      url: "{{ route('hod_reject') }}",
      method: 'GET',
      data: { file_id: id, remarks: remarksmsg },
      dataType: 'json',
      success: function (response) {


        if (response.success) {
          // Create a temporary anchor element and initiate download

          // Call the showtoast function after a delay
          spinnerContainer.classList.remove('d-none');
          showtoast(response.success);

        }
        if (response.error) {
          spinnerContainer.classList.remove('d-none');
          showtoast(response.error);
        }
        if (response.errorMSG) {

          spinnerContainer.classList.add('d-none');
          msg.innerHTML = response.errorMSG;
        }

      },
      error: function (xhr, status, error) {
        // Handle AJAX error
        console.log(error);
      }
    });
  }

  function showtoast(msg) {

    var box = document.querySelector("#toastBox");
    box.classList.remove('d-none');
    var toast = document.querySelector(".toastmsg");
    toast.innerHTML = msg;
    setTimeout(() => {

      box.classList.add("d-none");
      location.reload();
    }, 600);

  }


</script>