@include('dashboard.header')
@include('dashboard.navsidebar')


<div class="container">
  <!-- /.card-header -->
  @if(!empty($rows))
  <div class="card-body table-responsive p-1">
    <table id="searchTable" class="table  table-striped table-hover text-nowrap">
      <thead>
        <tr>

          <th>Supervisor Name</th>
          <th>Date</th>

          <th>Email</th>
          <th>Phone</th>

        </tr>
      </thead>
      <tbody>
        @foreach($rows as $row)
        <tr>

          <td>{{$row->other_names}}</td>
          <td>{{ \Carbon\Carbon::parse($row->updated_at)->format('F j, Y \a\t g:i A') }}</td>

          <td>{{$row->email}}</td>
          @if(!empty($row->phone_number))
          <td>{{$row->phone_number}}</td>
          @else
          <td class="text-danger">N/A</td>
          @endif
          <!-- href="{{url('/')}}/dashboard/viewassigned/delete/{{$row->id}}"-->


        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  <!-- /.card-body -->

  <div class="card mb-5">
    <a href="{{url('/')}}/student/upload" class="btn btn-success">UPLOAD DOCUMENT</a>
  </div>
</div>

@else


<div class="card m-2">
  <div class="callout callout-info p-2">
    <h5 class="text-danger"><i class="fas fa-info"></i> Note:</h5>
    No records found
 

    </div>
</div>

@endif



@include('dashboard.footer')