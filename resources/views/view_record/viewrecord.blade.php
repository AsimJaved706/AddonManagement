@extends('layouts.master')
@section('menu')
@extends('sidebar.viewrecord')
@endsection
@section('content')

<div id="main">
  <header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
      <i class="bi bi-justify fs-3"></i>
    </a>
  </header>
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Addons</h3>
          <p class="text-subtitle text-muted">Addons list</p>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add new Addon
          </button>


        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    {{-- message --}}
    {!! Toastr::message() !!}
    <section class="section">
      <div class="card">
        <div class="card-header">
          Addon list
        </div>
        <div class="card-body">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th>No</th>
                <th>Addon Name</th>
                <th>File Name</th>
                <th>comments</th>
                <th>Download</th>
                <th>status</th>
                @if(auth()->user()->role_name != 'Normal User')
                <th class="text-center">Actions</th>
                @endif

              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $item)
              <tr>
                <td class="id">
                  {{ ++$key }}
                </td>
                <td class="Addon Name">
                  {{ $item->addon_name }}
                </td>
                <td class="File Name">
                  {{ $item->file_name }}
                </td>
                <td class="Comments">
                  {{ $item->comments }}
                </td>
                <td class="Comments">
                  <button class="btn btn-secondary" onclick="downloadZip('{{ $item->file_path }}')">Download Zip</button>
                </td>
                <td class="email">
                  {{ $item->status }}
                </td>
                <td>
                @if(auth()->user()->role_name != 'Normal User')
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Updaate</button>
                  <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="updateModalLabel"></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="row g-3" action="{{ route('updateaddon',$item->id)}}" method="post">

                        <div class="modal-body">
                            @csrf
                            <div class="col-md-4">
                              <label class="card-title L1">Status</label>
                              <select class="form-control" name="status" required="">
                                <option value="Accepted" {{ $item->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Rejected" {{ $item->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                              </select>
                            </div>
                            <br>
                            <div class="col-md-4">
                              <label class="card-title L1">Comments</label>
                              <textarea name="comments" id="comments" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>

                      </div>
                    </div>
                  </div>
                  @endif

                @if((auth()->user()->role_name == 'Normal User' )&&($item->status=='Accepted'))
                <button type="button" class="btn btn-primary" onclick="extractZip('{{ $item->file_path }}')">Install</button>
                @endif

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">New Addon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="form form-horizontal" action="{{ route('addon/save') }}" method="POST" enctype="multipart/form-data">

        <div class="modal-body">
          <div class="card-content">
            <div class="card-body">
              @csrf
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <label>Addon Name</label>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group has-icon-left">
                      <div class="position-relative">
                        <input type="text" class="form-control @error('addon_name') is-invalid @enderror" value="{{ old('addon_name') }}" placeholder="Enter Addons name" id="first-name-icon" name="addon_name">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>File</label>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group has-icon-left">
                      <div class="position-relative">
                        <input type="file" class="form-control @error('addon_file') is-invalid @enderror" value="{{ old('addon_file') }}" placeholder="Enter email" id="first-name-icon" name="addon_file">
                        <div class="form-control-icon">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  function downloadZip(filepath) {
    // Create a hidden <a> element
    var link = document.createElement('a');
    link.style.display = 'none';
    document.body.appendChild(link);

    // Set the href attribute of the <a> element to the file path
    link.href = filepath;

    // Set the download attribute of the <a> element to the file name
    link.download = 'file.zip';

    // Simulate a click on the <a> element to trigger the download
    link.click();

    // Clean up
    document.body.removeChild(link);
  }



  function extractZip(zipFilePath) {
  // Send an AJAX request to your Laravel route or endpoint
  $.ajax({
    url: '/extract-zip',
    method: 'GET',
    data: {
      zipFilePath: zipFilePath
    },
    success: function(response) {
      console.log(response);
    },
    error: function(xhr, status, error) {
      console.log(error);
    }
  });
}
</script>
@endsection