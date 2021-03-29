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
                                <div class="m-b-25"> <img src="{{ $agent->images[0]->url }}" class="img-radius"
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
                                            <button data-toggle="modal" data-target="#modaldemo2" 
                                            style="background: transparent;border: none;margin-top: 2px;
                                            padding-top: 0px;align-self: flex-start;margin-left: 5px;">
                                            <i class="typcn typcn-pencil" style="color: black;"></i>
                                            </button>
                                            

                                             <!-- SMALL MODAL -->
    <div id="modaldemo2" class="modal">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title">Comission Percentage</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{ route('update.comission',$agent->id) }}">
                @csrf
            <div class="modal-body">
                <input class="form-control" name="percent" placeholder="Input box" type="text">
             
            </div>
            <div class="modal-footer justify-content-center">
              <button type="submit" class="btn btn-outline-light">Save changes</button>
              {{-- <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button> --}}
            </div>
            </form>
          </div>
        </div><!-- modal-dialog -->
      </div><!-- modal -->
  
                                        </div>




                                        <h6 class="text-muted f-w-400">{{$comission}}</h6>
                                    </div>
                                    <div class="col-sm-6">

                                    </div>

                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Comission Percentage</p>
                                        <h6 class="text-muted f-w-400">{{$comission}} %</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">WhatsApp</p>
                                        <h6 class="text-muted f-w-400">{{$agent->contacts[0]->whatsapp}}</h6>
                                    </div>
                                    
                                </div> --}}
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
                {{-- Start Here --}}
                <div class="az-content-body mg-t-20" style="padding: 0 15px 15px !important ; ">
                    <div class="row">
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Today Sale</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $daily_data['sales'] }}</b></p>
                        </div>
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Weekly Sale</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $weekly_data['sales'] }}</b></p>
                        </div>
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Monthly Sale</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $monthly_data['sales'] }}</b></p>
                        </div>
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">All Time Sale </h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $all_time_data['sales'] }}</b></p>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Today Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $daily_data['comission'] }}</b></p>
                        </div>
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Weekly Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $weekly_data['comission'] }}</b></p>
                        </div>
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">Monthly Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $monthly_data['comission'] }}</b></p>
                        </div>
                        <div class="col-md-3 card user-card-full">
                            <h6 style="padding: 15px; text-align: center; padding-bottom: 0px;">All Time Comission</h6>
                            <hr style="margin-top: 0px;padding-top: 0px;">
                            <p style="text-align: center;"><b>{{ $all_time_data['comission'] }}</b></p>
                        </div>


                    </div>
                </div>
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
