@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'customer_ledger'
])
@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-md-24">
                @include('common.messages')
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-16">
                                <h2 class="mb-0">{{ $other->title }}</h2>
                            </div>
                            <div class="col-8 text-right">
                                <a href="{{ $other->back_link }}" class="btn btn-large btn-primary btn-group-link">Back</a>
                                @if(isset($other->add_link_route) && \Helper::userHasPageAccess($other->add_link_route))
                                    <a href="{{ $other->add_link }}" class="btn btn-large btn-success btn-group-link">Add</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            <table id="group_table" class="table datatable table-condensed">
                                <thead>
                                    @if ($tableHeader)
                                        <tr>
                                            <th></th>
                                            @foreach($tableHeader as $key => $item)
                                                <th>{!! $item !!}</th>
                                            @endforeach
                                        </tr>
                                    @endif
                                </thead>
                                <tbody>
                                @if(isset($tablerow) && count($tablerow) > 0)
                                    @foreach($tablerow as $key => $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->ledger_name }}</td>
                                            <td>{{ $item->group->group_name }}</td>
                                            {{-- <td>{{ isset($item->territory) ? $item->territory->terretory_name : 'All' }}</td> --}}
                                            <td>{{ isset($item->gstin_uin) ? $item->gstin_uin : '' }}</td>
                                            <td>{{ isset($partyType[$item->party_type]) ? $partyType[$item->party_type] : ''}}</td>
                                            <td class="action--cell">
                                                <ul class="action--links">
                                                    @if(\Helper::userHasPageAccess($other->edit_link))
                                                        <li>
                                                            <a href="{{ route($other->edit_link, $item->id) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                @if(\Helper::userHasPageAccess($other->edit_link))
                                                    {!! Form::open(['url' => route($other->update_link, $item->id), 'method' => 'DELETE']) !!}
                                                        <button type="submit" class="btn btn-danger confirm-action"><i class="fas fa-trash"></i></button>
                                                    {!! Form::close(); !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" align="center">{!! __('messages.notfound', ['name' => $other->title]) !!}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
