@extends('layouts.admin')

@section('content')
@include('partials.flash-message')

<div class="card">
  <div class="card-header">
    <div class="card-header">
      {{ trans('cruds.boost.title_singular') }} {{ trans('global.list') }}
    </div>
  </div>
  <div class="card-body">
      @csrf
      <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover datatable ajaxTable datatable-Boost">
              <thead>
                  <tr>
                      <th width="10">
  
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.id') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.requester_name') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.company_name') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.program_name') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.channel') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.group') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.target_url') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.boost_start') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.detail') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.budget') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.reference') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.created_at') }}
                      </th>
                      <th>
                          {{ trans('cruds.boost.fields.actual_cost') }}
                    </th>
                    <th>
                          {{ trans('cruds.boost.fields.status') }}
                      </th>
                      <th>
                          Edit
                      </th>
                  </tr>
              </thead>
          </table>
      </div>
  </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function() {
      let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
      let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
      let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
      let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
      let printButtonTrans = '{{ trans('global.datatables.print') }}'
      let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
      let selectAllButtonTrans = '{{ trans('global.select_all') }}'
      let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

      let languages = {
        'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
      };

      $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
      $.extend(true, $.fn.dataTable.defaults, {
        language: {
          url: languages['{{ app()->getLocale() }}']
        },
        columnDefs: [ 
        {
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }, 
        {
            orderable: false,
            searchable: false,
            targets: -1
        },
        {
            targets: [ 2, 3, 4, 9 ],
            visible: false
        },],
        select: {
          style:    'multi+shift',
          selector: 'td:first-child'
        },
        autoWidth: false,
        order: [],
        scrollX: true,
        pageLength: 100,
        dom: 'Bfrtip<"actions">',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
          'pageLength',
          {
            extend: 'selectAll',
            className: 'btn-primary',
            text: selectAllButtonTrans,
            exportOptions: {
              columns: ':visible'
            },
            action: function(e, dt) {
              e.preventDefault()
              dt.rows().deselect();
              dt.rows({ search: 'applied' }).select();
            }
          },
          {
            extend: 'selectNone',
            className: 'btn-primary',
            text: selectNoneButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'copy',
            className: 'btn-default',
            text: copyButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'csv',
            className: 'btn-default',
            text: csvButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excel',
            className: 'btn-default',
            text: excelButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            className: 'btn-default',
            text: pdfButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'print',
            className: 'btn-default',
            text: printButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'colvis',
            className: 'btn-default',
            text: colvisButtonTrans,
            exportOptions: {
              columns: ':visible'
            }
          }
        ]
      });

      $.fn.dataTable.ext.classes.sPageButton = '';
    });

</script>
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('user_alert_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
        let _token= $('input[name="_token"]').val();
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.boosts.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                return entry.id
            });

            if (ids.length === 0) {
                alert('{{ trans('global.datatables.zero_selected') }}')

                return
            }

            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({
                headers: {'x-csrf-token': _token},
                method: 'POST',
                url: config.url,
                data: { ids: ids, _method: 'DELETE' }})
                .done(function () { table.ajax.reload(); })
            }
            }
        }
        dtButtons.push(deleteButton)
    @endcan

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.productions.index') }}",
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'requester_name', name: 'requester_name' },
            { data: 'company_name', name: 'company_name' },
            { data: 'program_name', name: 'program_name' },
            { data: 'channel', name: 'channel.title' },
            { data: 'group', name: 'group' },
            { data: 'target_url', name: 'target_url' },
            { data: 'boost_start', name: 'boost_start' },
            { data: 'detail', name: 'detail' },
            { data: 'budget', name: 'budget' },
            { data: 'reference', name: 'reference', sortable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'actual_cost', name: 'actual_cost' },
            { data: 'actions', name: '{{ trans('global.actions') }}' },
            { data: 'edit', name: 'edit' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 25,
        autoWidth: false,
        scrollX: true
    };
    let table = $('.datatable-Boost').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();
    });

    run = (id, st) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/admin/productions/update/" + id,
            data: {
                _token: _token,
                st: st,
                id: id
            },
            beforeSend: () => {
                $('#btn-run'+id).attr('disabled', 'true');
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire(
                        'Running now',
                        'The request has been run.',
                        'success'
                    ).then(
                        $('.datatable-Boost').DataTable().ajax.reload()
                    );
                }
                if(response == 'Opss') {
                    Swal.fire(
                        response,
                        'Something on occure',
                        'error'
                    );
                    $('#btn-run'+id).removeAttr('disabled');
                }
            }
        });
    }

    done = (id, st) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/admin/productions/update/" + id,
            data: {
                _token: _token,
                st: st,
                id: id
            },
            beforeSend: () => {
                $('#btn-done'+id).attr('disabled', 'true');
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire(
                        'Done',
                        'Boost has been completed.',
                        'success'
                    ).then(
                        $('.datatable-Boost').DataTable().ajax.reload()
                    );
                }
                if(response == 'Opss') {
                    Swal.fire(
                        response,
                        'Something on occure',
                        'error'
                    );
                    $('#btn-done'+id).removeAttr('disabled');
                }
            }
        });
    }

    edit = (id, st) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/admin/productions/update/" + id,
            data: {
                _token: _token,
                st: st,
                id: id
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire(
                        'Good!',
                        'Boost has been updated.',
                        'success'
                    ).then(
                        $('.datatable-Boost').DataTable().ajax.reload()
                    );
                }
                if(response == 'Opss') {
                    Swal.fire(
                        response,
                        'Something on occure',
                        'error'
                    );
                }
            }
        });
    }
  
});

</script>

@endsection