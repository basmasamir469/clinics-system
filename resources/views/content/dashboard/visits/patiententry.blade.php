@extends('layouts/contentNavbarLayout')
@section('title', 'Patient Entry')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ Session::get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
   @endif
   <input type="hidden" name="" id="errors" value="{{$errors}}">
   <form method="POST" action="{{ route('entry', ['id' => $appointment->id]) }}">
    @csrf
    <div class="card h-100">
        <div class="card-body">
            <h3 class="card-title mb-3">Patient Name</h3>
            <p class="card-text">{{ $appointment->patient->name ?? '' }}</p>
        </div>
        <h3 class="card-title mx-3">Services</h3>

        <ul class="list-group list-group-flush">

            @foreach ($appointment->services as $service)
                <li class="list-group-item "> {{ $service->name }} </li>
            @endforeach
        </ul>
        <div class="card-body">
            <h4 class="card-title  mt-3">Visit Results</h4>

            <textarea class="form-control" id="visit_results" name="visit_results" rows="3">{!! $appointment->visit_result !!}</textarea>

            <br>
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Lab
                Request</button>

            <h5 class="card-header">Requests</h5>
            <div class="table-responsive text-nowrap">
                <table class="table labrequest_table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Lab</th>
                            <th>services</th>
                            <th>notes</th>

                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            <th scope="row">3</th>
                            <td>Table cell</td>
                            <td>Table cell</td>
                            <td>Table cell</td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Make Request</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                        </div>
                        <div class="modal-body">


                            <div class="form-group mb-3">
                                <h4 class="card-title mb-3 mr-3">Choose Lab</h4>

                                <select class="form-select form-select-sm" name="laboratory_id" id="laboratory_id"
                                    aria-label=".form-select-sm example">
                                    <option value='' selected>Open this select menu</option>
                                    @foreach ($laboratories as $laboratory)
                                        <option value="{{ $laboratory->id }}">{{ $laboratory->name }}</option>
                                    @endforeach
                                </select>
                                @error('laboratory_id')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                            <div class="form-group mb-3">
                                <label for="exampleInputEmail1">Notes</label>
                                <input type="text" class="form-control"
                                    id="doctor_notes" name="doctor_notes">
                            </div>
                            {{-- <div class="form-group">
                  <label for="exampleInputE">Cost</label>
                  <input type="number" class="form-control" id="exampleInputE" value="" name="cost">
                </div> --}}
                <div class="form-group mb-3">
                    <label>advance payment</label>
                    <input type="text" name="advance_payment" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
                  </div>

                            <div class="form-group">
                              <label class="form-select-label mb-3"> Choose Services: </label>
                              @foreach ($services as $service)
                                  <div class="form-check mb-3">
                                      <input name="selectedservices[]"  value="{{ $service->id }}" class="form-check-input" type="checkbox">
                                      <label class="form-check-label">
                                          {{ $service->name }}
                                      </label>
                                  </div>
                              @endforeach
                              @error('services')
                              <small class="form-text text-danger">{{ $message }}</small>
                          @enderror

                                  </div>

                          


                            <a type="button" class="add-request btn btn-primary" style="    color: white;">Lab Request</a>


                        </div>
                    </div>
                </div>
            </div>
          {{-- medecines modal --}}
          <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#medicineModal"> Choose medicines</button>

        <h5 class="card-header"> Medicines</h5>
        <div class="table-responsive text-nowrap">
            <table class=" table medicine_table">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>medicine name</th>
                        <th>dosage per day</th>
                        <th>duration</th>

                    </tr>
                </thead>
                <tbody>


                    <tr>
                        <th scope="row">3</th>
                        <td>Table cell</td>
                        <td>Table cell</td>
                        <td>Table cell</td>

                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="medicineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="medicineModalLabel">Choose Medicine</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="form-group mb-3">
                            <h4 class="card-title mb-3 mr-3">Choose Medecine</h4>

                            <select class="form-select form-select-sm" name="medicine" id="medicine"
                                aria-label=".form-select-sm example">
                                <option value='' selected>Open this select menu</option>
                                @foreach ($drugs as $drug)
                                    <option value="{{ $drug->id }}">{{ $drug->name }}</option>
                                @endforeach
                            </select>
                            @error('drug_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">dosage per day</label>
                            <input type="text" class="form-control"
                                id="dosage" name="dosage">
                                @error('dosage')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleInputEmail1">duration</label>
                            <input type="number" class="form-control w-50"
                                id="duration" name="duration" placeholder="in days">
                                @error('duration')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                              </div>


                        <a type="button" class="add-medicine btn btn-primary" style="    color: white;">add medecine</a>


                    </div>
                </div>
            </div>
        </div>

                {{-- end medecines modal --}}
                <div class="form-group">
                  <div id="hiddenRequests">
                  </div>
                </div>
                <div class="row mt-3">
                    <div class="d-grid gap-2 col-lg-6 mx-auto">
                        <input type="submit" class=" make-request btn btn-primary btn-lg" name="save" value="Save">
                        <input type="submit" class=" make-request btn btn-secondary btn-lg" name="save" value="Save and Done">
                    </div>
                </div>
            </form>
        @endsection
        @section('vendor-script')
            <script type="text/javascript">
            $( document ).ready(function() {
                let errors=$('#errors').val();
                errors= JSON.parse(errors)
                console.log(errors)
                if(Object.keys(errors).length > 0 && (Object.keys(errors).includes('drug_id')||Object.keys(errors).includes('dosage')||Object.keys(errors).includes('duration'))){
                 $('#medicineModal').modal('show');
               }
               if(Object.keys(errors).length > 0 && (Object.keys(errors).includes('laboratory_id')||Object.keys(errors).includes('services'))){
                 $('#exampleModal').modal('show');
               }
               });

   $(document).on('click', '.add-request', function() {
                   let laboratory_id
                    ,laboratory_name
                    ,doctor_notes
                    ,rowCount
                    , services = []
                    ,visit_results
                    ,servicesID=[]
                    , drugs = [];




                     laboratory_id = $('#laboratory_id').val();
                     laboratory_name = $("#laboratory_id option:selected").text();
                     doctor_notes = $('#doctor_notes').val();
                     rowCount = $('.labrequest_table tr:last').index() + 1;
                    // send services
                    $("input:checkbox[name='selectedservices[]']:checked").each(function() {
                     services.push($(this).next('label').text());
                      servicesID.push($(this).val());
                    });


                    let new_tr = '<tr><td>' + rowCount + '</td><td>' + laboratory_name + '</td><td><ul>';
                      let ser=""
                      for(service of services)
                       ser +='<li>'+service+'</li>';
                       new_tr += ser +'</ul></td><td>' + doctor_notes +
                        '</td></tr>';
                    $('.labrequest_table').append(new_tr);
                    $('#exampleModal').modal('toggle');

                    $('#hiddenRequests').append('<input type="hidden" name="lapRequests[]" id="request-' + laboratory_id + '" value="' + laboratory_id + '-' + doctor_notes + '-' + servicesID + '">');

              });

            //   add medicines

              $(document).on('click', '.add-medicine', function() {
                     let medicine_id = $('#medicine ').val();
                     let medicine_name = $("#medicine option:selected").text();
                      let dosage = $("#dosage").val();
                      let duration = $('#duration').val();
                      let rowCount = $('.medicine_table tr:last').index() + 1;
                      let new_tr = '<tr id="m-'+medicine_id+'"><td>' + rowCount + '</td><td>' + medicine_name + '</td><td>' + dosage +'</td><td>' + duration +' days</td></tr>';
                      if ($('.medicine_table tbody').find('tr#m-'+medicine_id).length) 
                          {
                             console.log('medicine already exists')
                           }
                      else{
                      $('.medicine_table').append(new_tr);
                      $('#hiddenRequests').append('<input type="hidden" name="drugs[]" id="request-' + medicine_id + '" value="' + medicine_id + '-' + dosage + '-' + duration + '">');
                          }
                    $('#medicineModal').modal('toggle');

              });
             
    </script>


        @endsection
