@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <div class="card-header">
                    <form class="form-inline" id="form-filter">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <div class="col-5">
                                <select class="form-control select-filter" name="role" id="role">
                                    <option selected value="">All</option>
                                    @foreach($roles as $key => $value)
                                        <option value="{{ $value }}" @if($selectedRole == (string)$value) selected @endif>
                                            {{ $key }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="city">City</label>
                            <div class="col-5">
                                <select class="form-control select-filter" name="city" id="city">
                                    <option selected value="">All</option>
                                    @foreach($cities as $city)
                                        <option @if($selectedCity == $city) selected @endif>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company">Company</label>
                            <div class="col-5">
                                <select class="form-control select-filter" name="company" id="company">
                                    <option selected value="">All</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}"
                                            @if($selectedCompany == $company->id) selected @endif>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>Info</th>
                                <th>Role</th>
                                <th>Position</th>
                                <th>City</th>
                                <th>Company</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $each)
                                <tr>
                                    <td>
                                        <a href="{{ route("admin.$table.show", $each) }}">
                                            {{ $each->id }}
                                        </a>
                                    </td>
                                    <td>
                                        <img src="{{ $each->avatar }}" width="32px">
                                    </td>
                                    <td>
                                        {{ $each->name }} - {{ $each->gender_name }}
                                        <br>
                                        <a href="mailto:{{$each->email}}">
                                            {{ $each->email }}
                                        </a>
                                        <br>
                                        <a href="tel:{{ $each->phone }}">
                                            {{ $each->phone }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $each->role_name }}
                                    </td>
                                    <td>
                                        {{ $each->position }}
                                    </td>
                                    <td>
                                        {{ $each->city }}
                                    </td>
                                    <td>
                                        {{ optional($each->company)->name }}
                                    </td>
                                    <td>
                                        <form action="{{ route("admin.$table.destroy", $each) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination pagination-rounded mb-0">
                            {{ $data->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    jQuery(document).ready(function($) {
        $('.select-filter').change(function() {
            $('#form-filter').submit();
        });
    });
</script>
@endpush
