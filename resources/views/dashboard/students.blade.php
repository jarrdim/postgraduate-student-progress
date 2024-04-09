@include('dashboard.header')
@include('dashboard.navsidebar')




<div class="container ">
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <!-- /.card -->
             <div class="text-center p-2">
                <h4><strong> Search Students By Student Number</strong></h4>
             </div>
              <div  data-aos="zoom-in" class="card"
                style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">


                <!-- /.card-header -->
                <div class="card-body">
                  <!-- Main content -->
                  <section class="content ContentCard">
                    <div class="container">

                      <div class="row">
                        <div class="col-md-12 ">
                          <form>
                            <div class="input-group mb-2">
                              <input id="search" name="" type="search" class="form-control form-control-lg search"
                                placeholder="Search student by student number" autofocus>
                              <div class="input-group-append">
                                <button type="button" class="btn btn-lg btn-info">
                                  <i style="font-size:0.9rem; color:orange;" class="fa fa-eye mx-2"></i><span></span>
                                </button>
                              </div>

                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </section>


                  <section class="content">
                    <div class="container text-center  ">

                      <div id="searchdata" class="row pt-2 d-none "
                        style="box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table   id="" class="table    table-striped  ">
                              
                                <th class="">Student Number</th>
                                <th class="">Student Name</th>
                                <th class="">Course</th>
                                <th class="">Prog Type</th>
                                <th  class=" ">Action</th>
                                
                              
                              <tbody   id="output">
                    
                              </tbody>
                            </table>
                          </div>
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
        @include('dashboard.footer')
        
        <script>
    var searchInput = document.querySelector("#searchdata");
    searchInput.style.display = "none";
    var search = document.querySelector("#search");
    search.value = "";

  
    $('#search').on('keyup', function () {

      $value = $(this).val().trim();

      if ($value) {
        $('#searchdata').show();

      }
      else {
        $('#searchdata').hide();

      }
      if ($value.length > 0) {
      $.ajax({
        url: "{{ route('search') }}",
        method: 'GET',
        data: { query: $value },
        dataType: 'json',
        success: function (response) {
          if (response.status === "yes") {
            var searchdata = document.querySelector("#searchdata");
            searchdata.classList.remove('d-none');
            $("#output").html(response.data);
          
            $('#search').value = "";

            
          } else {

           
          
          }
        },
        error: function (xhr, status, error) {
          // You can see the error message here
        }
      });
    }
    else {
      // If the query is empty, clear the search results section
      $("#output").empty();
    }

    });
  
  </script>


