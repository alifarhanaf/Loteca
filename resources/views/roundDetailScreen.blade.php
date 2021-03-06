@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')



  <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">
{{-- <h1 class="text-center">Team Design Section with Pure CSS Effect</h1> --}}

<div class="az-form-group">
    <div class="row">
        <div class="col-md-1">
            <img class="rounded-circle" style="height: 70px; width:70px;" alt="100x100" src="{{ asset('/storage/Flags/round.png')}}"
          data-holder-rendered="true">
        </div>
        <div class="col-md-3" style="margin-top:10px;">
            <h5><b>{{$round->name}}</b></h5>
            {{-- <br> --}}
            <p>Lipsum Shipsum oret da sitam free</p>
            
        </div>
        <div class="col-md-8" style="margin-top:10px; text-align: right">
            <p style="margin-bottom: 0.5rem"><b>Starting Date:</b> {{$round->starting_date}}</p>
            <p><b>Ending Date:</b> {{$round->ending_date}}</p>
        </div>
    </div>
    {{-- <div class="az-img-user avatar-xl d-none d-sm-block"><img src="https://via.placeholder.com/500"  alt=""></div> --}}
    
</div>
<div class="az-form-group mg-t-20">
    <h5 style="text-align: center">Packages</h5>
</div>
<div class="az-form-group mg-t-20">
{{-- <h1>    Games   </h1> --}}
	<div class="container  mg-t-20" >
        
	<div class="row" style="width: inherit">
        
	@foreach ($round->packages as $pkgs)
    <!--team-1-->
	<div class="col-lg-4">
        <div class="our-team-main">
        
        <div class="">
        <img style="margin-bottom: 10px" src="{{ asset('/storage/Flags/money.png')}}" class="img-fluid" />
        <p>{{$pkgs->participation_fee}} Coins</p>
        <h6>First Package</h6>
        
        </div>
        
        </div>
        </div>
        <!--team-1-->
        
    @endforeach
	
	
	
	
	</div>
	</div>
</div>


@if($check == 1 )
   

{{-- Start HERE --}}
<div class="az-form-group mg-t-20">
    <h5 style="text-align: center">First Package Winners</h5>
</div>

    <div class="az-form-group mg-t-20" style="width: 100%; flex-direction: row; margin-bottom:0px;">
        <div class="row ">
     @foreach ($firstRoundWinners as $item)
         
     
      <div class="col-md-3 ">
          <div class="text-center card-box" style="margin-bottom: 0px;">
              <div class="member-card pt-2 pb-2">
                  <div class="thumb-lg member-thumb mx-auto" ><img style="width: 180px;height:180px;" src={{$item['images']['0']['url']}} class="rounded-circle img-thumbnail" alt="profile-image"></div>
                  <div class="">
                      <h4>{{$item['name']}}</h4>
                      <p class="text-muted">End User <span>| </span><span><a href="#" class="text-pink">Loteca 2.0</a></span></p>
                  </div>
                  
                  <div class="mt-3">
                      <div class="row ">
                         <div class="child" style="width: 100%">
                            <div style=" background: #fdfdfd">
                            <p style="margin-bottom:0.2rem;margin-top:0.2rem">
                               <b>Points:</b>  {{$item['winningCoins']}}
                             </p>
                            </div>
                            <div class="mt-2" style="padding-right:20px;padding-left:20px;background: #fdfdfd">
                          <p style="margin-bottom:0.2rem" class="mt-2">
                            <b>Email:</b>  {{$item['contacts']['0']['email']}}
                          </p>
                          <p>
                            <b>Phone:</b> {{$item['contacts']['0']['phone']}}
                          </p>
                            </div>
                         </div>
                         
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- end col -->
      @endforeach
      


  </div>
  <!-- end row -->
</div>

<div class="az-form-group mg-t-20">
    <h5 style="text-align: center">Second Package Winners</h5>
</div>

<div class="az-form-group mg-t-20" style="width: 100%; flex-direction: row; margin-bottom:0px;">
    <div class="row ">
 @foreach ($secondRoundWinners as $item)
     
 
  <div class="col-md-3 ">
      <div class="text-center card-box" style="margin-bottom: 0px;">
          <div class="member-card pt-2 pb-2">
              <div class="thumb-lg member-thumb mx-auto"><img style="width: 180px;height:180px;" src={{$item['images']['0']['url']}} class="rounded-circle img-thumbnail" alt="profile-image"></div>
              <div class="">
                  <h4>{{$item['name']}}</h4>
                  <p class="text-muted">End User <span>| </span><span><a href="#" class="text-pink">Loteca 2.0</a></span></p>
              </div>
              
              <div class="mt-3">
                  <div class="row ">
                     <div class="child" style="width: 100%">
                        <div style=" background: #fdfdfd">
                        <p style="margin-bottom:0.2rem;margin-top:0.2rem">
                           <b>Points:</b>  {{$item['winningCoins']}}
                         </p>
                        </div>
                        <div class="mt-2" style="padding-right:20px;padding-left:20px;background: #fdfdfd">
                      <p style="margin-bottom:0.2rem" class="mt-2">
                        <b>Email:</b>  {{$item['contacts']['0']['email']}}
                      </p>
                      <p>
                        <b>Phone:</b> {{$item['contacts']['0']['phone']}}
                      </p>
                        </div>
                     </div>
                     
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- end col -->
  @endforeach
  


</div>
<!-- end row -->
</div>

<div class="az-form-group mg-t-20">
    <h5 style="text-align: center">Third Package Winners</h5>
</div>

<div class="az-form-group mg-t-20" style="width: 100%; flex-direction: row; margin-bottom:0px;">
    <div class="row ">
 @foreach ($thirdRoundWinners as $item)
     
 
  <div class="col-md-3 ">
      <div class="text-center card-box" style="margin-bottom: 0px;">
          <div class="member-card pt-2 pb-2">
              <div class="thumb-lg member-thumb mx-auto"><img style="width: 180px;height:180px;" src={{$item['images']['0']['url']}} class="rounded-circle img-thumbnail" alt="profile-image"></div>
              <div class="">
                  <h4>{{$item['name']}}</h4>
                  <p class="text-muted">End User <span>| </span><span><a href="#" class="text-pink">Loteca 2.0</a></span></p>
              </div>
              
              <div class="mt-3">
                  <div class="row ">
                     <div class="child" style="width: 100%">
                        <div style=" background: #fdfdfd">
                        <p style="margin-bottom:0.2rem;margin-top:0.2rem">
                           <b>Points:</b>  {{$item['winningCoins']}}
                         </p>
                        </div>
                        <div class="mt-2" style="padding-right:20px;padding-left:20px;background: #fdfdfd">
                      <p style="margin-bottom:0.2rem" class="mt-2">
                        <b>Email:</b>  {{$item['contacts']['0']['email']}}
                      </p>
                      <p>
                        <b>Phone:</b> {{$item['contacts']['0']['phone']}}
                      </p>
                        </div>
                     </div>
                     
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- end col -->
  @endforeach
  


</div>
<!-- end row -->
</div>
{{-- End Here --}}

@endif

<div class="az-form-group mg-t-20">
    <h5 style="text-align: center">Games</h5>
</div>
<div class="az-form-group mg-t-20">
{{-- <h1>    Games   </h1> --}}
	<div class="container  mg-t-10" >
        
	<div class="row" style="width: inherit">
        @foreach ($round->games as $gms)
        
	<!--team-1-->
	<div class="col-lg-4">
        <div class="our-team-main">
        
        <div class="team-front">
        <img src="{{ asset('/storage/Flags/league.png')}}" class="img-fluid" />
        <h5 style="margin-bottom: 0px">{{$gms->name}}</h5>
        <p class="">{{$gms->team_a}} Vs {{$gms->team_b}}</p>
        </div>
        
        <div class="team-back">
        <span>
            <h3 class="mg-t-10" style="text-align:center">{{$gms->name}}</h3>
            <div class="row mg-t-15">
                
                <div class="col-md-5">
                   
            <img src="{{ asset($gms->flag_a)}}" class="img-fluid" style="border-radius: 0px;height:40px; width:50px; display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;" />
             <p style="text-align:center" ><b>{{ \Illuminate\Support\Str::limit($gms->team_a, 9, $end='...') }} </b>  </p>
                </div>
                <div class="col-md-2">
                    <p class="mg-t-15" >VS  </p>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset($gms->flag_b)}}" class="img-fluid" style="border-radius: 0px;height:40px; width:50px; display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;" />
                    <p style="text-align:center" ><b>{{ \Illuminate\Support\Str::limit($gms->team_b, 9, $end='...') }}</b>  </p>
            
                </div>
    
            </div>
            @if(isset($gms->results))
            <p class="mg-t-10" style="text-align: center"><b>Original Answer:</b> {{$gms->results->Answer}}</p>
            @else
            <p class="mg-t-10" style="text-align: center"><b>Original Answer:</b> N/A</p>
            @endif
            <p class="mg-t-5 mg-b-5" style="text-align: center"><b>Happening Date:</b> {{$gms->happening_date}}</p>
            
           
           
            
           
        </span>
        </div>
        
        </div>
        </div>
        <!--team-1-->
            
        @endforeach
	
	
	
	
	
	
	</div>
	</div>
</div>





  </div>



@include('includes.subfooter')
@include('includes.footer')