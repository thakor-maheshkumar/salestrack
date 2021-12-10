@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'companies'
])

@section('content')
	<!-- Start: main-content -->
	<div class="content main-content--wrapper">
        <div class="row">
            <div class="col-md-24">
                <div class="card main-content--subblock">
                    <div class="card-header">
                        <div class="main-content--head row justify-content-between">
                            <div class="col-md-auto">
                                <h3 class="card-title">All Companies</h3>
                            </div>
                            <div class="col-md-auto">
                                @if(\Helper::userHasPageAccess('companies.create'))
                                    <a href="{{ route('companies.create') }}" class="btn btn-success btn-large">Add Company</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper table-responsive">
                            @include('common.messages')
                            @if(isset($companies) && count($companies) > 0)
                                <table id="example1" class="table datatable table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Company Name</th>
                                            <th>firm_type</th>
                                            <th>pan_no</th>
                                            <th>gst_no</th>
                                            <th>dl_no</th>
                                            <th>fssai</th>
                                            <th>reg_type</th>
                                            <th>aadhar_no</th>
                                            <th>address</th>
                                            <th>address_1</th>
                                            <th>landmark</th>
                                            <th>city</th>
                                            <th>state</th>
                                            <th>country_id</th>
                                            <th>zipcode</th>
                                            <th>phone</th>
                                            <th>phone_1</th>
                                            <th>phone_2</th>
                                            <th>phone_3</th>
                                            <th>fax</th>
                                            <th>email</th>
                                            <th>email_1</th>
                                            <th>website</th>
                                            <th>gst_date</th>
                                            <th>dl_date</th>
                                            <th>pan_date</th>
                                            <th>fssai_date</th>
                                            <th>iec_code</th>
                                            <th>iec_applicable_date</th>
                                            <th>tan_no</th>
                                            <th>tan_date</th>
                                            <th>cin_no</th>
                                            <th>fiscal_start_date</th>
                                            <th>fiscal_end_date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($companies as $key => $company)
                                            <tr>
                                                <td>{{ $company->id }}</td>
                                                <td>{{ $company->name }}</td>
                                                <td>{{ $company->firm_type }}</td>
                                                <td>{{ $company->pan_no }}</td>
                                                <td>{{ $company->gst_no }}</td>
                                                <td>{{ $company->dl_no }}</td>
                                                <td>{{ $company->fssai }}</td>
                                                <td>{{ $company->reg_type }}</td>
                                                <td>{{ $company->aadhar_no }}</td>
                                                <td>{{ $company->address }}</td>
                                                <td>{{ $company->address_1 }}</td>
                                                <td>{{ $company->landmark }}</td>
                                                <td>{{ $company->city }}</td>
                                                <td>{{ $company->state }}</td>
                                                <td>{{ $company->country_id }}</td>
                                                <td>{{ $company->zipcode }}</td>
                                                <td>{{ $company->phone }}</td>
                                                <td>{{ $company->phone_1 }}</td>
                                                <td>{{ $company->phone_2 }}</td>
                                                <td>{{ $company->phone_3 }}</td>
                                                <td>{{ $company->fax }}</td>
                                                <td>{{ $company->email }}</td>
                                                <td>{{ $company->email_1 }}</td>
                                                <td>{{ $company->website }}</td>
                                                <td>{{ $company->gst_date }}</td>
                                                <td>{{ $company->dl_date }}</td>
                                                <td>{{ $company->pan_date }}</td>
                                                <td>{{ $company->fssai_date }}</td>
                                                <td>{{ $company->iec_code }}</td>
                                                <td>{{ $company->iec_applicable_date }}</td>
                                                <td>{{ $company->tan_no }}</td>
                                                <td>{{ $company->tan_date }}</td>
                                                <td>{{ $company->cin_no }}</td>
                                                <td>{{ $company->fiscal_start_date }}</td>
                                                <td>{{ $company->fiscal_end_date }}</td>
                                                <td class="action--cell">
                                                    <ul class="action--links">
                                                        <li class="{{ (\Helper::userHasPageAccess('companies.edit')) ? '' : 'not-access' }}">
                                                            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-gray"><i class="fas fa-edit"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>Company not found.</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
    <!-- End: main-content -->
@endsection
