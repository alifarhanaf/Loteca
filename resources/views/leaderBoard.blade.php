@include('includes.header')
<link href="{{ asset('css/leaderB.css') }}" rel="stylesheet">
@include('includes.sidebar')
@include('includes.subheader')


  <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


    <div class="az-content-label mg-b-5">Games DataTable</div>
    {{-- <p>{{$leaderBoardMonthly}}</p> --}}
    {{-- {!! dd($leaderBoardMonthly[0]) !!} --}}
          <p class="mg-b-20">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>

          {{-- //Start --}}
          <div class="content">
            <div class="container">
              
               
                <div class="row">
                   @foreach ($leaderBoardMonthly as $item)
                       
                   
                    <div class="col-md-4">
                        <div class="text-center card-box">
                            <div class="member-card pt-2 pb-2">
                                <div class="thumb-lg member-thumb mx-auto"><img src={{$item['images']['0']['url']}} class="rounded-circle img-thumbnail" alt="profile-image"></div>
                                <div class="">
                                    <h4>{{$item['name']}}</h4>
                                    <p class="text-muted">End User <span>| </span><span><a href="#" class="text-pink">Loteca 2.0</a></span></p>
                                </div>
                                {{-- <p>Helo</p> --}}
                                
                                {{-- <button type="button" class="btn btn-primary mt-3 btn-rounded waves-effect w-md waves-light">Message Now</button> --}}
                                <div class="mt-3">
                                    <div class="row ">
                                       <div class="child">
                                          <div style=" background: #fdfdfd">
                                          <p style="margin-bottom:0.2rem;margin-top:0.2rem">
                                             <b>Points:</b>  {{$item['winning_coins']}}
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
            <!-- container -->
        </div>
          






      {{-- End --}}
    </div><!-- az-content-body -->




@include('includes.subfooter')
@include('includes.footer')
<script>
    @if(Session::has('success'))
   // console.log('Hi');
   toastr.success("{{ Session::get('success') }}") ;
@endif
@if(Session::has('error'))
   // console.log('Hi');
   toastr.error("{{ Session::get('error') }}") ;
@endif
 </script>