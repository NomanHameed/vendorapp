@extends('layouts.app')
@section('content')
    <main id="order-wrapper">
        @if(\App\AppHelper::innerSheetExist('orders',$request['store_id']))
            <section class="mb-4">
                @include('orders.update-sheet')
            </section>
            <section class="mb-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 pt-3">
                            <h5>Column Settings</h5>
                            <p class="text-muted">Sort sheet columns according to needs</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-3">Available Columns</h6>
                                    <form method="POST"
                                          action="{{ route('orders-sync-active-fields',['store_id'=>$request['store_id']]) }}"
                                          accept-charset="UTF-8"
                                          id="activeFieldForm"
                                          @submit.prevent="syncActiveFields()">
                                        @csrf
                                        @include('orders.active-fields')
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-xs btn-info" id="activeFieldBtn">
                                                Save <i class="fa fa-save fs-12px"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="mb-4">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="jumbotron">
                                <h1>Alert</h1>
                                <p>No Google sheet exists,First connect with Google Sheet</p>
                                <a @click.prevent="requestForGoogleSheetConnection();"
                                   id="googleSheetRequestSender"
                                   href="{{ route('google-sheet-request',['store_id'=>$request['store_id']]) }}"
                                   class="btn btn-light border px-4 py-2 connectToSheet">
                                    Re Connect <i class="fas fa-sync-alt fs-12px" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
