@extends('master')

@section('title')
    Admins
@endsection

@section('header')

@endsection

@section('breadcrumb')
    <a href="{{ url('/admins') }}" class="breadcrumb-item">Admin List</a>
    <span class="breadcrumb-item active">Edit Admin</span>
@endsection

@section('page_content')

    <div class="d-md-flex align-items-md-start">

        <!-- Left sidebar component -->
        <div
            class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Navigation -->
                <div class="card me-2">
                    <div class="card-body p-0">
                        <ul class="nav nav-sidebar mb-2">
                            <li class="nav-item">
                                <a href="#generalInfo" class="nav-link active" data-bs-toggle="tab"
                                   data-bs-target="#generalInfo">
                                    <i class="icon-info22"></i> Profile Information
                                </a>
                            </li>

                            @foreach(config('access.access-name') as $key => $value)
                                @if(auth()->user()->admin_type == 'REGULAR' && !count(array_intersect(array_values(config('access.'.$key)), $admin_roles)) > 0)
                                    @continue
                                @endif
                                <li class="nav-item">
                                    <a href="#{{ $key }}" class="nav-link" data-bs-toggle="tab"
                                       data-bs-target="#{{ $key }}">
                                        <i class="icon-info22"></i> {{ $value }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /navigation -->
            </div>
            <!-- /sidebar content -->
        </div>
        <!-- /left sidebar component -->


        <!-- Right content -->
        <form class="tab-content flex-lg-fill" action="{{ url('/admins',$admin->id) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Profile Information --}}
            <div class="tab-pane fade active show" id="generalInfo">
                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h5 class="card-title">Profile Information</h5>

                    </div>


                    <div class="card-body form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold">Name:</label>
                                <input type="text" class="form-control" name="name" value="{{ $admin->name }}"
                                       placeholder="Enter Name" required autocomplete="off">
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Phone:</label>
                                <input type="text" class="form-control" name="phone" value="{{ $admin->phone }}"
                                       placeholder="Enter Phone" required autocomplete="off">
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold">Designation:</label>
                                <input type="text" class="form-control" name="designation"
                                       value="{{ $admin->designation }}" placeholder="Enter Designation" required
                                       autocomplete="off">
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Email:</label>
                                <input type="email" class="form-control" name="email" value="{{ $admin->email }}"
                                       placeholder="Enter Email" required autocomplete="off">
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold">Admin Type:</label>
                                <select name="admin_type" class="form-control">
                                    @if (auth()->user()->admin_type == "SYSTEM_ADMIN")
                                        <option
                                            value="SYSTEM_ADMIN" {{ $admin->admin_type == 'SYSTEM_ADMIN' ? 'selected' : '' }}>
                                            SYSTEM ADMIN
                                        </option>
                                    @endif
                                    <option value="REGULAR" {{ $admin->admin_type == 'REGULAR' ? 'selected' : '' }}>
                                        REGULAR
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="fw-bold">Status:</label>
                                <select name="status" class="form-control">
                                    <option value="ACTIVE" {{ $admin->status == 1 ? 'selected' : '' }}>ACTIVE</option>
                                    <option value="INACTIVE" {{ $admin->status == 0 ? 'selected' : '' }}>INACTIVE
                                    </option>
                                </select>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold">Password(if you want to change):</label>
                                <input type="password" class="form-control" name="password"
                                       placeholder="Enter Password if you want to change" autocomplete="new-password">
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">Confirm Password:</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                       placeholder="Enter Confirm Password" autocomplete="new-password">
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold">Line Manager:</label>
                                <select name="line_manager_id" class="form-control">
                                    <option value="">N/A</option>
                                    @foreach($all_admins as $all_admin)
                                        <option value="{{ $all_admin->id }}"
                                                @if($all_admin->id == $admin->line_manager_id) selected @endif>{{ $all_admin->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="fw-bold">Avatar:</label>
                                <input id="gallery-photo-add" type="file" class="form-control" name="avatar">
                            </div>

                            <div class="col-md-3 gallery">
                                <a href="{{ asset( 'storage/'.$admin->avatar ) }}" data-popup="lightbox" class="mr-1">
                                    <img src="{{ asset( 'storage/'.$admin->avatar ) }}" alt="Admin Avatar"
                                         class="rounded-circle" style="height: 100px; margin-left: 35%; width: 100px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Other Permission --}}
            @foreach(config('access') as $key => $data)

                @if($key == 'access-name')
                    @continue;
                @endif

                <div class="tab-pane fade" id="{{ $key }}">

                    <div class="card">
                        <div class="card-header header-elements-sm-inline">
                            <h5 class="card-title">
                                @foreach(config('access.access-name') as $key2 => $value)
                                    @if($key == $key2)
                                        {{ $value }} - Permissions
                                    @endif
                                @endforeach
                            </h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach($data as $key2 => $value)

                                    @if(auth()->user()->admin_type == "REGULAR" && in_array($value, json_decode(auth()->user()->roles)))
                                        <label class="col-md-4 form-check mb-4">
                                            <input type="checkbox" name="roles[]" class="form-check-input"
                                                   value={{ $value }} {{ in_array($value, json_decode($admin->roles)) ? 'checked' : '' }}>
                                            <span
                                                class="form-check-label fw-bold">{{ ucwords(str_replace('-', ' ', $key2)) }}</span>
                                        </label>
                                    @elseif(auth()->user()->admin_type == "SYSTEM_ADMIN")
                                        <label class="col-md-4 form-check mb-4">
                                            <input type="checkbox" name="roles[]" class="form-check-input"
                                                   value={{ $value }} {{ in_array($value, json_decode($admin->roles)) ? 'checked' : '' }}>
                                            <span
                                                class="form-check-label fw-bold">{{ ucwords(str_replace('-', ' ', $key2)) }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-end">
                <button type="submit" class="btn btn-outline-dark">Submit</button>
            </div>
        </form>
        <!-- /right content -->
    </div>

@endsection

@section('footer_js')
    <script>
        $(function () {
            // Multiple images preview in browser
            var imagesPreview = function (input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function (event) {
                            $($.parseHTML('<img class="rounded-circle" style="height: 100px; margin-left: 35%; width: 100px;">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#gallery-photo-add').on('change', function () {
                $('div.gallery').empty();
                imagesPreview(this, 'div.gallery');
            });
        });
    </script>
@endsection
