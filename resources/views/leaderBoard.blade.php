@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')


  <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


    <div class="az-content-label mg-b-5">Games DataTable</div>
    {{-- <p>{{$leaderBoardMonthly}}</p> --}}
    {{-- {!! dd($leaderBoardMonthly[0]) !!} --}}
          <p class="mg-b-20">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>

          <div>
            <table id="example2" class="table">
              <thead>
                <tr>
                  <th class="wd-30p">Name</th>
                  <th class="wd-50p">Email</th>
                  <th class="wd-20p">Points</th>
                  {{-- <th class="wd-15p">Happening Date</th>
                  <th class="wd-20p">Created At</th> --}}
                </tr>
              </thead>
              <tbody>
               
                @foreach ($leaderBoardMonthly as $game)
                {{-- {!! dd($game['name']) !!} --}}
                <tr>
                  <td>{{$game['name']}}</td>
                  <td>
                     {{$game['email']}}
                     {{-- <img src="{{ asset($game->email)}}" alt="Girl in a jacket" width="25" height="25">  &nbsp    {{$game->team_a}} --}}
                  </td>
                  <td>
                     {{$game['winning_coins']}}
                     {{-- <img src="{{ asset($game->winning_coins)}}" alt="Girl in a jacket" width="25" height="25">  &nbsp    {{$game->team_b}} --}}
                  </td>
                  {{-- <td>
                      <span class="badge badge-pill badge-primary" style="width: 80px">
                      {{$game->happening_date}}
                      </span>
                    </td>
                  <td> --}}
                    {{-- {{ 
                  
                  
                }} --}}
              </td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>







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