@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')


  <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


    <div class="az-content-label mg-b-5">Games Answers</div>
          <p class="mg-b-20">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>

          <div>
            <table id="example2" class="table">
              <thead>
                <tr>
                  <th class="wd-10p">Championship</th>
                  <th class="wd-15p">First Team</th>
                  <th class="wd-15p">Second Team</th>
                  <th class="wd-15p">Happening Date</th>
                  <th class="wd-30p">Add Answer</th>
                  <th class="wd-15p">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($games as $game)
                
                <tr>
                  <td>{{$game->name}}</td>
                  <td><img src="{{ asset($game->flag_a)}}" alt="Girl in a jacket" width="25" height="25">  &nbsp    {{$game->team_a}}</td>
                  <td><img src="{{ asset($game->flag_b)}}" alt="Girl in a jacket" width="25" height="25">  &nbsp    {{$game->team_b}}</td>
                  <td>
                      <span class="badge badge-pill badge-primary" style="width: 80px">
                      {{$game->happening_date}}
                      </span>
                    </td>
                    
                    <form action="{{ route('submit_game_answer',$game->id) }}" method="POST" >
                        {{ csrf_field() }}
                    <td>
                      
                      <label class="radio-inline" style="border: 1px solid black; border-radius:15px; padding-right:5px;padding-left:5px; background: #cdd4e0">
                        
                        <input style="margin-top: 5px;" type="radio" name="optradio" value="{{$game->team_a}}"> &nbsp {{$game->team_a}}
                      </label>
                      
                      <label class="radio-inline" style="border: 1px solid black; border-radius:15px; padding-right:5px;padding-left:5px; background: #cdd4e0">
                        <input style="margin-top: 5px;" type="radio" name="optradio" value="{{$game->team_b}}">&nbsp {{$game->team_b}}
                      </label>
                      <label class="radio-inline" style="border: 1px solid black; border-radius:15px; padding-right:5px;padding-left:5px; background: #cdd4e0">
                        <input style="margin-top: 5px;" type="radio" name="optradio" value="Draw">&nbsp Draw
                      </label>
                    </td>
                  <td>
                  
                        <button  type="submit" class="grid-btn-big" >Submit</button>
                    </form>
                    
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