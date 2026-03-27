@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row" style="text-align: center">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <h1>Settings</h1>
            </div>
            <div class="col-sm-2"></div>
        </div>
        <form action="{{ route('workshop.master-data.settings.store') }}" method="POST">
            @csrf
            <div class="row" style="text-align: center">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            @foreach ($setting_items as $key => $item )
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">{{ ucwords(str_replace('_', ' ' ,$key)) }}</label>
                                            @if ($item['type'] == \App\Repository\Workshop\SettingRepository::TYPE_SELECT ||$item['type'] == \App\Repository\Workshop\SettingRepository::TYPE_MULTIPLE_SELECT)
                                                {!! \App\Repository\Workshop\SettingRepository::buildSelectElement($item['type'], $key, $data[$item['source']], $item['value'] ) !!}
                                            @endif
                                        </div>
                                    </div>                
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12" style="text-align: right">
                                    <button type="submit" class="btn btn-success">Submit Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </form>
        
    </div>
</div>
<script>
    $(document).ready(function(){
        $('select').select2();
    })
</script>
@endsection()