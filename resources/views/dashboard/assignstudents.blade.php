@include('dashboard.header')
@include('dashboard.navsidebar')
<!-- End of Topbar -->
<style>

.modal {
    z-index: 1050; /* or a higher value if needed */
}

</style>

    <div class="spinner-container d-none">
        <div class="spinner-border text-primary spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

<!--TOAST--->

<div onclick="showtoast()" class="btn">
   
</div>


<div id="toastBox" class="d-none">
    
<div class="toastmsg text-light bg-info">

</div>
</div>




<!--SELECT LEAD SUPERVISOR -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">

      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <div class="text-center font-weight-bold">SELECT LEAD SUPERVISOR</div>
    <select id="selectSupervisors" class="form-select" aria-label="Select Supervisor">
       <!-- Options will be added here -->
    </select>
      
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <div id="modalFinishButton"   class="btn btn-primary">SAVE</div>
    </div>
  </div>
</div>
</div>

<!--END MODEL-->

<!-- Begin Page Content -->
<div class="container-fluid ">

  <!-- Page Heading -->
  <div class="row ">
    <div class="col-md-12 col-sm-12">
      <!-- /.card -->
      <div data-aos="fade-zoom-in"
     data-aos-easing="ease-in-back"
     data-aos-delay="300"
     data-aos-offset="0"  class="card"
        style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
        <!-- /.card-header -->
        <div class="card-body">
          <!-- MAIN CONTENT -->
          <!-- /.row -->
          <div class="row gy-1">
            @if(!empty($rows))
            
            <div class="col-md-12 text-end  ">
          <div class="float-left  text-start">
          @if(!empty($registrationNumber))
            <div class=" fw-bold text-primary "><span class="text-dark">REG NO:</span> {{$registrationNumber}}</div>
              @endif
              @if( !empty($other_names))
            <div class=" fw-bold text-primary "><span class="text-dark">NAME:</span>{{$other_names}}</div>
              @endif
              @if( !empty($prog_short_name))
            <div class=" fw-bold text-primary "><span class="text-dark">PROGRAM:</span>{{$prog_short_name}}</div>
              @endif
              @if( !empty($email))
            <div class=" fw-bold text-primary "><span class="text-dark">EMAIL:</span>{{$email}}</div>
              @endif
         
           
          </div>
       
         
         
              <a href="{{'/dashboard/students'}}" class="btn btn-dark btn-sm btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-backward"></i>
                </span>
                <span class="text">ASSIGN NEW STUDENT</span>
              </a>
            
              <a href="{{url('dashboard/viewassigned/')}}/{{$studentId}}" class="btn btn-info btn-sm btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-eye text-light"></i>
                </span>
                @if(!empty($studentProfile))
                <span class="text">VIEW ASSIGNED</span>

                @else
                <span>N/A</span>
                @endif
              </a>
              <div id="submitBtn"  class="btn btn-primary btn-sm btn-icon-split disabled save ">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text ">SAVE SELECTED</span>
               
              </div>



            </div>
            <div class="col-12 p-2  ">
              <!-- /.card-header -->
              <form action="" class=" ">
                @csrf
                <div class="table-responsive">
                  <table id="example" class="table  table-hover text-nowrap table-striped">
                    <thead>
                      <tr style="font-size:0.9rem !important;">
                        <th class="bg-dark text-start">All <input type="checkbox" id="checkAll">

                        </th> <!-- Add the checkbox here -->
                        <th>#Id</th>
                        <th>Payroll No.</th>
                        <th>Title</th>
                        <th>Surname</th>
                        <th style="width: 20px;">Other Names</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $row )
                      <tr>
                        <td>
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox1" checked="">
                            <label class="custom-control-label"></label>
                          </div>
                        </td>
                        <td>{{$row->id}}</td>
                        <td>{{$row->payroll_number}}</td>
                        <td>{{$row->title}}</td>
                        <td>{{$row->surname}}</td>
                        <td style="width: 20px;">{{$row->other_names}}</td>
                        @if(!empty($row->phone_number))
                        <td class="">{{$row->phone_number}}</td>
                        @else
                        <td class="text-danger">N/A</td>
                        @endif
                        <td>{{$row->email}}</td>
                        <td class="text-danger">N/A</td>
                      </tr>
                      @endforeach

                    </tbody>
                  </table>


                </div>
              </form>

              <!-- /.card-body -->
            </div>
            @else
            <div class="callout callout-info">
              <h5 class="text-danger"><i class="fas fa-info"></i> Note:</h5>
              No records found
            </div>
            @endif
          </div>
          <!-- /.row -->
          <!--END MAIN CONTENT-->
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; University of Nairobi PostGraduate System 2023</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="login.html">Logout</a>
      </div>
    </div>
  </div>
</div>
@include('dashboard.footer')


<script>
/*
  $(document).ready(function () {

    

    var btn = document.querySelector('.save');

    // Function to handle the "Uncheck All" functionality
    $("#checkAll").on("click", function () {
      var isChecked = $(this).prop("checked");
      $("table tbody tr .custom-control-input").prop("checked", isChecked);

    });

    //START

    // Function to uncheck all checkboxes when the page loads
    function uncheckAllCheckboxes() {
      $("table tbody tr .custom-control-input").prop("checked", false);
    }

    // Call the function to uncheck all checkboxes on page load
    uncheckAllCheckboxes();
    //END

    // Handle the row click event
    $("table tbody tr").on("click", function () {
      // Find the checkbox element within the clicked row
      var checkbox = $(this).find(".custom-control-input");

     
      // Toggle the checkbox's checked state
      checkbox.prop("checked", !checkbox.prop("checked"));

      btn.classList.remove("disabled");
    });

    // Initialize DataTable.js with breadnav
    $('#example').DataTable();

    //Handle the click event of the submit button
    $("#submitBtn").on("click", function () {
      // Get the selected supervisor IDs
      //SPINNER
      var spinnerContainer = document.querySelector(".spinner-container");
      spinnerContainer.classList.remove('d-none');
      //END
      var selectedSupervisors = [];
      $("table tbody tr").each(function () {
        var checkbox = $(this).find(".custom-control-input");
        if (checkbox.prop("checked")) {
          selectedSupervisors.push($(this).find("td:eq(1)").text());
        }
      });

      //testing
      spinnerContainer.classList.add('d-none');
      alert(selectedSupervisors);return;
      //end

      var studentId = "{{$studentId}}";

      var requestData = {
        supervisors: JSON.stringify(selectedSupervisors),
        studentId: studentId
      };
      $.ajax({
        url: "{{url('dashboard/assignstudents/operation')}}",
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': '{{csrf_token()}}'
        },

        data: requestData,
        dataType: 'json',

        success: function (data) {
         
          if(data.status == "yes")
          {
            spinnerContainer.classList.remove('d-none');
            showtoast(data.message)
          
          }
          if(data.status == "no")
          {
            showtoast(data.error);
          }
       
        
          //location.reload();
         // showtoast(data.error)
      
          
          //btn.classList.remove("disabled");
          // if(data.message != "")
          //{
          // msg.innerHTML = data.message;
          // }

        },
        error: function (error) {
         // console.error("Error while sending data:", error);
        }
      });
      //end ajax
    });
  });
  */




  $(document).ready(function () {

    

    var btn = document.querySelector('.save');

    // Function to handle the "Uncheck All" functionality
    $("#checkAll").on("click", function () {
      var isChecked = $(this).prop("checked");
      $("table tbody tr .custom-control-input").prop("checked", isChecked);

    });

    //START

   // Function to update selected supervisors array
    // Handle pagination change event
    var selectedSupervisors = [];
    $('#example').on('page.dt', function () {
        updateSelectedSupervisors();
       
    });
    function updateSelectedSupervisors() {
      selectedSupervisors = [];
      
        $("table tbody tr").each(function () {
            var checkbox = $(this).find(".custom-control-input");
            if (checkbox.prop("checked")) {
                selectedSupervisors.push($(this).find("td:eq(1)").text());
                
            }
           
        });
    }
    //
    // Function to uncheck all checkboxes when the page loads
    function uncheckAllCheckboxes() {
      $("table tbody tr .custom-control-input").prop("checked", false);
    }

    // Call the function to uncheck all checkboxes on page load
    uncheckAllCheckboxes();
    

    // Handle the row click event
    $("table tbody tr").on("click", function () {
      // Find the checkbox element within the clicked row
      var checkbox = $(this).find(".custom-control-input");

     
      // Toggle the checkbox's checked state
      checkbox.prop("checked", !checkbox.prop("checked"));

      btn.classList.remove("disabled");
    });

    // Initialize DataTable.js with breadnav
    $('#example').DataTable();

    //Handle the click event of the submit button

    
      
   

    $("#submitBtn").on("click", function () {
    

      var spinnerContainer = document.querySelector(".spinner-container");
      spinnerContainer.classList.remove('d-none');
      $("table tbody tr").each(function () {
        var checkbox = $(this).find(".custom-control-input");
        if (checkbox.prop("checked")) {
          selectedSupervisors.push($(this).find("td:eq(1)").text());
        }
      });


      //start
      //alert(selectedSupervisors);
      $stuntID = "{{$studentId}}";
      $.ajax({
        url: "{{route('SelectedSupervisorsList')}}",
        method: "GET",
        headers: {
          'X-CSRF-TOKEN': '{{csrf_token()}}'
        },
        data: {selectedSupervisors:selectedSupervisors, studentID:$stuntID},
        dataType: 'json',

        success: function (data) {
         // console.log(data);

//return;
          var selectSupervisorss = document.getElementById("selectSupervisors");
          selectSupervisorss.innerHTML = "";
          data.forEach(function (supervisor) {
                var option = document.createElement("option");
                option.value = supervisor.id; // Set the value
                option.textContent = supervisor.other_names; // Set the displayed text
                selectSupervisorss.appendChild(option);
            });


          $('#exampleModal').modal('show');



          const modalFinishButton = document.getElementById("modalFinishButton");
            modalFinishButton.onclick = function () {
                // Get the selected supervisor's value
                var selectedValue = selectSupervisorss.value;
                //console.log("Selected Supervisor ID:", selectedValue);
                save(selectedValue);
                // Add your code to handle the selected value
            };






        },
        error: function (error) {
        console.log(error);
        }
      });
    spinnerContainer.classList.add('d-none');
  
     
     function save(selectedValue)   {
      //alert(selectedValue);return;
      var studentId = "{{$studentId}}";

      var requestData = {
        supervisors: JSON.stringify(selectedSupervisors),
        studentId: studentId,
        leadSupervisor: selectedValue,
      };
    
      $.ajax({
        url: "{{url('dashboard/assignstudents/operation')}}",
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': '{{csrf_token()}}'
        },

        data: requestData,
        dataType: 'json',

        success: function (data) {
          //console.log(data);

          selectedSupervisors = [];
          if(data.status == "yes")
          {
            spinnerContainer.classList.remove('d-none');
            showtoast(data.message)
          
          }
          if(data.status == "no")
          {
           showtoast(data.error);
          }
       

        },
        error: function (error) {
         // console.error("Error while sending data:", error);
        }
      });
      //end ajax
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
      },1000);

  }

    });
  });
  



</script>