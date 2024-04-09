@include('dashboard.header')
@include('dashboard.navsidebar')

<div class="container-fluid  mb-0 ">

  <!-- Content Row -->
  <div class="row mt-5">

    <!-- ASSIGNED SUPERVISORS COUNT -->
    <div class="col-xl-3 nav-tab col-md-6 mb-4 " onclick="viewAssignedSupervisor()">
      <div class="nav-link" href="{{url('/')}}/dashboard/assignedSupervisorsList">
        <div class="card border-left-success  tab-1 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-success h5 text-uppercase mb-1">
                  VIEW ASSIGNED SUPERVISORS</div>

              </div>
              <div class="col-auto me-2">
                <i class="fa fa-users"></i>
              </div>
            </div>
            <div class="font-weight-bold text-center">{{$numberAssignedSuperisors}} </div>
          </div>
        </div>
      </div>
    </div>
    <!--NO OF REMAINING(UNASSIGNED) SUPERVISORS-->
    <div class="col-xl-3 nav-tab col-md-6 mb-4 " onclick="viewUnassignedSupervisor()">
      <div class="nav-link" >
        <div class="card border-left-dark tab-2 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2 text-center">
                <div class="text-xs font-weight-bold text-dark h5 text-uppercase mb-1">
                  VIEW UNASSIGNED SUPERVISORS</div>

              </div>
              <div class="col-auto me-2">
                <i class="fa fa-users"></i>
              </div>
            </div>
            <div class="font-weight-bold text-center">{{$remainingSupervisors}} </div>
          </div>
        </div>
      </div>
    </div>



    <!-- ASSIGNED STUDENTS -->
    <div class="col-xl-3 nav-tab col-md-6   " onclick="viewassignedStudents()">
      <div class="nav-link">
        <div class="card border-left-warning tab-3 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs h5 font-weight-bold text-warning text-uppercase mb-1 text-center">
                  view assigned <br> students</div>

              </div>
              <div class="col-auto me-2">
                <i class="fa fa-users"></i>
              </div>
            </div>

            <div class="font-weight-bold text-center">{{$numberAssignedStudents}} </div>
          </div>
        </div>
      </div>
    </div>

    <!--VIEW UNASSIGNED STUDENTS--->
    <div class="col-xl-3 nav-tab col-md-6 mb-4 " onclick="viewUnassignedStudent()">
      <div class="nav-link">
        <div class="card border-left-danger tab-4 shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs h5 font-weight-bold text-danger text-uppercase mb-1 text-center">
                  view unassigned students</div>

              </div>
              <div class="col-auto me-2">
                <i class="fa fa-users"></i>
              </div>
            </div>

            <div class="font-weight-bold text-center">{{$notAssignedStudents}} </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<!---VIEW ASSIGNED SUPERVISORS---->
<div class="container-fluid d-none" id="assignedSupervisor">
  <div class="container  p-0  ">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <!-- /.card -->
        <div id="myCard" class="card"
          style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Main content -->
            <section class="content">

              <!-- /.row -->
              <div class="row">
                <div class="col-12">

                  @if(!empty($AssignedSuperisors))

                  <div class="text-center font-weight-bold text-success">
                    LIST OF ASSIGNED SUPERVISORS
                  </div>



                  <div class="card-tools">
                    <div class="input-group input-group-sm ml-auto tableSearch" style="width: 150px;">
                      <!-- Search input -->
                      <input type="text" name="table_search" class="form-control" placeholder="Search">
                      <!-- Search button -->
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body table-responsive p-1">
                  <table id="searchTable" class="table  table-hover text-nowrap">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Supervisor Name</th>
                        <th>Date</th>
                        <th class="">Assigned Students Reg.No</th>
                        <th>Student Email</th>
                        <th>Student Name</th>


                      </tr>
                    </thead>
                    <tbody>
                    @php
                      $autoIncrementId = 1;
                      @endphp
                      @foreach($AssignedSuperisors as $supervisor)
                      <tr>
                        
                        <td>
                        
                      <tr id="tr">
                      

                        <td class="font-weight-bold" rowspan="{{ count($supervisor['assigned_students']) + 1 }}">
                         #{{$autoIncrementId}}</td>
                        <td class="font-weight-bold" rowspan="{{ count($supervisor['assigned_students']) + 1 }}">{{
                          $supervisor['supervisor_name'] }}</td>
                        <td class="font-weight-bold" rowspan="{{ count($supervisor['assigned_students']) + 1 }}">{{
                          $supervisor['updated_at'] }}</td>
                      </tr>
                      </td>

                      @foreach ($supervisor['assigned_students'] as $student)

                      <tr>


                        <td>{{ $student->student_number }}</td>

                        @if(!empty($student->primary_email))
                        <td>{{ $student->primary_email }}</td>
                        @else
                        <td class="text-danger">N\A</td>
                        @endif

                        <td>{{ $student->other_names }}</td>
                        <!-- Add other student details here -->
                      </tr>
                      @endforeach

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
                <a href="{{url('/')}}/dashboard/students/operation/{{$studentId}}"
                  class="btn float-right btn-info btn-sm btn-icon-split me-1">
                  <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                  </span>
                  <span class="text">ASSIGN SUPERVISOR TO STUDENTS</span>
                </a>

              </div>
              @endif
              <!-- /.card -->
          </div>


          </section>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
</div>
<!--END-->



<!---UNASSIGNED SUPERVISORS-->
<div class="container-fluid d-none " id="unassignedSupervisor">
  <!-- Page Heading -->
  <div class="row ">
    <div class="col-md-12 col-sm-12">
      <!-- /.card -->
      <div data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0" class="card"
        style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
        <!-- /.card-header -->
        <div class="card-body">
          <!-- MAIN CONTENT -->
          <!-- /.row -->
          <div class="row gy-1">


            @if(!empty($unassignedSupervisorData))

            <div class="col-md-12 text-end  ">
              <div class="font-weight-bold h5  text-center ">
                UNASSIGNED SUPERVISORS
              </div>
              <a href="{{'/dashboard/students'}}" class="btn btn-dark btn-sm btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-backward"></i>
                </span>
                <span class="text">ASSIGN NEW STUDENT</span>
              </a>
            </div>
            <div class="col-12 p-2  ">
              <!-- /.card-header -->
              <div>

                <div class="table-responsive">
                  <table id="example" class="table  table-hover text-nowrap table-striped">
                    <thead>
                      <tr style="font-size:0.9rem !important;">

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
                    @php
                      $autoIncrementId = 1;
                      @endphp
                      @foreach($unassignedSupervisorData as $row )
                      <tr>

                        <td>#{{$autoIncrementId}}</td>
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
                      @php
                      $autoIncrementId++;
                      @endphp
                      @endforeach

                    </tbody>
                  </table>
                </div>
              </div>

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

<!--ASSIGNED STUDENTS-->
<div class="container-fluid d-none  " id="assignedStudents">
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


                    <div class=" text-center text-warning font-weight-bold">
                      LIST OF ASSIGNED STUDENTS
                    </div>


                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-1">

                      <table id="searchTable3" class="table  table-striped table-hover text-nowrap">
                        <thead>
                          <tr>
                            <th>ID</th>

                            <th> Student Names</th>
                            <th>Date</th>

                            <th>Email</th>
                            <th>Status</th>

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
                            <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}</td>

                            <td>{{$row->student_email}}</td>

                            <td class="text-primary">
                              Assigned
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




<!--UNASSIGNED STUDENTS--->

<div class="container-fluid   d-none" id="unassignedStudents">
  <div class="row ">
    <div class="col-md-12 col-sm-12">
      <!-- /.card -->
      <div class="card"
        style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
        <!-- /.card-header -->

        <div class="card-body">
          <!-- MAIN CONTENT -->
          <!-- /.row -->
          <div class="row ">

            @if(!empty($unassignedStudentData))
              <div class="card">
            <div class="col-md-12 text-end  ">

              <div class="font-weight-bold h5  text-danger text-center ">
                UNASSIGNED STUDENTS
              </div>
            </div>
            <div class="col-12 p-2  ">
              <!-- /.card-header -->
              
                <div class=" card-body table-responsive">
                  <table id="example2" class="table  table-hover table-striped">
                    <thead>
                      <tr style="font-size:0.9rem !important;">
                        <th>#Id</th>
                        <th style="lwidth: 20px;">Other Names</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Reg.NO</th>
                        <th>Program Name</th>
                        <th>Category Name</th>
                      </tr>
                    </thead>
                    <tbody>
                    @php
                    $autoIncrementId = 1;
                    @endphp
                      @foreach($unassignedStudentData as $row )
                      <tr>
                        <td>#{{ $autoIncrementId}}</td>
                        <td style="widthk: 20px;">{{$row->other_names}}</td>
                        @if(!empty($row->primary_phone_no))
                        <td class="">+{{$row->primary_phone_no}}</td>
                        @else
                        <td class="text-danger">N/A</td>
                        @endif
                        <td>{{$row->primary_email}}</td>
                        <td>{{$row->primary_phone_no}}</td>
                        <td>{{$row->prog_full_name}}</td>
                        <td>{{$row->std_category_name}}</td>
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
@include('dashboard.footer')

<script>

  $(document).ready(function () {

    // Event listener for the search input
    $('input[name="table_search"]').on('keyup', function () {
      var value = $(this).val().toLowerCase();
      $("#searchTable tbody #tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    // Initialize DataTable.js with breadnav

    $('#example').DataTable();
    $('#example2').DataTable();
    $('#searchTable3').DataTable();




  });


  var tab1 = document.querySelector(".tab-1");
  tab1.classList.add("border-bottom-primary");
  var tab2 = document.querySelector(".tab-2");
  var tab3 = document.querySelector(".tab-3");
  var tab4 = document.querySelector(".tab-4");


  var assignedSupervisor = document.querySelector("#assignedSupervisor");
  assignedSupervisor.classList.remove('d-none');
  function viewAssignedSupervisor() {


    tab1.classList.add("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");
    tab4.classList.remove("border-bottom-primary");

    var unassignedSupervisor = document.querySelector("#unassignedSupervisor");
    unassignedSupervisor.classList.add('d-none');
    var assignedSupervisor = document.querySelector("#assignedSupervisor");
    assignedSupervisor.classList.remove('d-none');
    var assignedStudents = document.querySelector("#assignedStudents");
    assignedStudents.classList.add('d-none');
    var unassignedStudents = document.querySelector("#unassignedStudents");
    unassignedStudents.classList.add('d-none');
  }
  function viewUnassignedSupervisor() {

    tab1.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");
    tab4.classList.remove("border-bottom-primary");
    tab2.classList.add("border-bottom-primary");

    var unassignedSupervisor = document.querySelector("#unassignedSupervisor");
    unassignedSupervisor.classList.remove('d-none');
    var assignedSupervisor = document.querySelector("#assignedSupervisor");
    assignedSupervisor.classList.add('d-none');
    var assignedStudents = document.querySelector("#assignedStudents");
    assignedStudents.classList.add('d-none');

    var unassignedStudents = document.querySelector("#unassignedStudents");
    unassignedStudents.classList.add('d-none');
  }
  function viewassignedStudents() {

    tab3.classList.add("border-bottom-primary");
    tab1.classList.remove("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab4.classList.remove("border-bottom-primary");

    var assignedSupervisor = document.querySelector("#assignedSupervisor");
    assignedSupervisor.classList.add('d-none');
    var unassignedSupervisor = document.querySelector("#unassignedSupervisor");
    unassignedSupervisor.classList.add('d-none');
    var assignedStudents = document.querySelector("#assignedStudents");
    assignedStudents.classList.remove('d-none');

    var unassignedStudents = document.querySelector("#unassignedStudents");
    unassignedStudents.classList.add('d-none');
  }
  function viewUnassignedStudent() {
    tab4.classList.add("border-bottom-primary");
    tab1.classList.remove("border-bottom-primary");
    tab2.classList.remove("border-bottom-primary");
    tab3.classList.remove("border-bottom-primary");

    var unassignedStudents = document.querySelector("#unassignedStudents");
    unassignedStudents.classList.remove('d-none');
    var assignedStudents = document.querySelector("#assignedStudents");
    assignedStudents.classList.add('d-none');
    var unassignedSupervisor = document.querySelector("#unassignedSupervisor");
    unassignedSupervisor.classList.add('d-none');
    var assignedSupervisor = document.querySelector("#assignedSupervisor");
    assignedSupervisor.classList.add('d-none');
  }


  /*
    $(document).ready(function () {
      // Event listener for the search input
      $('input[name="table_search"]').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $("#searchTable tbody tr").filter(function () {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
  
    });*/

</script>