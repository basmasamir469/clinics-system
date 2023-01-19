@extends('layouts.contentNavbarLayout')

@section('title', 'medicines Reports')
@section('content')
    <div class="card">
        <h3 class="card-header">Medicine Report</h3>


        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
            </div>
            <div class="card-body">
                <form wtx-context="E45C1219-FD11-4F9E-8306-7EA6CF6EA845" action="{{route('medicine_search')}}">
                    <div class="mb-3 row">
                        <label for="defaultSelect" class=" col-md-1 col-form-label"> medicines:</label>
                        <div class="col-md-4">
                            <select id="medicine"  name="medicine_id" class="form-select">
                                <option value="">choose medicine</option>
                              @foreach ($drugs as $drug )
                              <option value="{{$drug->id}}" @selected(old('medicine_id') == $drug->id)>{{$drug->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                     <div class="mb-3 row">
                      <label for="html5-date-input" class="col-md-1 col-form-label"> From :</label>
                      <div class="col-md-4">
                          {{-- <input class="form-control" type="date" name="from" value="" id="html5-date-input"> --}}
                          <input name = "from" type="date" class = "form-control datepicker valid_to" placeholder = "Valid To" data-date-start-date="d" value = "{{date('Y-m-d', strtotime('now'))}}">

                      </div>
                      <label for="html5-date-input" class="col-md-1 col-form-label"> To :</label>
                      <div class="col-md-4">
                          {{-- <input class="form-control" type="date" name="to" value="" id="html5-date-input"> --}}
                          <input name = "to" type="date" class = "form-control datepicker valid_to" placeholder = "Valid To" data-date-start-date="d" value = "{{date('Y-m-d', strtotime('now'))}}">
                      </div>
                  </div> 
                  <div class="row justify-content-end">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary search">Search</button>
                    </div>
                  </div>                </form>
            </div>
        </div>


        <div class="table-responsive text-nowrap">

            <h5 class="card-header">Appointment Report Table</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-dark table-bordered">
                    <thead>
                        <tr>

                            <th>NO</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Medicine</th>
                            <th>Concentration</th>
                            <th>duration</th>
                            <th>dosage</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                          @if($appointments && $appointments->count()>0)
                        @foreach ($appointments as $appointment)
                        <tr>
                            <input type="hidden" id="count" value="{{$appointments->count()}}">
                            <td>{{$appointment->id}}</td>
                          <td>{{$appointment->patient->name}}</td>
                          <td>{{$appointment->appointment_date}}</td>
                          <td> 
                            @foreach($appointment->drugs as $drug )
                            {{$drug->name}} <hr>
                            @endforeach
                          </td>
                            <td> 
                                @foreach($appointment->drugs as $drug )
                                {{$drug->concentration}} <hr>
                                @endforeach
                              </td>
                                <td>
                                     @foreach($appointment->drugs as $drug )
                                    {{$drug->pivot->duration}} <hr>
                                    @endforeach</td>
                                    <td> 
                                        @foreach($appointment->drugs as $drug )
                                        {{$drug->pivot->dosage}} <hr>
                                        @endforeach</td>
                                      {{-- @endforeach --}}
                        </tr>
                      @endforeach
                    @endif

                    </tbody>
                </table>
                
                <div class="card-body links">
                    <h5 align='left'>Total uses: <span id='total_records'>{{$appointments->count()}}</span></h5>
                  </div>
                
            </div>
        </div>





    </div>


@endsection

{{-- @section('vendor-script')
<script type="text/javascript">
let selectedval
let count=$("#count").val()
    $('#medicine').on('change',function(){
    selectedVal = $(this).val();
});
$(document).on('click', '.search', function() {
    $('.links').append("<h5 align='left'>Total uses: <span id='total_records'>"+count+"</span></h5>")
});
</script>
@endsection --}}
