@include('includes.header')
<link href="{{ asset('css/leaderB.css') }}" rel="stylesheet">
@include('includes.sidebar')
@include('includes.subheader')


  <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">
    <div class="row text-center">
    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
    <div class="az-content-label " style="margin-bottom:0px">All Time LeaderBoard</div>
    </div>
    </div>
    {{-- <p>{{$leaderBoardMonthly}}</p> --}}
    {{-- {!! dd($leaderBoardMonthly[0]) !!} --}}
          {{-- <p class="mg-b-20">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p> --}}

          {{-- //Start --}}
          <div class="content">
            {{-- <div class="container"> --}}
              
               
                <div class="row ">
                  <div class="card user-card-full" style="width: 100%; flex-direction: row; margin-bottom:0px;">
                   @foreach ($leaderBoardAllTime as $item)
                       
                   
                    <div class="col-md-4 ">
                        <div class="text-center card-box" style="margin-bottom: 0px;">
                            <div class="member-card pt-2 pb-2">
                                <div class="thumb-lg member-thumb mx-auto"><img src={{$item['images']['0']['url']}} class="rounded-circle img-thumbnail" alt="profile-image"></div>
                                <div class="">
                                    <h4>{{$item['name']}}</h4>
                                    <p class="text-muted">End User <span>| </span><span><a href="#" class="text-pink">Loteca 2.0</a></span></p>
                                </div>
                                
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
            <br>

            <div class="row">
            {{-- Start Here --}}
            <div class="card user-card-full" style="width: 100%;flex-direction: row">
              <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


                  {{-- <div class="az-content-label mg-b-30">Participated Rounds</div> --}}
                       
              
                        <div>
                          <table id="example2" class="table">
                            <thead>
                              <tr>
                                <th class="wd-20p">Image</th>
                                <th class="wd-25p">Name</th>
                                <th class="wd-20p">Points</th>
                                <th class="wd-15p">Email</th>
                                <th class="wd-20p">Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                             @foreach ($leaderBoardAllTimeAll as $lb)
                                 
                            
                              <tr>
                                <td><img src="{{$lb['images']['0']['url']}}" alt="Girl in a jacket" width="25" height="25"></td>
                                <td>{{$lb['name']}}</td>
                                <td>{{$lb['winning_coins']}}</td>
                                <td>
                                    
                                  {{$lb['email']}}
                                    
                                  </td>
                                <td>
                                  <div class="row d-flex justify-content-end" style="margin-right: 8%">
                                      <form action="{{ route ('user.profile',$lb['id']) }}" >
                                        
                    
                                          {{-- {{ csrf_field() }} --}}
                                          
                                  <button type="submit" class="grid-btn" style="width:100px;"><i class="typcn typcn-eye"></i></button>
                                      </form>
                                  </div> 
                            </td>
                              </tr>
                              @endforeach
                             
                              
                            </tbody>
                          </table>
                        </div>
              
              
              
              
              
              
              
                  </div><!-- az-content-body -->
              </div>
              {{-- End Here --}}
            </div>
                
               
              
            {{-- </div> --}}
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