@extends('layouts.admin')

@section('content')

    <div class="flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed text-white" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse">
                    Categories
                </button>
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-body-emphasis d-inline-flex text-white text-decoration-none rounded">Create</a></li>
                        <li><a href="#" class="link-body-emphasis d-inline-flex text-white text-decoration-none rounded">All Categories</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
@endsection



<?php

