@extends('Workshop.layouts.master')
@section('content')

<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1>Complete Work Order</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
               <div class="iq-card">
                  <div class="iq-card-header d-flex justify-content-between">
                     <div class="iq-header-title">
                        <h4 class="card-title">Vertical Wizard</h4>
                     </div>
                  </div>
                  <div class="iq-card-body">
                     <div class="row">
                        <div class="col-md-3">
                           <ul id="top-tabbar-vertical" class="p-0">
                              <li class="active" id="personal">
                                 <a href="javascript:void();">
                                    <i class="ri-pencil-ruler-line text-primary"></i><span>Tools</span>
                                 </a>
                              </li>
                              <li id="contact">
                                 <a href="javascript:void();">
                                    <i class="ri-delete-bin-fill text-danger"></i><span>Scrap</span>
                                 </a>
                              </li>
                           </ul>
                        </div>
                        <div class="col-md-9">
                              <form id="form-wizard3" class="text-center" method="POST" action="{{ route('workshop.work-order.completed', $workOrder->id) }}">
                                @csrf
                              <!-- fieldsets -->
                              <fieldset>
                                <div class="form-card text-left">
                                    <div class="row">
                                        <div class="col-12">
                                            <h3 class="mb-4">Tool Requested :</h3>
                                        </div>
                                    </div> 
                                    {{-- {{ dd($workOrder->tools) }} --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <p>Please make sure all tools requested is not missing/broken before completing this work order. If there is some tool missing, please report it on <code>Tool Usage</code> menu.</p>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Tool Name</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">Qty</label>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($workOrder->tools)
                                        @php
                                            $toolMissing =null;
                                            if ($workOrder->tools->missings) {
                                                
                                                $toolMissing = $workOrder->tools->missings->map(function($item){
                                                    return $item->details->mapWithKeys(function($i){ return ['tools_id'=>$i->tools_id, 'qty' =>$i->qty]; })->toArray();
                                                })->groupBy('tools_id')->map(function($item){
                                                    return $item->sum('qty');
                                                });
                                                
                                            }
                                        @endphp
                                        @foreach ($workOrder->tools->details as $item)
                                        @php
                                        // dd($toolMissing);
                                            $qty = isset($toolMissing) && isset($toolMissing[$item->tools_id]) ? abs($toolMissing[$item->tools_id] - $item->qty) : $item->qty;
                                        @endphp
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <input type="hidden" name="tools_id[]" value="{{ $item->tools_id }}" >
                                                        <input type="text" class="form-control" value="{{ $item->tools->name }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="{{ $qty }}" name="tools_qty[]" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" name="next" class="btn btn-primary next action-button float-right" value="Next" >Next</button>
                              </fieldset>
                              <fieldset>
                                <div class="form-card text-left">
                                    <div class="row">
                                        <div class="col-12">
                                            <h3 class="mb-4">Scrap Management:</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="">Part Name</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="">Part Number</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="">Weight</label>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($workOrder->work_request->part_order)
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($workOrder->work_request->part_order as $item)
                                            @foreach (range(1,$item->qty) as $scrap)
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <input type="hidden" name="part_id[]" value="{{ $item->part_id }}">
                                                            <input type="text" class="form-control" value="{{ $item->sparepart->part_name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="{{ $item->sparepart->part_number }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <input type="number" class="form-control" name="part_weight[]" min="1" placeholder="Weight (kg)" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="checkbox d-inline-block mr-2">
                                                            <input type="checkbox" class="checkbox-input" name="flag_warehouse[]" value="{{ $i }}" >
                                                            <label >Transfer to warehouse</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @endforeach
                                    @endif
                                </div> 
                                <button type="submit" class="btn btn-primary float-right" value="Next" >Submit</button> 
                                <button type="button" name="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous" >Previous</button>
                              </fieldset>
                           </form>
                        </div>
                     </div>
               </div>
               </div>
            </div> 
         </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function(){

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#top-tabbar-vertical li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                'display': 'none',
                'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function(){

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#top-tabbar-vertical li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
        step: function(now) {
        // for making fielset appear animation
        opacity = 1 - now;

        current_fs.css({
        'display': 'none',
        'position': 'relative'
        });
        previous_fs.css({'opacity': opacity});
        },
        duration: 500
        });
        setProgressBar(--current);
        });

        function setProgressBar(curStep){
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
        .css("width",percent+"%")
        }

        $(".submit").click(function(){
        return false;
        })

        });
</script>
@endsection