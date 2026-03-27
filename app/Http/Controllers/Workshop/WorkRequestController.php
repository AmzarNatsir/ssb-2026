<?php

namespace App\Http\Controllers\Workshop;

use App\Exports\WorkRequestExport;
use App\Http\Controllers\Controller;
use App\Models\HRD\KaryawanModel;
use App\Models\Workshop\Equipment;
use App\Models\Workshop\Location;
use App\Models\Workshop\MasterData\AdditionalAttributes;
use App\Models\Workshop\MasterData\Media;
use App\Models\Workshop\MasterData\Schedule;
use App\Models\Workshop\MasterData\WorkshopPartOrder;
use App\Models\Workshop\WorkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class WorkRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $work_requests = (new WorkRequest())->with(['equipment', 'location', 'additional_attributes', 'schedule', 'approved'])->search($request);
        // $equipments = Equipment::all();
        $page = $request->has('page') ? $request->page : 0;
        $work_requests = $work_requests->latest('id')->paginate(WorkRequest::PAGE_LIMIT);

        return view('Workshop.work-request.index', [
            'work_requests' => $work_requests,
            // 'equipments' => $equipments,
            'page' => $page,
            'limit' => $work_requests->firstItem()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers = KaryawanModel::where('id_jabatan', workshop_settings('driver_position'))->get();
        $locations = Location::all();
        $equipments = Equipment::all();

        return view('Workshop.work-request.add-edit', [
            'drivers' => $drivers,
            'locations' => $locations,
            'equipments' => $equipments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $work_request = new WorkRequest();
        $work_request->fill($request->all());

        if ($work_request->save()) {
            if ($request->exists('part_id')) {
                foreach ($request->part_id as $key => $value) {
                    $part_order = new WorkshopPartOrder();
                    $part_order->part_id = $value;
                    $part_order->qty = $request->part_qty[$key];
                    $part_order->description = $request->part_description[$key];

                    $work_request->part_order()->save($part_order);
                }
            }

            if ($request->exists('instruction_name')) {
                foreach ($request->instruction_name as $key => $value) {
                    $instruction = new AdditionalAttributes();
                    $instruction->name = 'work_request';
                    $instruction->value = $value;
                    $instruction->description = $request->instruction_description[$key];

                    $work_request->additional_attributes()->save($instruction);
                }
            }

            if ($request->exists('picture')) {
                foreach ($request->file('picture') as $key => $value) {
                    $media = new Media();
                    $media->file = do_upload('work_request', $value);

                    $work_request->media()->save($media);
                }
            }

            return redirect()->route('workshop.work-request.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $work_request = WorkRequest::with(['part_order.sparepart', 'additional_attributes', 'media'])->findOrFail($id);
        $locations = Location::all();
        $drivers = KaryawanModel::where('id_jabatan', workshop_settings('driver_position'))->get();
        $equipments = Equipment::all();

        return view('Workshop.work-request.add-edit', [
            'drivers' => $drivers,
            'locations' => $locations,
            'equipments' => $equipments,
            'work_request' => $work_request
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $work_request = WorkRequest::findOrFail($id);
        $work_request->fill($request->all());

        if ($work_request->save()) {
            if ($request->exists('part_id')) {
                $work_request->part_order()->delete();
                foreach ($request->part_id as $key => $value) {
                    $part_order = new WorkshopPartOrder();
                    $part_order->part_id = $value;
                    $part_order->qty = $request->part_qty[$key];
                    $part_order->description = $request->part_description[$key];

                    $work_request->part_order()->save($part_order);
                }
            }

            if ($request->exists('instruction_name')) {
                $work_request->additional_attributes()->delete();
                foreach ($request->instruction_name as $key => $value) {
                    $instruction = new AdditionalAttributes();
                    $instruction->name = 'work_request';
                    $instruction->value = $value;
                    $instruction->description = $request->instruction_description[$key];

                    $work_request->additional_attributes()->save($instruction);
                }
            }

            if ($request->exists('picture')) {
                foreach ($request->file('picture') as $key => $value) {
                    $media = new Media();
                    $media->file = do_upload('work_request', $value);

                    $work_request->media()->save($media);
                }
            }

            return redirect()->route('workshop.work-request.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $workRequest = WorkRequest::findOrFail($id);
        if (!$workRequest->work_order) {
            $workRequest->delete();
            return redirect()->route('workshop.work-request.index');
        }
    }

    public function schedule($id)
    {
        $schedules = Schedule::all(); // TODO:: only get last 1 , current, and next 1 month
        $work_request = WorkRequest::findOrFail($id);

        $calendar =\Calendar::addEvents($schedules);
        $calendar->setOptions([
            'locale' => 'en',
            'firstDay' => 0,
            'validRange' => ['start' => date('Y-m-d')],
            'displayEventTime' => true,
            'selectable' => true,
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
            ],
            'customButtons' => [
                'myCustomButton' => [
                    'text' => 'custom!',
                    'click' => 'function() {
                        alert(\'clicked the custom button!\');
                    }'
                ]
            ]
        ]);
        $calendar->setId('1');
        $calendar->setCallbacks([
            'select' => 'function(selectionInfo){}',
            'eventClick' => 'function(event){}',
            'dayClick' => 'function(date, jsEvent, view){
                console.log(date, jsEvent, view)
                let c = confirm(\'Are you sure to schedule ' . $work_request->number . ' on \'+ date.format()+\'?\');
                if(c){
                    $.post(\'' . route('workshop.work-request.set-schedule', $work_request->id) . '\',{_token:\'' . csrf_token() . '\',date:date.format()}).done(function(data){
                        if (data.status == \'success\'){
                            window.location.href = \'' . route('workshop.work-request.index') . '\';
                        }
                    });
                }
                console.log(c);
            }'
        ]);

        // dd($calendar->script());

        return view('Workshop.work-request.schedule', compact('calendar'));
    }

    public function setSchedule(Request $request, $id)
    {
        $loggedInUser = auth()->user()->id;
        $work_request = WorkRequest::findOrFail($id);
        $work_request->approved_by = $loggedInUser;
        $work_request->approved_at = \Carbon\Carbon::now();

        if ($work_request->save()) {
            $work_request->schedule()->delete();
            $schedule = new Schedule();
            $schedule->date = \Carbon\Carbon::parse($request->date);
            $work_request->schedule()->save($schedule);

            return response()->json(['status' => 'success']);
        }
    }

    public function download(Request $request)
    {
        return Excel::download(new WorkRequestExport($request), 'work_request_' . time() . '.xls');
    }

    public function print($id)
    {
        $workRequest = WorkRequest::query()
            ->with(['equipment', 'location', 'additional_attributes', 'schedule'])
            ->findOrFail($id);
        $pdf = PDF::loadView('Workshop.work-request.print', compact('workRequest'),);
        return $pdf->stream();
        return view('Workshop.work-request.print', compact('workRequest'));
    }

    public function deleteImage(Request $request)
    {
        $image = Media::findOrFail($request->id);
        $image->delete();

        return ['status' => 'ok'];
    }
}
