@include('dashboard.header')
@include('dashboard.navsidebar')

<!--ASSIGNED STUDENTS-->
<div class="container-fluid mt-3 ">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <!-- /.card -->
      <div id="myCard" class="card"
        style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
        <!-- /.card-header -->
        <div class="card-body">
          <!-- Main content -->
          <section class="content">
            <div class="container   ">
              <!-- /.row -->
              <div class="row">
                <div class="col-12">

                  @if(!empty($assignedStudentData))

                  <div class="card   ">


                    <div class=" text-center text-primary h4 font-weight-bold">
                      STUDENT PROGRESS REPORT
                    </div>


               
                    <!-- /.card-header -->


                    <!--VIEW STUDENT PROGRESS REPORT MODEL Modal -->
                    <div class="modal fade" id="progressModel" tabindex="-1" aria-labelledby="approvalGuidline"
                      aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header ">
                            <div class="d-block">
                              <div class="font-weight-bold">STUDENT PROGRESS REPORT</div>
                              <div class="font-weight-bold text-primary studentNo me-3"></div>
                              <div class="font-weight-bold text-primary fileName me-3"></div>

                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <table class="table tdd">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th style="white-space:nowrap;">Current State</th>
                                  <th style="white-space:nowrap;">Acted On By</th>
                                  <th style="white-space:nowrap;">Document Status</th>
                                  
                                  <th style="white-space:nowrap;">Updated At</th>
                                  <th style="white-space:nowrap;">Reason(Remarks)</th>
                                </tr>
                              </thead>
                              <tbody id="progressTable">

                              </tbody>



                            </table>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!--END MODEL-->
                  <div class="card-body table-responsive p-1">

                    <table id="searchTable" class="table  table-striped table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>ID</th>

                          <th> Student Names</th>


                          <th>Email</th>
                          <th>Progress Report</th>

                        </tr>
                      </thead>
                      <tbody>
                      @php
                        $autoIncrementId = 1;
                        @endphp
                        @foreach($assignedStudentData as $row)
                        <tr>
                          <td>#{{$autoIncrementId}}</td>


                          <td>{{$row->student_name}}</td>


                          <td>{{$row->student_email}}</td>

                          <td class="text-primary">
                            <div type="button" onclick="viewModal('{{$row->student_id}}')"
                              data-row-id="{{$row->student_id}}" class="btn btn-light">
                              View Progress Report
                            </div>
                          </td>

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
                @else
                <div class="callout callout-info">
                  <h5 class="text-danger"><i class="fas fa-info"></i> Note:</h5>
                  No records found


                  <a href="{{'/dashboard/students'}}" class="btn btn-dark float-right btn-sm btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-backward"></i>
                    </span>
                    <span class="text">ASSIGN NEW STUDENT</span>
                  </a>
                </div>
                @endif
                <!-- /.card -->
              </div>
            </div>
          </section>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>

</div>

@include('dashboard.footer')


<script>

$(document).ready(function () {
 

    $('#searchTable').DataTable();


  });




  function viewModal(student_id) {

    getData(student_id);

  }


  function getData(student_id) {


    $.ajax({
      url: "{{ route('getProgressReport') }}",
      method: 'GET',
      data: { student_id: student_id },
      dataType: 'json',
      success: function (response) {

      
        const studentNo = document.querySelector(".studentNo")
        const fileName = document.querySelector(".fileName")
        studentNo.innerHTML = '';
        fileName.innerHTML ='';

        const tableBody = document.getElementById("progressTable"); // Replace with your actual table ID
        tableBody.innerHTML = '';

        // Loop through the array and create rows for the table
        var num = 1;
        response.forEach(item => {
          const row = document.createElement("tr");

        
          studentNo.innerHTML = item.student_number;
          fileName.innerHTML = item.file.substring(item.file.indexOf('_') + 1);

          const numCell = document.createElement("td");
          numCell.textContent = num;
          row.appendChild(numCell);

          num++;

          const levelCell = document.createElement("td");
          if (item.level_id == "1") {
            levelCell.textContent = "Student";
          }
          if (item.level_id == "2") {
            levelCell.textContent = "Supervisor";
          }
          if (item.level_id == "3") {
            levelCell.textContent = "HoD";
          }
          if (item.level_id == "4") {
            levelCell.textContent = "Dean";
          }
          if (item.level_id == "5") {
            levelCell.textContent = "Graduate";
          }
          if (item.level_id == "6") {
            levelCell.textContent = "APPROVED";
          }
          //levelCell.textContent = item.level_id;
          row.appendChild(levelCell);



          const statusCell = document.createElement("td");
          if (item.status_id == "1") {
            statusCell.textContent = "Pending";
            statusCell.classList.add("text-info");
          }
          if (item.status_id == "2") {
            statusCell.textContent = "Progress";
            statusCell.classList.add("text-primary");
          }
          if (item.status_id == "3") {
            statusCell.textContent = "Rejected";
            statusCell.classList.add("text-danger");
          }
          if (item.status_id == "4") {
            statusCell.textContent = "APPROVED";
            statusCell.classList.add("text-success");
          }

          const studentNumberCell = document.createElement("td");
          studentNumberCell.textContent = item.acted_on_by;
          row.appendChild(studentNumberCell);


          //statusCell.textContent = item.status_id;
          row.appendChild(statusCell);
          const options = {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "numeric",
            minute: "numeric",
            hour12: true
          };
          const dateCell = document.createElement("td");
          const formattedDate = new Intl.DateTimeFormat("en-US", options).format(new Date(item.date_acted_upon));
          dateCell.textContent = formattedDate;
          row.appendChild(dateCell);

          const remarksCell = document.createElement("td");
          if (item.remarks == " ") {
            remarksCell.textContent = "Approved";
          }
          if (item.remarks != "") {
            remarksCell.textContent = item.remarks;
            remarksCell.classList.add("text-danger");
          }

          row.appendChild(remarksCell);

          // Append the row to the table body
          tableBody.appendChild(row);
        });


        $('#progressModel').modal('show');


      },
      error: function (xhr, status, error) {

      }
    });
  }

  // function closeModal() {


  //   location.reload();

  // }


</script>