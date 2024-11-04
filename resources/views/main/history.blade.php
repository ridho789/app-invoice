@extends('layouts.base')
<!-- @section('title', 'Histories') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12" id="table-ships" style="display: block;">
            <div class="card mb-4">
                <div class="card-header pb-5">
                    <h6>List Histories</h6>
                    <p class="text-sm mb-0">
                        View all list of update histories in the system.
                    </p>
                </div>
                @if (count($historyData) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Scope</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Updated</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Older Data</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Changed Data</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Revcount</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($historyData as $h)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }} </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">{{ $user[$h['user_id']] }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm text-uppercase">
                                        @if($h['id_changed_data'])
                                            <a href="{{ url('sea_shipment-edit', ['id' => Crypt::encrypt($h['id_changed_data'])]) }}" target="_blank">
                                                <p class="text-sm font-weight-normal mb-0 text-info">{{ $h['scope'] }}</p>
                                            </a>
                                        @else
                                            <p class="text-sm font-weight-normal mb-0">{{ $h['scope'] }}</p>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm text-uppercase">
                                        <p class="text-sm font-weight-normal mb-0">{{ $h['updated_time'] }}</p>
                                    </td>
                                    <td class="align-middle text-sm">
                                        @php
                                            $olderData = $h['older_data'];
                                            $pattern = '/{(.*?)}/';
                                            preg_match_all($pattern, $olderData, $olders);
                                        @endphp
                                        @foreach ($olders[1] as $older)
                                            <p class="text-sm font-weight-normal mb-2" 
                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 550px;">{{ $older }}
                                            </p>
                                        @endforeach
                                    </td>
                                    <td class="align-middle text-sm">
                                        @php
                                            $changedData = $h['changed_data'];
                                            $pattern = '/{(.*?)}/';
                                            preg_match_all($pattern, $changedData, $changeds);
                                        @endphp
                                        @foreach ($changeds[1] as $changed)
                                            <p class="text-sm font-weight-normal mb-2" 
                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 550px;">{{ $changed }}
                                            </p>
                                        @endforeach
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $h['revcount'] }}</p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card-body px-0 pt-0 pb-0">
                    <div class="d-flex justify-content-center mb-3">
                        <span class="text-xs mb-3"><i>No available data to display..</i></span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection