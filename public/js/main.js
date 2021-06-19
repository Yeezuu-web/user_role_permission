$(document).ready(function () {
    window._token = $('meta[name="csrf-token"]').attr('content')
  
    moment.updateLocale('en', {
      week: {dow: 1} // Monday is the first day of the week
    })
  
    $('.date').datetimepicker({
      format: 'DD-MM-YYYY',
      locale: 'en',
      icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
      }
    })
  
    $('.datetime').datetimepicker({
      format: 'DD-MM-YYYY HH:mm:ss',
      locale: 'en',
      sideBySide: true,
      icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
      }
    })
  
    $('.timepicker').datetimepicker({
      format: 'HH:mm:ss',
      icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
      }
    })

    $('.yearpicker').datetimepicker({
      format: 'YYYY',
      viewMode: 'years',
      icons: {
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
      }
    })

    //Date range picker
    $('.daterang').daterangepicker({
      locale: {
        format: 'DD-MM-YYYY'
      }
    })

    $('.daterangtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'DD-MM-YYYY hh:mm A'
      }
    })

    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
  
    $('.select-all').click(function () {
      let $select2 = $(this).parent().siblings('.select2')
      $select2.find('option').prop('selected', 'selected')
      $select2.trigger('change')
    })
    $('.deselect-all').click(function () {
      let $select2 = $(this).parent().siblings('.select2')
      $select2.find('option').prop('selected', '')
      $select2.trigger('change')
    })
  
    $('.select2').select2()
  
    $('.treeview').each(function () {
      var shouldExpand = false
      $(this).find('li').each(function () {
        if ($(this).hasClass('active')) {
          shouldExpand = true
        }
      })
      if (shouldExpand) {
        $(this).addClass('active')
      }
    })
  
    $('a[data-widget^="pushmenu"]').click(function () {
      setTimeout(function() {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
      }, 350);
    })
  })