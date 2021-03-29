@include('includes.header')
@include('includes.sidebar')
@include('includes.subheader')


  <div class="az-content-body mg-t-20" style="padding: 0 40px 40px !important ; ">


    <div class="az-content-label mg-b-5">Games DataTable</div>
          <p class="mg-b-20">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>

          <div>
            <table id="example2" class="table">
              <thead>
                <tr>
                  <th class="wd-20p">Image</th>
                  <th class="wd-25p">Name</th>
                  <th class="wd-20p">Email</th>
                  <th class="wd-15p">Cell#</th>
                  <th class="wd-8p">Coins</th>
                  <th class="wd-12p">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td><img src="{{$user->images[0]->url}}" alt="Girl in a jacket" width="25" height="25"></td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>
                      
                      {{$user->contacts[0]->phone}}
                      
                    </td>
                  <td>
                   
                  {{$user->coins}} 
                  
               
              </td>
              <td>
                <div class="row d-flex justify-content-end" style="margin-right: 8%">
                    <form 
                action="{{ route('user.profile',$user->id) }}" 
                method="POST" >
                    {{ csrf_field() }}
                   
                    <button  type="submit" class="grid-btn" style="width:100px;" ><i class="typcn typcn-eye"></i></button>
                </form>
                </div>
              </td>
                </tr>
                @endforeach
                
              </tbody>
            </table>
          </div>







    </div><!-- az-content-body -->




@include('includes.subfooter')
@include('includes.footer')