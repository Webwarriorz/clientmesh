@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h1 class="mb-4">Upload a new client list</h1>

                <div class="alert alert-danger mb-4" role="alert">
                    Be careful, if you submit a new file, all client data will be overwritten!
                </div>

                <div>
                    <p>Please select the valid CSV file in the form below.</p>
                    <p>The CSV file must be contained for this fields:</p>
                    <ul>
                        <li>Name</li>
                        <li>URL</li>
                        <li>Logo</li>
                        <li>Street</li>
                        <li>City</li>
                        <li>Suburb</li>
                        <li>Postcode</li>
                        <li>Country</li>
                    </ul>
                </div>

                @include('partial.errors')

                <form method="post" action="/clients" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="input-group mb-4">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile" name="clients_list" required="required">
                            <label class="custom-file-label" for="inputGroupFile">Choose CSV file</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection