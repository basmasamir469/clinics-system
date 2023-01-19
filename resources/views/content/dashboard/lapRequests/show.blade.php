@extends('layouts/contentNavbarLayout')
@section('title', 'Lab Request Details')
@section('vendor-style')
<style>
  /* Style the Image Used to Trigger the Modal */
#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  padding-left: 200px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}

</style>
@endsection
@section('content')
<div class="card" style="width: 100%">
    <div class="card-body">
      <h3 class="card-title mb-3">Lab Name</h3>
      <p class="card-text">{{$request->laboratory->name}}</p>
   </div>

<div class="card" style="width: 100%">
    <div class="card-body">
      <h3 class="card-title mb-3">Patient Name</h3>
      <p class="card-text">{{$request->appointment->patient->name}}</p>
   </div>
   <div class="card" style="width: 100%">
    <div class="card-body">
      <h3 class="card-title mb-3">Request Date</h3>
      <p class="card-text">{{$request->request_date}}</p>
   </div>
   <hr>
   <h3 class="card-title mx-3">Services</h3>

   <ul class="list-group list-group-flush">
    @if($request->services && $request->services->count()>0 )
           @foreach ($request->services as $service )
     <li class="list-group-item "> {{$service->name}} &nbsp; <span>{{$service->cost}} LE</span></li>
            @endforeach
            @else
            <li class="list-group-item ">no services</li>
         @endif
        </ul>
        <hr>
    <div class="card-body">
        <h4 class="card-title mb-3">Lab Email</h4>
         <p class="card-text">{{$request->laboratory->email}}</p>
         <br>
   </div>
   <h4 class="card-title mx-3">Lab Results</h4>
   <div class="card-body">
     @if($request->labresults_text || $request->labresults_files)
     {{-- <img class="card-img-top mb-3" style="width:400px; height:400px"
      src="{{url('images/labresults/'.$request->labresults_files)}}"
      alt="Card image cap"> --}}
     <!-- Trigger the Modal -->
   <img id="myImg"src="{{url('images/labresults/'.$request->labresults_files)}}"  style="width:100%;max-width:300px">

  <!-- The Modal -->
  <div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>
    
     <p class="card-text">{{$request->labresults_text}}</p>
     {{-- @elseif($request->status==='completed' && !$request->lab_results)
      <a class="btn btn-secondary" href="{{url('labresults/'.$request->id)}}">Add results</a> --}}
      @else
      <p class="card-text">no results</p>
     @endif
   </div>

  </div>
  @endsection
  @section('vendor-script')
  <script type="text/javascript">
  var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
Ti
  </script>
  @endsection