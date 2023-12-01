<div class="col-12">
    <div class="card recent-sales overflow-auto">

      <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <li class="dropdown-header text-start">
            <h6>Filter</h6>
          </li>

          <li><a class="dropdown-item" href="#">Today</a></li>
          <li><a class="dropdown-item" href="#">This Month</a></li>
          <li><a class="dropdown-item" href="#">This Year</a></li>
        </ul>
      </div>

      <div class="card-body">
        <h5 class="card-title">Recent Registered</h5>

        <table class="table table-borderless datatable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                <th scope="col">Contact</th>
              @endif
              <th scope="col">Membership ID</th>
              <th scope="col">Email</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($members as $member)
            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin') || (auth()->user()->hasRole('user') && $member['members']['membership_id'] && auth()->user()->id !== $member['id']))
                <tr>
                    <th scope="row"><a href="#">{{$member['id']}}</a></th>
                    <td>
                        @if ($member['members']['image_path'])
                            <img src="{{URL::to("/") ."/". $member['members']['image_path']}}" alt="Profile" class="rounded-circle" style="height: 30px;width:30px">
                        @endif
                        {{$member['name']}}
                    </td>
                    @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                        <td>{{$member['contact']}}</td>
                    @endif
                    <td>{{$member['members']['membership_id']}}</td>
                    <td>{{$member['email']}}</td>
                    <td>
                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                            <a href="{{route('admin.edituser',['userId' => $member['id']])}}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                        @else
                            <a href="{{route('admin.edituser',['userId' => $member['id']])}}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endif
            @empty

            @endforelse

          </tbody>
        </table>

      </div>

    </div>
  </div><!-- End Recent Sales -->
