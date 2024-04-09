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


<div class="container mt-2 card">
  <!-- /.card-header -->
  @if(!empty($rows))
  <div class="card-body  mt-3 table-responsive p-0">
    <table id="supervisortable1" class="table   table-striped table-hover text-nowrap">
      <thead>
        <tr>
          <th>ID</th>
          <th>Student No</th>
          <th>Student Name</th>
          <th>Submitted</th>
          <th>Checklist</th>
          <th>Document</th>

        
          <th  class="text-center">Action</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @php
          $autoIncrementId = 1;
          @endphp
        @foreach ($rows as $row )

        <tr>

        
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

          @if(!empty($row->status_id))
          @if($row->status_id == 1)
          <td>#{{$autoIncrementId}}</td>
          <td>{{$row->student_number}}</td>
          <td>{{$row->other_names}}</td>
          <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}</td>
          <td>
          <button type="button" class="btn btn-light disabled" data-bs-toggle="modal" data-bs-target="#approvalGuidline">
                  View approval guidlines
            </button>
          </td>
          <td >
            @if(file_exists('uploads/'.$row->file))
            <div class="btn btn-info disabled">Pending</div>
            @else
            <div class='text-danger'>N/A</div>
            @endif
          </td>
          <td class="text-primary text-center">Pending</td>
        
          @endif

          @if($row->status_id == 2)
          <td>#{{$autoIncrementId}}</td>
          <td>{{$row->student_number}}</td>
          <td>{{$row->other_names}}</td>
          <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}</td>
          <td ><button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#approvalGuidline">
                  View approval guidlines
            </button>
             
            <td>
              @if(file_exists('uploads/'.$row->file))
              <div onclick="download('{{ $row->file }}')" class="btn btn-info">download</div>
              @else
              <div class='text-danger'>N/A</div>
              @endif
            </td>
          
            <td><button  type="button" data-row-id="{{$row->file_id}}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Reject
              </button>

              <!--REJECT  Modal -->

              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="alert alert-danger msg text-center">Are you sure you want to reject?</div>

                      <textarea placeholder="Remarks" class="w-100" id="w3review" name="remarks" rows="4" cols="50"></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <div id="modalFinishButton" class="btn btn-primary">Finish</div>
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
          <td class="text-warning" colspan=2>N\A {{$row->status_id}}</td>
          @endif





        </tr>
        @php
        $autoIncrementId++;
        @endphp
        @endforeach

      </tbody>
    </table>
  </div>
  @endif
  <!-- /.card-body -->
</div>



@include('dashboard.footer')



<script>

$(document).ready(function () {
    $('#supervisortable1').DataTable();
  
    
    

  });



  function download(file) {
    //alert(file);   
    $.ajax({
      url: "{{ route('download') }}",
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
       
      }
    });
  }
  function approve(id) {

      var userResponse = window.confirm("Do you want to continue?");
      if (userResponse) {
        // Code to execute if the user clicks "OK" (Continue)
        
      } else {
        // Code to execute if the user clicks "Cancel"
        return;
      }


  

    var spinnerContainer = document.querySelector(".spinner-container");
    spinnerContainer.classList.remove('d-none');

    $.ajax({
      url: "{{ route('approve') }}",
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
          
        }
      },
      error: function (xhr, status, error) {
        // Handle AJAX error
        //console.log(error);
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
      url: "{{ route('reject') }}",
      method: 'GET',
      data: { file_id: id , remarks: remarksmsg },
      dataType: 'json',
      success: function (response) {

      

        if (response.success) {
          // Create a temporary anchor element and initiate download

          // Call the showtoast function after a delay
          spinnerContainer.classList.remove('d-none');
          location.reload();
          //showtoast(response.success);

        }
        if (response.error) {
          spinnerContainer.classList.remove('d-none');
          showtoast(response.error);
        }
        if(response.errorMSG)
        {
        
          spinnerContainer.classList.add('d-none');
          msg.innerHTML = response.errorMSG;
        }

      },
      error: function (xhr, status, error) {
        // Handle AJAX error
        //console.log(error);
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