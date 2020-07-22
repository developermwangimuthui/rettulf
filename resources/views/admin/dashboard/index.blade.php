@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
  <div class="container-fluid">


    <div class="row mt-3">
      <div class="col-12 col-lg-6 col-xl-3">
        <div class="card border-info border-left-sm">
          <a >
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body text-left">
                <h4 class="text-info mb-0">{{$totalMusic}}</h4>
                  <span>Total Music</span>
                </div>
                <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-music-tone text-white"></i></div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-3">
        <div class="card border-danger border-left-sm">
          <a>
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body text-left">
                <h4 class="text-danger mb-0">{{$artists}}</h4>
                  <span>Total Artist</span>
                </div>
                <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-people text-white"></i></div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-3">
        <div class="card border-success border-left-sm">
          <a>
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body text-left">
                <h4 class="text-success mb-0">{{$producers}}</h4>
                  <span>Total Producers</span>
                </div>
                <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-user text-white"></i></div>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-12 col-lg-6 col-xl-3">
        <div class="card border-warning border-left-sm">
          <a >
            <div class="card-body">
              <div class="media align-items-center">
                <div class="media-body text-left">
                <h4 class="text-warning mb-0">{{$total_sales}}</h4>
                  <span>Total Sales</span>
                </div>
                <div class="align-self-center w-circle-icon rounded-circle gradient-blooker">
                  <i class="fa fa-money text-white"></i></div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <!--End Row-->

    
   
    <div class="row">

      <div class="col-lg-12">
          <div class="card">

              <div class="card-header">
                  <i class="fa fa-table"></i> Latest Added Music
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                      <table id="music_table" class="table table-bordered ">
                          <thead>

                                  <th>Producer/Artist Name</th>
                                  <th>Album Photo</th>

                                  <th>Price</th>
                                  <th>Plays</th>
                                  <th>Downloads</th>
                                  <th>Type</th>

                                  <th> Payment Status</th>
                                  <th> Status</th>

                          </thead>
                           <tbody>

                          </tbody>
                          <tfoot>
                                  <th>Producer/Artist Name</th>
                                  <th>Album Photo</th>
                                  <th>Price</th>
                                  <th>Plays</th>
                                  <th>Downloads</th>
                                  <th>Type</th>
                                  <th> Payment Status</th>
                                  <th> Status</th>
                          </tfoot>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div><!-- End Row-->
    <!--End Row-->

 
    <!--End Row-->




    <!--End Dashboard Content-->
    <!--start overlay-->
    <div class="overlay toggle-menu"></div>
    <!--end overlay-->
  </div>
  <!-- End container-fluid-->

</div>
<!--End content-wrapper-->

<script>

var table = $('#music_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('adminMusic.index')}}",
        columns:[

        {data: 'user.name', name: 'user.name'},
        {data:'cover_art',name:'cover_art',
                      render: function(data, type, full, meta){
                      return "<img src={{ URL::to('') }}/uploadedCoverArts/"+data+ " width='70' class='img-thumbnail' />" ; },orderable: false},   
                      
        {data: 'price', name: 'price'},
        {data: 'views', name: 'views'},
        {data: 'downloads', name: 'downloads'},
        {data: 'type', name: 'type'},
        {data: 'is_paid', name: 'is_paid', orderable: true, searchable: false},
        {data: 'status', name: 'status', orderable: true, searchable: false},
        ],


        });





  function New(music_id) {
       var status = '0';
    $.ajax({
           url:'/music/change/status',
           method:'put',
           data:{
            music_id:music_id,
            status:status,
            _token: "{{ csrf_token() }}"
           },
           success:function(data){
            if (data.errors) {
                    Lobibox.notify("error", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.message,
                    });
                }
                if (data.success) {
                    Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-check-circle", //path to image
                        msg: data.message,
                     });

                }
             $('#music_table').DataTable().ajax.reload();
           },
           error:function(data){
             $('#music_table').DataTable().ajax.reload();
           }

       });
    }
    function closeAudio() {
        $('#link_view').attr('src', '');

        
    }

   function Published(music_id) {
       var status = '1';
    $.ajax({
           url:'/music/change/status',
           method:'put',
           data:{
            music_id:music_id,
            status:status,
            _token: "{{ csrf_token() }}"
           },
           success:function(data){
            if (data.errors) {
                    Lobibox.notify("error", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.message,
                    });
                }
                if (data.success) {
                    Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-check-circle", //path to image
                        msg: data.message,
                     });

                }
             $('#music_table').DataTable().ajax.reload();
           },
           error:function(data){
             $('#music_table').DataTable().ajax.reload();
           }

       });
    }








</script>

@endsection