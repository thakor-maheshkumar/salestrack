@extends('layouts.admin.master', [
    'class' => '',
    'elementActive' => 'supplier_groups'
])

@section('content')
    <!-- Start: main-content -->
    <div class="content main-content--warppar">
        <div class="row">
            <div class="col-sm-24">
                <div class="card card-primary main-content--subblock">
                    <div class="card-header">
                        <h3 class="card-title">Create Group</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['url' => route('supplier-groups.store'), 'id' => 'create_group']) !!}
                            @include('admin.supplier-group.form')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End: main-content -->
@endsection
@section('script')
<script type="text/javascript">
    $(document).on("change", ':radio[name="under"]', function(){
        var type = $(this).val();

        $.ajax({
            url: config.routes.url + '/admin/masters/supplier-groups/get-groups-type/' + type,
            type: 'GET',
            success:function(response) {

                var _select = $("<select />", {
                    'class': 'form-control',
                    'id': 'group_type',
                    'name': 'group_type',
                });

                if (response.success)
                {
                    var text = '';

                    if (type == 1)
                    {
                        var _label = $("<label />", {
                            'for': 'group_type'
                        }).text('Primary Group');

                        $.each(response.data, function(index, el) {
                            $('<option/>', {
                                'value': index,
                                'text': el
                            }).appendTo(_select);
                        });

                        $(".select-group-wrapper").html(_label.add(_select));
                    }
                    else
                    {
                        var _label = $("<label />", {
                            'for': 'group_type'
                        }).text('Sub Group');

                        $.each(response.data, function(index, el) {
                            $('<option/>', {
                                'value': index,
                                'text': el
                            }).appendTo(_select);
                        });

                        $(".select-group-wrapper").html(_label.add(_select));
                    }
                }
            },
            error: function(error) {
                console.log(error);
            }
        })
    });
</script>
@endsection
