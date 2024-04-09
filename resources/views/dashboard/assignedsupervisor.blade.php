@include('dashboard.header')
@include('dashboard.navsidebar')
<!-- LOADER AND TOAST -->
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

<!-- Begin Page Content -->
<div class="container-fluid">

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
              <div class="container   ">
                <!-- /.row -->
                <div class="row">
                  <div class="col-12">

                    @if(!empty($rows))

                    <div class="card   ">
                      <div class="card-header text-center">
                        <h3 class="card-title ">


                          @if(!empty($studentNumber) && !empty($studentId))
                          <div class="btn">SUPERVISORS ASSIGNED TO <strong>{{$studentNumber}}</strong></div>
                          <div class="btn"> <strong>{{$studentName}}</strong></div>



                          <a href="{{'/dashboard/students'}}" class="btn btn-dark btn-sm btn-icon-split float-right">
                            <span class="icon text-white-50">
                              <i class="fas fa-backward"></i>
                            </span>
                            <span class="text">ASSIGN NEW STUDENT</span>
                          </a>
                          <a href="{{url('/')}}/dashboard/students/operation/{{$studentId}}"
                            class="btn btn-info btn-sm btn-icon-split  float-right me-2 ">
                            <span class="icon text-white-50">
                              <i class="fas fa-plus-circle"></i>
                            </span>
                            <span class="text">ASSIGN NEW SUPERVISOR</span>
                          </a>
                          @else

                          <div class="btn btn-primary">N/A</div>
                          @endif

                        </h3>

                    
                      </div>


                      <!-- /.card-header -->
                      <div class="card-body table-responsive p-1">
                        <table id="searchTable" class="table  table-striped table-hover text-nowrap">
                          <thead>
                            <tr>
                             
                              <th>Payroll Number</th>
                              <th>Name</th>
                              <th>Date</th>

                              <th>Email</th>
                              <th>Level Assigned</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($rows as $row)

                            <tr>
                              
                              <td>{{$row->payroll_number}}</td>
                              <td>{{$row->other_names}}</td>
                              <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}</td>

                              <td>{{$row->email}}</td>

                              <td>
                                @if($row->level_id == 1)
                                <div class="text-primary">Lead Supervisor</div>
                                @endif
                              </td>
                              <td>
                                <button type="button" class="btn btn-danger" data-row-id="{{$row->id}}"
                                  data-bs-toggle="modal" data-bs-target="#exampleModal">
                                  Remove
                                </button>
                              </td>

                            </tr>
                            @endforeach

                          </tbody>


                          <!--Remove MODEL -->

                          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">

                                  <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="alert msg text-center alert-danger">Are you sure you want to delete?</div>
                                  <textarea placeholder="Remarks" class="w-100" id="w3review" name="remarks" rows="4"
                                    cols="50"></textarea>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <div id="modalFinishButton" class="btn btn-primary">Finish</div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <!--END MODEL-->
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    @else
                    <div class="callout callout-info">
                      <h5 class="text-danger"><i class="fas fa-info"></i> Note:</h5>
                      No records found
                      @if(!empty($studentId))

                      <a href="{{'/dashboard/students'}}" class="btn btn-dark float-right btn-sm btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fas fa-backward"></i>
                        </span>
                        <span class="text">ASSIGN NEW STUDENT</span>
                      </a>

                      <a href="{{url('/')}}/dashboard/students/operation/{{$studentId}}"
                        class="btn float-right btn-info btn-sm btn-icon-split me-1">
                        <span class="icon text-white-50">
                          <i class="fas fa-flag"></i>
                        </span>
                        <span class="text">ASSIGN SUPERVISOR TO {{$studentNumber}}</span>
                      </a>
                      @else
                      <a href="{{'/dashboard/students'}}" class="btn btn-dark btn-sm btn-icon-split me-2">
                        <span class="icon text-white-50">
                          <i class="fas fa-backward"></i>
                        </span>
                        <span class="text">ASSIGN NEW STUDENT</span>
                      </a>
                      @endif


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
    <!-- /.row -->
  </div>





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


@include('dashboard.footer')

<script>




  $(document).ready(function () {
    // Event listener for the search input
    // $('input[name="table_search"]').on('keyup', function () {
    //   var value = $(this).val().toLowerCase();
    //   $("#searchTable tbody tr").filter(function () {
    //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    //   });
    // });

    $('#searchTable').DataTable();


  });


  let currentRowId;

  document.addEventListener("click", function (event) {
    const clickedElement = event.target;
    if (clickedElement && clickedElement.dataset.rowId) {
      currentRowId = clickedElement.dataset.rowId;
      const modalFinishButton = document.getElementById("modalFinishButton");
      modalFinishButton.onclick = function () {
        deleteRow(currentRowId);
      };
    }
  });

  function deleteRow(id) {

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

    var cardElement = document.getElementById('myCard');

    cardElement.removeAttribute('data-aos');


    $.ajax({
      url: "{{ route('delete') }}",
      method: 'GET',
      data: { id: id, remarks: remarksmsg },
      dataType: 'json',
      success: function (response) {
        if (response.success) {

          showtoast(response.message)

        } if (response.errorMSG) {

          spinnerContainer.classList.add('d-none');
          msg.innerHTML = response.errorMSG;
        }
      },
      error: function (xhr, status, error) {
        //console.log(xhr.responseText); // You can see the error message here
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
    }, 1000);

  }

</script>