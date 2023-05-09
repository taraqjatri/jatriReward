@extends('master')

@section('title')
    Admins
@endsection

@section('breadcrumb')
    <span class="breadcrumb-item active">Admin List</span>
@endsection


@section('page_actions')

    @if(in_array(config('access.users.admin-write'), $admin_roles))
        <div class="dropdown ms-lg-3">
            <a href="#" class="d-flex align-items-center text-body dropdown-toggle py-2" data-bs-toggle="dropdown">
                <i class="ph-gear me-2"></i>
                <span class="flex-1">Actions</span>
            </a>

            <div class="dropdown-menu dropdown-menu-end w-100 w-lg-auto" style="">
                <a href="{{url('admins/create')}}" class="dropdown-item">
                    <i class="ph-user-circle-plus me-2"></i>
                    Add New
                </a>
            </div>
        </div>
    @endif

@endsection

@section('page_content')

    <form method="GET" action="">
        <div class="row">
            <div class="col-md-2 mb-2">
                <label class="form-label">Status:</label>
                <select class="form-control" name="status">
                    <option value="ACTIVE" {{ request('status') == "ACTIVE" ? 'selected' : '' }}>ACTIVE</option>
                    <option value="INACTIVE" {{ request('status') == "INACTIVE" ? 'selected' : '' }}>INACTIVE</option>
                </select>
            </div>

            <div class="col-md-1 mt-2">
                <label class="fw-bold col-md-12 col-sm-0 col-xs-0">&nbsp;</label>
                <button type="submit" class="btn btn-sm bg-dark col-lg-10 col-md-10 col-sm-12 col-xs-12 text-white"><i
                        class="icon-search4"></i></button>
            </div>
        </div>
    </form>

    <div class="col-12">
        <div class="row card">
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone / Email</th>
                                <th>Designation</th>
                                <th>Line Manager</th>
                                <th class="text-center">Status</th>
                                <th>SignUp Date</th>
                                @if(in_array(config('access.users.admin-write'), $admin_roles))
                                 <th class="text-center">Edit</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $key => $admin)
                                    <tr>
                                        <td>{{ request('page') ? $loop->iteration + ((request('page') - 1) * 50) : $loop->iteration }}</td>
                                        <td style="position: relative;">
                                            {{ $admin->name }}
                                            @if($admin->admin_type == \App\Enums\AdminTypeEnum::SYSTEM_ADMIN->value)
                                                <span class="badge bg-primary" style="position: absolute; right: 0; margin-right: 10px;">S</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $admin->phone }} <br>
                                            {{ $admin->email }}
                                        </td>
                                        <td>{{ $admin->designation }}</td>
                                        <td>{{ $admin->line_manager ? $admin->line_manager->name : '-' }}</td>
                                        <td class="text-center">
                                            @if($admin->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="">{{ \Carbon\Carbon::parse($admin->created_at)->format('d M, Y') }}</span>
                                        </td>
                                       @if(in_array(config('access.users.admin-write'), $admin_roles))
                                        <td style="text-align: center;"><a href="{{ url('/admins/'.$admin->id.'/edit') }}" class="btn btn-outline-dark btn-sm"><i class="ph-pencil-line"></i></a></td>
                                       @endif
                                    </tr>
                                @endforeach
                             </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
