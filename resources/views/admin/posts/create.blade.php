@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <style>
        .error {
            color: red;
        }
        input[data-switch]+label {
            width: 115px;
        }
        input[data-switch]:checked+label:after
        {
            left: 91px
        ;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                    <div id="div-error" class="alert alert-danger d-none"></div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="post" id="form-create-post">
                        @csrf
                        <div class="form-group">
                            <label>Company</label>
                            <select class="form-control" name="company" id="select-company">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Language (*)</label>
                            <select class="form-control" multiple name="languages[]" id="select-language">
                            </select>
                        </div>
                        <div class="form-row select-location">
                            <div class="form-group col-6">
                                <label>City (*)</label>
                                <select class="form-control select-city" name="city" id="select-city">
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>District</label>
                                <select class="form-control select-district" name="district" id="select-district">
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label>Min Salary</label>
                                <input type="number" name="min_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Max Salary</label>
                                <input type="number" name="max_salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <label>Currency</label>
                                <select name="currency_salary" class="form-control">
                                    @foreach($currencies as $key=> $value)
                                        <option value="{{ $value }}">
                                            {{ $key }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-8">
                                <label>Requirement</label>
                                <textarea id="text-requirement" name="requirement"></textarea>
                            </div>
                            <div class="form-group col-4">
                                <label>Number Of Applicants</label>
                                <input type="number" name="number_applicants" class="form-control">
                                <br>
                                <select name="remotable" class="form-control">
                                    @foreach($remotables as $key => $value)
                                        <option value="{{ $value }}">
                                            {{ __('frontpage.' . strtolower($key)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <br>
                                <input type="checkbox" id="can_parttime" name="can_parttime" checked data-switch="info">
                                <label for="can_parttime" data-on-label="Can Part Time" data-off-label="No Part Time"></label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Title</label>
                                <input type="text" name="job_title" class="form-control" id="title">
                            </div>
                            <div class="form-group col-6">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control" id="slug">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" id="btn-submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-company" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create Company</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-create-company" action="{{ route('admin.companies.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Company</label>
                            <input readonly name="name" id="company" class="form-control">
                        </div>
                        <div class="form-row select-location">
                            <div class="form-group">
                                <label>Country (*)</label>
                                <select class="form-control" name="country" id="country">
                                    @foreach($countries as $value => $name)
                                        <option value="{{ $value }}">
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label>City (*)</label>
                                <select name="city" class="form-control select-city" id="city"></select>
                            </div>
                            <div class="form-group col-4">
                                <label>District</label>
                                <select name="district" class="form-control select-district" id="district"></select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Address2</label>
                                <input type="text" name="address2" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Zipcode</label>
                                <input type="number" name="zipcode" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Phone</label>
                                <input type="number" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label>Logo</label>
                                <input name="logo" type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])">
                                <img id="pic" height="100">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitForm('company')" class="btn btn-success">Create</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        function generateTitle(){
            const languages = $('#select-language option:selected').map(function(){
                return $(this).text();
            }).get().join(',');
            const city = $('#select-city').val();
            const company = $('#select-company').val();
            // console.log(company);

            let title = `(${city})`;
            if (languages) {
                title += ` ${languages}`;
            }
            if (company) {
                title += languages ? ` - ${company}` : ` ${company}`;
            }
            $('#title').val(title)
            generateSlug(title);
        }
        function generateSlug(title){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('api.posts.slug.generate') }}',
                type: 'POST',
                dataType: 'json',
                headers: { 'Accept': 'application/json' },
                data: { title },
                success: function(response){
                    $('#slug').val(response.data);
                    $('#slug').trigger('change');
                },
                error: function(response){
                    console.log(response);
                }
            });

        }
        async function loadDistrict(parent){
            parent.find(".select-district").empty()
            const path = parent.find('.select-city option:selected').data('path');
            if(!path){
                return;
            }
            const response = await fetch('{{ asset('locations/') }}' + path)
            const districts = await response.json();
            let string = '';
            const selectedValue = $('#select-district').val();
            $.each(districts.district, function(index,each){
                if(each.pre === 'Quận' || each.pre === 'Huyện') {
                    string += `<option`;
                    if(selectedValue === each.name) {
                        string += ` selected `;
                    }
                    string += `>${each.name}</option>`;
                }
            })
            parent.find(".select-district").append(string);
        }

        function checkCompany(){
            $.ajax({
                url: '{{ route('api.companies.check') }}/' + $('#select-company').val(),
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    if(response.data){
                        submitForm('post');
                    }
                    else {
                        $('#modal-company').modal("show");
                        $('#company').val($('#select-company').val());
                        $('#city').val($('#select-city').val()).trigger('change');
                    }
                },
                error: function(response){

                }
            });
        }

        function showError(errors){
            let string = '<ul>';
            if(Array.isArray(errors)) {
                errors.forEach(function(each){
                    each.forEach(function(error){
                        string += `<li>${error}</li>`;
                    });
                });
            }
            else {
                string += `<li>${errors}</li>`;
            }
            string += '</ul>';
            $("#div-error").html(string);
            $('#div-error').removeClass("d-none").show();
            notifyError(string);
        }

        function submitForm(type){
            const object = $('#form-create-'+type)
            const formData = new FormData(object[0]);
            $.ajax({
                url: object.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                enctype: 'multipart/form-data',
                success: function(response){
                    if(response.success) {
                        $("#div-error").hide();
                        $("#modal-company").modal("hide");
                        notifySuccess();
{{--                        window.location.href = '{{ route('admin.posts.index') }}';--}}
                    }
                    else {
                        showError(response.message);
                    }
                },
                error: function(response){
                    let errors;
                    if(response.responseJSON.errors) {
                        errors = Object.values(response.responseJSON.errors);
                        showError(errors);
                    }
                    else {
                        errors = response.responseJSON.message;
                        showError(errors);
                    }
                }
            });
        }
        $(document).ready(async function() {
            $('#text-requirement').summernote();
            $("#select-city").select2({tags: true});
            $("#city").select2({tags: true});
            const response = await fetch('{{ asset('locations/index.json') }}')
            const cities = await response.json();
            $.each(cities, function(index,each){
               $('#select-city').append(`
                    <option data-path='${each.file_path}'>
                    ${index}
                    </option>`)
               $('#city').append(`
                    <option data-path='${each.file_path}'>
                    ${index}
                    </option>`)
            })
            $("#select-city, #city").change(function () {
                loadDistrict($(this).parents('.select-location'));
            })
            $('#select-district').select2({tags: true});
            $('#district').select2({tags: true});
            await loadDistrict($('#select-city').parents('.select-location'));
            $("#select-company").select2({
              tags: true,
                ajax: {
                    url: '{{ route('api.companies') }}',
                    data: function (params) {
                        var queryParameters = {
                            q: params.term
                        }

                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.name
                                }
                            })
                        };
                    },
                }
            });
            $("#select-language").select2({
                ajax: {
                    url: '{{ route('api.languages') }}',
                    data: function (params) {
                        var queryParameters = {
                            q: params.term
                        };

                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
            $(document).on('change', '#select-company, #select-city, #select-language', function() {
                generateTitle();
            })
            $('#slug').change(function() {
                $('#btn-submit').attr('disabled', true);
                $.ajax({
                    url: '{{ route('api.posts.slug.check') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: { slug: $(this).val() },
                    success: function(response){
                        if(response.success) {
                            $('#btn-submit').attr('disabled', false);
                        }
                    },
                    error: function(response){

                    }
                });
            })

            $("#form-create-post").validate({
                rules: {
                    company: "required",
                },
                submitHandler: function() {
                    checkCompany();
                }
            });
        });
    </script>
@endpush

