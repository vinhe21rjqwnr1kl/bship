{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

    @if(!empty(request()->title) || !empty(request()->category) || !empty(request()->user) || !empty(request()->status) || !empty(request()->from) || !empty(request()->to) || !empty(request()->tag) || !empty(request()->visibility) || !empty(request()->publish_on))
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

	<!-- row -->
	<!-- Row starts -->
  <style>
       #map {
        height: 400px;
        width: 100%;
       }
    </style>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijSIYaj9ENNzxiMfD8OEzpAIVlPhWGz4&callback=initMap&libraries=places,drawing,geometry&entry=ttu"></script>
	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
          <table class="table table-responsive-lg mb-0" >

            <tr>
                <form id="myTargetForm" method="GET">
                  <td>Số điện thoại TX:
                  <input type="text" id="sdt" name="sdt" value="{{$sdt_tx}}"> &nbsp;&nbsp;&nbsp;<input type="submit" value="Tìm"></td>
                </form> 
              </tr>
      </table>
						<table class="table table-responsive-lg mb-0" >
            
              
        
           
							  <tbody>
									<div class="panel-body"> 
									<div >
								  <div id="map" ></div>
										</div>
										
										<!-- /.table-responsive -->
						
									</div>

							</tbody>
      
						</table>
					</div>
				</div>
			
			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
    var locations = [
      {!!$string!!}
    ];

    var num =1;

    var sdt_tx_tim ={!!$sdt_tx!!} ;
    if(sdt_tx_tim !=1)
    {
        for (i = 0; i < locations.length; i++) {  

          //alert(locations[i][3]+'--'+sdt_tx_tim);
            if(locations[i][3]==sdt_tx_tim)
            {
                var num =2;
                var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 15,
                  center: new google.maps.LatLng(locations[i][1], locations[i][2])
                });
            }
        }
    }
    if(num==1)
    {
      var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: new google.maps.LatLng({{$latitude_quan}}, {{$longitude_quan}})
       });
    }


    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          var contentString = 'Tài xế : ' +locations[i][0];
          infowindow.setContent(contentString);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }


  </script>
@endsection