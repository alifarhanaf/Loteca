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
                                <div class="m-b-25"> <img style="height: 290px;width:250px;" src="{{$user->images[0]->url}}" class="img-radius" alt="User-Profile-Image"> </div>
                                <h6 class="f-w-600">{{$user->name}}</h6>
                                <p>End User</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                {{-- <button>
                                </button> --}}
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Basic Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Coins</p>
                                        <h6 class="text-muted f-w-400">{{$user->coins}}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400">{{$user->email}}</h6>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Contact Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Phone</p>
                                        <h6 class="text-muted f-w-400">{{$user->contacts[0]->phone}}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">WhatsApp</p>
                                        <h6 class="text-muted f-w-400">{{$user->contacts[0]->whatsapp}}</h6>
                                    </div>
                                    
                                </div>
                                @if($agent != null)
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Assigned Agent</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        
                                        <p class="m-b-10 f-w-600">{{$agent->name}}</p>
                                        <h6 class="text-muted f-w-400">{{$agent->contacts[0]->phone}}</h6>
                                        {{-- @else
                                        <form method="POST" action="{{ route('assign.agent',$user->id) }}">
                                            @csrf
                                        <div class="">
                                            
                                            <input style="border: none;
                                            text-decoration: underline;
                                            padding-left: 0px;" name="email" type="text" class="form-control" placeholder="Enter Agent Email To Assign" >
                                            <button  type="submit" class="grid-btn" style="width:100px;" ><i class="typcn typcn-tick"></i></button>
                                          </div>
                                        </form> --}}
                                        
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">WhatsApp</p>
                                        <h6 class="text-muted f-w-400">{{$user->contacts[0]->whatsapp}}</h6>
                                    </div> --}}
                                    
                                </div>
                                @endif
                                <ul class="social-link list-unstyled m-t-40 m-b-10">
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="facebook" data-abc="true"><i class="mdi mdi-facebook feather icon-facebook facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="twitter" data-abc="true"><i class="mdi mdi-twitter feather icon-twitter twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="instagram" data-abc="true"><i class="mdi mdi-instagram feather icon-instagram instagram" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                {{-- <button> --}}
                    @if($agent == null)
                    <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                        <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                        <div class="az-content-label " style="margin-bottom:0px">Assign Agent</div>
                        {{-- <label class="form-label">Email</label> --}}
                        <form method="POST" action="{{ route('assign.agent',$user->id) }}">
                            @csrf
                        <div class="row">
                            
                                
                            <div class="col-md-6">
                        <div class="az-form-group mg-t-20">
                            
                            <input name="email" type="text" class="form-control" placeholder="Enter Agent Email To Be Assigned" >
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
                        @endif
                        
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">Add Points</div>
                    {{-- <label class="form-label">Email</label> --}}
                    <form method="POST" action="{{ route('points.update',$user->id) }}">
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
                {{-- </button> --}}
                <div class="row text-center" style="margin-left: 0px;margin-right:0px">
                    <div class="card user-card-full" style="width: 100%;margin-bottom:10px;padding:15px 20px">
                    <div class="az-content-label " style="margin-bottom:0px">Participated Rounds</div>
                    </div>
                    </div>
                {{-- Start Here --}}
                <div class="card user-card-full">
                <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


                    {{-- <div class="az-content-label mg-b-30">Participated Rounds</div> --}}
                         
                
                          <div>
                            <table id="example2" class="table">
                              <thead>
                                <tr>
                                  <th class="wd-20p">Image</th>
                                  <th class="wd-20p">Round Name</th>
                                  <th class="wd-15p">Starting Date</th>
                                  <th class="wd-15p">Ending Date</th>
                                  <th class="wd-10p">Status</th>
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
            </div>
        </div>
    </div>
</div>



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