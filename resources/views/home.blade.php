@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')



     
      <div class="az-content-header d-block d-md-flex">
        <div>
          <h2 class="az-content-title tx-24 mg-b-5 mg-b-lg-8">Hi, welcome back!</h2>
          <p class="mg-b-0">Your sales monitoring dashboard template.</p>
        </div>
        <div class="az-dashboard-header-right">
          <div>
            <label class="tx-13">Customer Ratings</label>
            <div class="az-star">
              <i class="typcn typcn-star active"></i>
              <i class="typcn typcn-star active"></i>
              <i class="typcn typcn-star active"></i>
              <i class="typcn typcn-star active"></i>
              <i class="typcn typcn-star"></i>
              <span>(12,775)</span>
            </div>
          </div>
          <div>
            <label class="tx-13">All Sales </label>
            <h5>{{$sales['all_sales']}}</h5>
          </div>
          <div>
            <label class="tx-13">Total Coins</label>
            <h5>{{$totalCoins}}</h5>
          </div>
        </div><!-- az-dashboard-header-right -->
      </div><!-- az-content-header -->
      <div class="az-content-body">
        <div class="card card-dashboard-seven">
         
          <div class="card-body">
            <div class="row row-sm">
              <div class="col-6 col-lg-3">
                <label class="az-content-label">Daily Saless</label>
                <h2>{{$sales['daily_sales']}}</h2>
                <div class="desc up">
                 
                </div>
               
              </div><!-- col -->
              <div class="col-6 col-lg-3">
                <label class="az-content-label">Weekly Sales</label>
                <h2>{{$sales['weekly_sales']}}</h2>
                <div class="desc up">
                  
                </div>
               
              </div><!-- col -->
              <div class="col-6 col-lg-3 mg-t-20 mg-lg-t-0">
                <label class="az-content-label">Monthly Sales</label>
                <h2>{{$sales['monthly_sales']}}</h2>
                <div class="desc down">
                 
                </div>
                
              </div><!-- col -->
              <div class="col-6 col-lg-3 mg-t-20 mg-lg-t-0">
                <label class="az-content-label">All Time Sales</label>
                <h2>{{$sales['all_sales']}}</h2>
                <div class="desc up">
                 
                </div>
               
              </div><!-- col -->
            </div><!-- row -->
          </div><!-- card-body -->
        </div><!-- card -->

        <div class="row row-sm mg-b-15 mg-sm-b-20">
          <div class="col-lg-6 col-xl-7">
            <div class="card card-dashboard-six" style="height: auto !important">
              <div class="card-header">
                <div>
                  <label class="az-content-label">Monthly LeaderBoard</label>
                  <span class="d-block">High Performing Players on Monthly Bases</span>
                </div>
                <div class="chart-legend">
                  <div><span>Online Revenue</span> <span class="bg-indigo"></span></div>
                  <div><span>Offline Revenue</span> <span class="bg-teal"></span></div>
                </div>
              </div><!-- card-header -->
              <div class="row text-center">
                <div class="col-md-4 ">
                  <img 
                  @if (array_key_exists('0', $monthlyLeaderBoard)&&array_key_exists('0', $monthlyLeaderBoard[0]['images']))
                  src="{{$monthlyLeaderBoard[0]['images'][0]['url']}}"
                    @else
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU"
                    @endif
                  alt="Girl in a jacket" width="100" height="100" style="border-radius: 50px;border: 1px solid black">
                  <p class="mg-t-10"><b>
                    @if (array_key_exists('0', $monthlyLeaderBoard))
                    <p>{{ $monthlyLeaderBoard[0]['name'] }} </p>
                    @else
                    <p>No Data Available</p>
                    @endif
                    {{-- {{$monthlyLeaderBoard[0]['name'] == null ? 'No Data Available': $monthlyLeaderBoard[0]['name']}} --}}
                  </b></p>
                </div>
                <div class="col-md-4">
                  <img 
                  

                  @if (array_key_exists('1', $monthlyLeaderBoard)&&array_key_exists('0', $monthlyLeaderBoard[1]['images']))
                  src="{{$monthlyLeaderBoard[1]['images'][0]['url']}}"
                    @else
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU"
                    @endif

                  {{-- {{$monthlyLeaderBoard[1]['images'][0]['url']}} --}}
                   alt="Girl in a jacket" width="100" height="100" style="border-radius: 50px;border: 1px solid black">
                  <p class="mg-t-10"><b>
                    {{-- {{$monthlyLeaderBoard[1]['name'] == null ? 'No Data Available': $monthlyLeaderBoard[1]['name']}} --}}
                    @if (array_key_exists('1', $monthlyLeaderBoard))
                    <p>{{ $monthlyLeaderBoard[1]['name'] }} </p>
                    @else
                    <p>No Data Available</p>
                    @endif
                  </b></p>
                </div>
                <div class="col-md-4">
                  <img 
                  @if (array_key_exists('2', $monthlyLeaderBoard)&&array_key_exists('0', $monthlyLeaderBoard[2]['images']))
                  src="{{$monthlyLeaderBoard[2]['images'][0]['url']}}"
                    @else
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU"
                    @endif
                  {{-- src="{{$monthlyLeaderBoard[1]['images'][0]['url']}}" --}}
                   alt="Girl in a jacket" width="100" height="100" style="border-radius: 50px;border: 1px solid black">
                  <p class="mg-t-10"><b>
                    {{-- {{$monthlyLeaderBoard[2]['name'] == null ? 'No Data Available': $monthlyLeaderBoard[2]['name']}} --}}
                    @if (array_key_exists('2', $monthlyLeaderBoard))
                    <p>{{ $monthlyLeaderBoard[2]['name'] }} </p>
                    @else
                    <p>No Data Available</p>
                    @endif
                  </b></p>
                </div>
              </div>
            
            </div><!-- card -->
          </div><!-- col -->
          <div class="col-lg-6 col-xl-5 mg-t-20 mg-lg-t-0">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-dashboard-map-one" style="height: auto !important">
                  <label class="az-content-label">Total Users</label>
                  <span class="d-block mg-b-20"><b>{{$totalUsers}}</b></span>
                  
                </div><!-- card -->
            
              </div>
              <div class="col-md-6">
                <div class="card card-dashboard-map-one" style="height: auto !important">
                  <label class="az-content-label">Total Agents</label>
                  <span class="d-block mg-b-20">{{$totalAgents}}</span>
                  
                </div><!-- card -->
            
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
              <div class="card card-dashboard-map-one" style="height: auto !important">
                <label class="az-content-label">Current Live Round</label>
                <span class="d-block mg-t-5 "><b>Round Name:</b> {{$roundName}}</span>
                <span class="d-block mg-b-10"><b>Total Games</b>: {{$totalGames}}</span>
                
              </div><!-- card -->
              </div>

            </div>
            
          </div><!-- col -->
          
        </div><!-- row -->

        <div class="row row-sm mg-b-20 mg-lg-b-0">
          <div class="col-md-6 col-xl-7">
            <div class="card card-dashboard-six" style="height: auto !important">
              <div class="card-header">
                <div>
                  <label class="az-content-label">Top Agents</label>
                  <span class="d-block">High Performing Players on Monthly Bases</span>
                </div>
                <div class="chart-legend">
                  <div><span>Online Revenue</span> <span class="bg-indigo"></span></div>
                  <div><span>Offline Revenue</span> <span class="bg-teal"></span></div>
                </div>
              </div><!-- card-header -->
              <div class="row text-center">
                <div class="col-md-4 ">
                  <img 
                  @if (array_key_exists('0', $topAgents[0]['images']))
                  src="{{$topAgents[0]['images'][0]['url']}}"
                    @else
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU"
                    @endif
                  {{-- src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU" --}}
                  
                  alt="Girl in a jacket" width="100" height="100" style="border-radius: 50px;border: 1px solid black">
                  <p class="mg-t-10"><b>
                    @if (array_key_exists('0', $topAgents)&&array_key_exists('0', $topAgents))
                    <p>{{ $topAgents[0]['name'] }} </p>
                    @else
                    <p>No Data Available</p>
                    @endif
                    {{-- @if(isset($topAgents[0]['name']))
                    {{$topAgents[0]['name']}}
                    @else
                    Hello --}}
                    
                    {{-- {{$topAgents[0]['name'] == null ? 'No Data Available': $topAgents[0]['name']}} --}}
                  </b></p>
                </div>
                <div class="col-md-4">
                  <img 
                  {{-- src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU" --}}
                  @if (array_key_exists('1', $topAgents)&&array_key_exists('0', $topAgents[1]['images']))
                  src="{{$topAgents[1]['images'][0]['url']}}"
                    @else
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU"
                    @endif

                   alt="Girl in a jacket" width="100" height="100" style="border-radius: 50px;border: 1px solid black">
                  <p class="mg-t-10"><b>
                    @if (array_key_exists('1', $topAgents))
                    <p>{{ $topAgents[1]['name'] }} </p>
                    @else
                    <p>No Data Available</p>
                    @endif
                  </b></p>
                </div>
                <div class="col-md-4">
                  <img 
                  @if (array_key_exists('2', $topAgents)&&array_key_exists('0', $topAgents[2]['images']))
                  src="{{$topAgents[2]['images'][0]['url']}}"
                    @else
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU"
                    @endif
                  {{-- src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXCiVWLZy51nFsD_bM9hjU1ysr84YDTz7jTw&usqp=CAU" --}}
                   alt="Girl in a jacket" width="100" height="100" style="border-radius: 50px;border: 1px solid black">
                  <p class="mg-t-10"><b>
                    @if (array_key_exists('2', $topAgents))
                    <p>{{ $topAgents[2]['name'] }} </p>
                    @else
                    <p>No Data Available</p>
                    @endif
                  </b></p>
                </div>
              </div>
            
            </div><!-- card -->
          </div>
          <div class="col-md-6 col-xl-5 mg-t-20 mg-md-t-0">
           
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- az-content-body -->


      @include('includes.subfooter')
      @include('includes.footer')
     
    