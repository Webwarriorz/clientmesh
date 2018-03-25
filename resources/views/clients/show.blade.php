@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1 class="mb-4">Clients list</h1>

                <div class="card text-white bg-dark mb-5">
                    <div class="card-header">Filter by alphabetical</div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($alphabetical as $character => $clients)

                                @if($filterByStartLetter == $character)
                                    <div class="col-6 col-sm-3 col-md-2 col-lg-1 pb-2 text-center selected-character">
                                        {{$character}}
                                    </div>
                                @else
                                    <div class="col-6 col-sm-3 col-md-2 col-lg-1 pb-2 text-center">
                                        <a href="/clients?alphabetical={{$character}}">{{$character}}</a>
                                    </div>
                                @endif

                            @endforeach
                            <div class="col-6 col-sm-3 col-md-2 col-lg-1 pb-2 text-center">
                                <a href="/clients">Clear filter</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card text-white bg-dark mb-5">
                    <div class="card-header">Filter by expression</div>
                    <div class="card-body">
                        <input type="text" name="search" id="search" class="form-control"/>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-dark table-hover" id="clients">

                        <thead>
                        <tr>
                            <th scope="col" class="text-uppercase">id</th>
                            <th scope="col" class="text-uppercase">name</th>
                            <th scope="col" class="text-uppercase">url</th>
                            <th scope="col" class="text-uppercase">logo</th>
                            <th scope="col" class="text-uppercase">address</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($clientsGrouped as $character => $clients)
                            <tr class="character" data-character="{{$character}}">
                                <th colspan="{{count($columnsHeader)}}">
                                    {{$character}}
                                    <span class="badge badge-secondary" data-character-counter-id="{{$character}}">{{count($clients)}}</span>
                                </th>
                            </tr>
                            @foreach($clients as $client)
                                <tr data-parent-character="{{$character}}" data-hide='true'>
                                    <td>{{$client->id}}</td>
                                    <td data-type="name">{{$client->name}}</td>
                                    <td><a href="{{$client->url}}" target="_blank">{{$client->url}}</a></td>
                                    <td>
                                        <img src="{{$client->logo}}" class="logo-thumbnail" alt="{{$client->name}}">
                                    </td>
                                    <td data-type="address">
                                        <div>{{$client->street}}</div>
                                        <div>{{$client->city}} {{$client->postcode}}</div>
                                        <div>{{$client->country}}</div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection