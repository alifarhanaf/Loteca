@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')


<form action="{{ route('submit.round') }}" method="POST" >
    @csrf

     
      <div class="az-content-header d-block d-md-flex mg-r-40 mg-l-40 mg-t-20 " style=" padding-left:25px;padding-bottom:10px;padding-top:10px; border:1px solid  #cdd4e0 ">
        <div class="row w-100">
            <div class="col-md-10 my-auto"style=" margin-left:0px; padding-left:0px" >
          <h4 style="color: #1c273c; margin-bottom: 0px;">Enter New Round</h4>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-indigo btn-rounded btn-block">Publish</button>
            </div>
        </div>

      </div><!-- az-content-header -->
      <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">
       

        <div class="row">
            <div class="col-md-9">
                <div class="wd-xl-100p">
          
              
                    <div class="az-form-group">
                      <label class="form-label">Round Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter Round Name" >
                    </div><!-- az-form-group -->
                    {{-- <div class="az-form-group mg-t-20">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" placeholder="Enter your password" >
                      </div> --}}
                      <!-- az-form-group -->

                      
               
              </div>

              <div class="row mg-t-20">
                  <div class="col-md-6">
                    <div class="az-form-group">
                        <label class="form-label">Start Date</label>
                        

                       
                            <div class="input-group">
                              <div class="input-group-prepend">
                              </div>
                              <input name="start_date"  id="datepickerNoOfMonths" type="text" class="form-control" placeholder="MM/DD/YYYY">
                            </div>
                          



                      </div><!-- az-form-group -->
                  </div>
                  <div class="col-md-6">
                    <div class="az-form-group">
                        <label class="form-label">End Date</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                            </div>
                            <input name="end_date"  id="datepickerNoOfMonths1" type="text" class="form-control" placeholder="DD/MM/YYYY">
                          </div>
                        
                      </div><!-- az-form-group -->
                  </div>
              </div>

              <div class="az-form-group mg-t-20">
                <label class="form-label" style="font-weight: 500;  font-size:15px">Select Games</label>
                
                {{-- Start Here --}}

                <div class=" col-md-12 " style="padding-left:0px;padding-right:0px;">
                    
                    <div class="frb-group">
                        @foreach ($games as $game)
                        <div class="frb frb-primary">
                            <input type="checkbox" id="checkbox-{{$game->id}}" name="checkbox[]" value="{{$game->id}}">
                            <label for="checkbox-{{$game->id}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <span class="frb-title">Game Name</span>
                                        <br>
                                        <span class="frb-description">{{$game->name}}</span>
                                    </div>
                                    <div class="col-md-5">
                                        <span class="frb-title">Teams</span>
                                        <br>
                                        <span class="frb-description"><img src="{{ asset($game->flag_a)}}" alt="Team A" width="20" height="20"> &nbsp {{$game->team_a}} <b>VS</b> {{$game->team_b}} &nbsp <img src="{{ asset($game->flag_b)}}" alt="Team B" width="20" height="20"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="frb-title">Happening Date</span>
                                        <br>
                                        <span class="frb-description">{{ \Carbon\Carbon::parse($game->happening_date)->isoFormat('MMM Do YY')}}</span>
                                    </div>
                                </div>
                                
                            </label>
                        </div>
                            
                        @endforeach
                        
                       
                        
                       
                    </div>
                </div>



                {{-- End Here --}}
              </div><!-- az-form-group -->

              



            </div>
            <div class="col-md-3">

                <div class="wd-xl-100p" >
          
              
                    {{-- <div class="az-form-group" >
                      <label class="form-label" style="font-weight: 500; color:#1c273c; font-size:15px">Round Status</label>
                      
                      <div style="margin-top:10px;" >
                           <input type="radio" name="radio" id="radio1" checked="true" /> <label class="radio" for="radio1">Enable</label>
                      <br>
                           <input type="radio" name="radio" id="radio2" /> <label for="radio2">Disable</label> 
                      <br>
                      </div>



                    </div> --}}
                    <!-- az-form-group -->


                    <div class="az-form-group " >
                        <label class="form-label" style="font-weight: 500; color:#1c273c; font-size:15px">First Package</label>
                        <hr>
                        
                        <label class="form-label">Participation Fee</label>
                        <input name="first_package" type="text" class="form-control" placeholder="Enter Participation Fee" >
                        
                        {{-- <hr>

                        <label class="form-label">Accumulative Prize</label>
                        <input type="text" class="form-control" placeholder="Enter Accumulative Prize" > --}}
  
  
  
                      </div><!-- az-form-group -->


                      <div class="az-form-group mg-t-20" >
                        <label class="form-label" style="font-weight: 500; color:#1c273c; font-size:15px">Second Package</label>
                        
                        <hr>
                        
                        <label class="form-label">Participation Fee</label>
                        <input name="second_package" type="text" class="form-control" placeholder="Enter Participation Fee" >
                        
                        {{-- <hr>

                        <label class="form-label">Accumulative Prize</label>
                        <input type="text" class="form-control" placeholder="Enter Accumulative Prize" > --}}
  
  
  
  
                      </div><!-- az-form-group -->

                      <div class="az-form-group mg-t-20" >
                        <label class="form-label" style="font-weight: 500; color:#1c273c; font-size:15px">Third Package</label>
                        
                        <hr>
                        
                        <label class="form-label">Participation Fee</label>
                        <input name="third_package" type="text" class="form-control" placeholder="Enter Participation Fee" >
                        
                        {{-- <hr>

                        <label class="form-label">Accumulative Prize</label>
                        <input type="text" class="form-control" placeholder="Enter Accumulative Prize" > --}}
  
  
  
  
                      </div><!-- az-form-group -->
                    
               
              </div>
            </div>
        </div>
          


      </div><!-- az-content-body -->
    </form>

      @include('includes.subfooter')
      @include('includes.footer')
     
    