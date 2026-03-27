@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="iq-card overflow-hidden">
                    <div class="iq-card-body pb-0">
                        <div class="rounded-circle iq-card-icon iq-bg-primary"><i class="ri-exchange-dollar-fill"></i></div>
                        <span class="float-right line-height-6">This Month Purchasing Request</span>
                        <div class="clearfix"></div>
                        <div class="text-center">
                            <h2 class="mb-0"><span class="counter">65</span><span>M</span></h2>
                            <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">10%</span> Increased</p>
                        </div>
                    </div>
                    <div id="chart-1"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="iq-card overflow-hidden">
                    <div class="iq-card-body pb-0">
                        <div class="rounded-circle iq-card-icon iq-bg-warning"><i class="ri-bar-chart-grouped-line"></i></div>
                        <span class="float-right line-height-6">This Month Purchasing Order</span>
                        <div class="clearfix"></div>
                        <div class="text-center">
                            <h2 class="mb-0"><span>$</span><span class="counter">4500</span></h2>
                            <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">20%</span> Increased</p>
                        </div>
                    </div>
                    <div id="chart-2"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="iq-card overflow-hidden">
                    <div class="iq-card-body pb-0">
                        <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-group-line"></i></div>
                        <span class="float-right line-height-6">This Month Receiving</span>
                        <div class="clearfix"></div>
                        <div class="text-center">
                            <h2 class="mb-0"><span class="counter">96.6</span><span>K</span></h2>
                            <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">30%</span> Increased</p>
                        </div>
                    </div>
                    <div id="chart-3"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="iq-card overflow-hidden">
                    <div class="iq-card-body pb-0">
                        <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-shopping-cart-line"></i></div>
                        <span class="float-right line-height-6">This Month Issued</span>
                        <div class="clearfix"></div>
                        <div class="text-center">
                            <h2 class="mb-0"><span class="counter">15.5</span><span>K</span></h2>
                            <p class="mb-0 text-secondary line-height"><i class="ri-arrow-down-line text-danger mr-1"></i><span class="text-danger">10%</span> Increased</p>
                        </div>
                    </div>
                    <div id="chart-4"></div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="iq-card overflow-hidden">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Monthly sales trend </h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="#" class="nav-link active">Latest</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">All Time</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="d-flex justify-content-around">
                            <div class="price-week-box mr-5">
                                <span>Current Week</span>
                                <h2>$<span class="counter">180</span> <i class="ri-funds-line text-success font-size-18"></i></h2>
                            </div>
                            <div class="price-week-box">
                                <span>Previous Week</span>
                                <h2>$<span class="counter">52.55</span><i class="ri-funds-line text-danger font-size-18"></i></h2>
                            </div>
                        </div>
                    </div>
                    <div id="chart-5"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="iq-card animation-card">
                    <div class="iq-card-body p-0">
                        <div class="an-text">
                            <span>Quarterly Target </span>
                            <h2 class="display-4 font-weight-bold">$<span>2M</span></h2>
                        </div>
                        <div class="an-img">
                            <div class="bodymovin" data-bm-path={{asset('assets/images/small/data.json')}} data-bm-renderer="svg" data-bm-loop="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
