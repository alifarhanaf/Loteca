@include('includes.header')

@include('includes.sidebar')
@include('includes.subheader')

<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl-6 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> <img style="height: 290px;width:250px;" src="{{ $agent->images[0]->url }}" class="img-radius"
                                        alt="User-Profile-Image"> </div>
                                <h6 class="f-w-600">{{ $agent->name }}</h6>
                                <p>Coins Agent</p> <i
                                    class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Basic Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Coins</p>
                                        <h6 class="text-muted f-w-400">{{ $agent->coins }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400">{{ $agent->email }}</h6>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Contact Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Phone</p>
                                        <h6 class="text-muted f-w-400">{{ $agent->contacts[0]->phone }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">WhatsApp</p>
                                        <h6 class="text-muted f-w-400">{{ $agent->contacts[0]->whatsapp }}</h6>
                                    </div>

                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Comission Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row" style="padding-left: 15px;">
                                            <p class="m-b-10 f-w-600">Comission Percentage</p>
   
                                        </div>
                                        <h6 class="text-muted f-w-400">{{$comission}}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row" style="padding-left: 15px;">
                                            <p class="m-b-10 f-w-600">Comission Available</p>
   
                                        </div>
                                        <h6 class="text-muted f-w-400">$ {{$availableComission}}</h6>
                                    </div>

                                </div>
                                <ul class="social-link list-unstyled m-t-40 m-b-10">
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                            data-original-title="facebook" data-abc="true"><i
                                                class="mdi mdi-facebook feather icon-facebook facebook"
                                                aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                            data-original-title="twitter" data-abc="true"><i
                                                class="mdi mdi-twitter feather icon-twitter twitter"
                                                aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                            data-original-title="instagram" data-abc="true"><i
                                                class="mdi mdi-instagram feather icon-instagram instagram"
                                                aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                </div>
                {{-- Start Here Comission Change --}}
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">Change Comission</div>
                    {{-- <label class="form-label">Email</label> --}}
                    <form method="POST" action="{{ route('update.comission',$agent->id) }}">
                        @csrf
                    <div class="row">
                        
                            
                        <div class="col-md-6">
                    <div class="az-form-group mg-t-20">
                        
                        <input name="percent" type="text" class="form-control" placeholder="Enter New Comission % To Be Assigned" >
                      </div><!-- az-form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="az-form-group mg-t-20 tpt" style="background:#98AFC7;border:1px solid #98AFC7 ">
                            <button  type="submit" class="grid-btn" style="width: 100%;height:25px" ><i class="typcn typcn-tick"></i></button>
                            </div>
                        </div>
                        
                    </div>
                </form>
                    </div>
                    </div>
                    {{-- EndHereComission Change --}}
                    {{-- Start Here WithDraw Comission  --}}
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">WthDraw Comission</div>
                    {{-- <label class="form-label">Email</label> --}}
                    <form method="POST" action="{{ route('update.comission',$agent->id) }}">
                        @csrf
                    <div class="row">
                        
                            
                        <div class="col-md-6">
                    <div class="az-form-group mg-t-20">
                        
                        <input name="withdraw" type="text" class="form-control" placeholder="Enter New Comission % To Be Assigned" >
                      </div><!-- az-form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="az-form-group mg-t-20 tpt" style="background:#98AFC7;border:1px solid #98AFC7 ">
                            <button  type="submit" class="grid-btn" style="width: 100%;height:25px" ><i class="typcn typcn-tick"></i></button>
                            </div>
                        </div>
                        
                    </div>
                </form>
                    </div>
                    </div>
                    {{-- EndHere WithDraw Comission  --}}
                    {{-- Start Assign Points To Agent --}}
                    <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                        <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                        <div class="az-content-label " style="margin-bottom:0px">Add Points</div>
                        {{-- <label class="form-label">Email</label> --}}
                        <form method="POST" action="{{ route('points.update',$agent->id) }}">
                            @csrf
                        <div class="row">
                            
                                
                            <div class="col-md-6">
                        <div class="az-form-group mg-t-20">
                            
                            <input name="points" type="text" class="form-control" placeholder="Enter Number Of Points To Be Assigned" >
                          </div><!-- az-form-group -->
                            </div>
                            <div class="col-md-6">
                                <div class="az-form-group mg-t-20 tpt" style="background:#98AFC7;border:1px solid #98AFC7 ">
                                <button  type="submit" class="grid-btn" style="width: 100%;height:25px" ><i class="typcn typcn-tick"></i></button>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                        </div>
                        </div>
                        {{-- End Here --}}
                {{-- Start Here --}}
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">Comission History</div>
                    </div>
                    </div>
                <div class="az-content-body mg-t-20" style="padding: 0 15px 15px !important ; ">
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Today Sale</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $daily_data['sales'] }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Today Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $daily_data['comission'] }}</b></p>
                            </div>
                        </div>
                        
                        
                        


                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Weekly Sale</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $weekly_data['sales'] }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Weekly Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $weekly_data['comission'] }}</b></p>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="az-content-body mg-t-20" style="padding: 0 15px 15px !important ; ">
                    <div class="row">
                        
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Monthly Sale</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $monthly_data['sales'] }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Monthly Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $monthly_data['comission'] }}</b></p>
                            </div>
                        </div>
                        


                    </div>
                    <div class="row">
                        
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">All Time Sale </h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $all_time_data['sales'] }}</b></p>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">All Time Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $all_time_data['comission'] }}</b></p>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- Sent Coins Record Here --}}
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">Coins Sent History</div>
                    </div>
                    </div>
                    <div class="card user-card-full">
                        <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">
        
        
                            {{-- <div class="az-content-label mg-b-30">Participated Rounds</div> --}}
                                 
                        
                                  <div>
                                    <table id="example" class="table">
                                      <thead>
                                        <tr>
                                         
                                          <th class="wd-20p">Receiver Name</th>
                                          <th class="wd-20p">Receiver Email</th>
                                          <th class="wd-20p">Receiver Cell</th>
                                          <th class="wd-10p">Coins</th>
                                          <th class="wd-20p">Transferred Date</th>
                                          <th class="wd-20p">Status</th>
                                         
                                        </tr>
                                      </thead>
                                      <tbody>
                                       @foreach ($coin_history as $ch)
                                     
                                           
                                      
                                        <tr>
                                         
                                          <td>{{$ch['user_name']}}</td>
                                          <td>{{$ch['user_email']}}</td>
                                          <td>{{$ch['user_phone']}}</td>
                                          <td>{{$ch['transferred_coins']}}</td>
                                          <td>{{$ch['transfer_date']}}</td>
                                          <td>
                                            <span class="badge badge-pill badge-primary" style="width: 50px;">
                                              Success
                                            </td>
                                          
                                        
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                            </div><!-- az-content-body -->
                        </div>


                {{-- End Here --}}
                {{-- Bets Placed For User Record Here --}}
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">Bets On User Behalf History</div>
                    </div>
                    </div>
                    <div class="card user-card-full">
                        <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">
        
        
                            {{-- <div class="az-content-label mg-b-30">Participated Rounds</div> --}}
                                 
                        
                                  <div>
                                    <table id="example3" class="table">
                                      <thead>
                                        <tr>
                                         
                                          <th class="wd-15p">Receiver Name</th>
                                          <th class="wd-15p">Receiver Email</th>
                                          <th class="wd-20p">Receiver Cell</th>
                                          <th class="wd-20p">Coins For Bet</th>
                                          <th class="wd-20p">Betting Date</th>
                                          <th class="wd-20p">Status</th>
                                         
                                        </tr>
                                      </thead>
                                      <tbody>
                                       @foreach ($bet_history as $bt)
                                     
                                           
                                      
                                        <tr>
                                         
                                          <td>{{$bt['user_name']}}</td>
                                          <td>{{$bt['user_email']}}</td>
                                          <td>{{$bt['user_phone']}}</td>
                                          <td>{{$bt['coins_used']}}</td>
                                          <td>{{$bt['bet_date']}}</td>
                                          <td>
                                            <span class="badge badge-pill badge-primary" style="width: 50px;">
                                              Success
                                            </td>
                                          
                                        
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                  </div>
                            </div><!-- az-content-body -->
                        </div>


                {{-- End Here --}}
                {{-- Round Start Here --}}
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">Participated Rounds</div>
                    </div>
                    </div>

                    <div class="card user-card-full">
                        <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">
        
        
                            {{-- <div class="az-content-label mg-b-30">Participated Rounds</div> --}}
                                 
                        
                                  <div>
                                    <table id="example2" class="table">
                                      <thead>
                                        <tr>
                                         
                                          <th class="wd-20p">Round Name</th>
                                          <th class="wd-20p">Starting Date</th>
                                          <th class="wd-20p">Ending Date</th>
                                          <th class="wd-15p">Status</th>
                                          <th class="wd-25p">Actions</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                       @foreach ($rounds as $round)
                                           
                                      
                                        <tr>
                                          {{-- <td><img src="https://img.icons8.com/bubbles/100/000000/user.png" alt="Girl in a jacket" width="25" height="25"></td> --}}
                                          <td>{{$round->name}}</td>
                                          <td>{{$round->starting_date}}</td>
                                          <td>
                                              
                                            {{$round->ending_date}}
                                              
                                            </td>
                                          <td>
                                            <span class="{{$round->status == 1 ? 'badge badge-pill badge-primary': 'badge badge-pill badge-warning'}}" style="width: 50px;">
                                              {{$round->status == 1 ? 'Live':'Closed'}}
                                            </td>
                                          
                                          <td>
                                            <div class="row d-flex justify-content-end" style="margin-right: 8%">
                                                <form action="{{ route ('roundDetail',$round->id) }}" >       
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
                {{-- <div class="az-content-body mg-t-20" style="padding: 0 15px 15px !important ; ">
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Available Comission To Withdraw</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $daily_data['sales'] }}</b></p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="card user-card-full">
                <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


                    <div class="az-content-label mg-b-30">Participated Rounds</div>
                         
                
                          <div>
                            <table id="example2" class="table">
                              <thead>
                                <tr>
                                  <th class="wd-20p">Image</th>
                                  <th class="wd-25p">Round Name</th>
                                  <th class="wd-20p">Starting Date</th>
                                  <th class="wd-15p">Ending Date</th>
                                  <th class="wd-20p">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                               @foreach ($rounds as $round)
                                   
                              
                                <tr>
                                  <td><img src="https://img.icons8.com/bubbles/100/000000/user.png" alt="Girl in a jacket" width="25" height="25"></td>
                                  <td>{{$round->name}}</td>
                                  <td>{{$round->starting_date}}</td>
                                  <td>
                                      
                                    {{$round->ending_date}}
                                      
                                    </td>
                                  <td>
                                    <div class="row d-flex justify-content-end" style="margin-right: 8%">
                                        <form action="{{ route ('roundDetail',$round->id) }}" >
                      
                                            {{ csrf_field() }}
                                            
                                    <button type="submit" class="grid-btn" style="width:100px;"><i class="typcn typcn-eye"></i></button>
                                        </form>
                                    </div> 
                              </td>
                                </tr>
                                @endforeach
                               
                                
                              </tbody>
                            </table>
                          </div>
                
                
                
                
                
                
                
                    </div>
                    
                </div> --}}
                {{-- End Here --}}
            </div>
        </div>
    </div>
</div>



@include('includes.subfooter')
@include('includes.footer')
<script type="text/javascript">
$(document).ready(function(){
    $('#clickMe').click(function () {
           
            console.log('Hello');
           
        });
});

</script>