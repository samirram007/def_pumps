  <div class="rounded card p-3  bg-white shadow ">
      <input type="text" class="sr-only" id="salesIds">


      <div id="searchPanel" class="searchPanel">
          <div class="position-absolute w-100 text-md-center text-right pr-4 pt-2 h6"> <span id="select_count"
                  class="badge badge-info"></span></div>

          <div id="data-grid" class="data-tab-custom rounded">

              <style>
                  #salesIds {
                      margin-bottom: 1em;
                      padding: 1em;
                      background-color: #f6f6f6;
                      border: 1px solid #999;
                      border-radius: 3px;
                      height: 100px;
                      overflow: auto;
                  }

                  .cursor-pointer {
                      cursor: pointer;
                      z-index: 999;

                  }


                  .after_status:hover {
                      zoom: 130%;
                      opacity: 0.5;
                  }

                  .before_status:hover {

                      zoom: 130%;
                      opacity: 0.5;
                  }

                  .toggle-all:hover {
                      cursor: pointer;

                      zoom: 100%;
                      opacity: 0.5;
                  }

                  #table tbody tr.selected>* {
                      box-shadow: inset 0 0 0 9999px rgba(46, 80, 155, 0.4);
                      /* background-color: #3239474f !important; */
                      color: rgb(255 255 255) !important;
                      /* text-shadow: 0 0 0.2em #000000; */

                  }
                  .lights-off #table tbody tr.selected td:last-child,
                  .lights-off #table tbody tr.selected td:first-child,{
                    box-shadow: inset 0 0 0 9999px rgb(255, 255, 255) !important;
                  }
                  #table tbody tr.selected>td:first-child,
                  #table  .bg-danger-light td:last-child ,
                  #table  .bg-danger-light td:first-child ,#table  td:last-child  {
                      box-shadow: inset 0 0 0 9999px rgb(255, 255, 255) !important;
                  }
                  .lights-off #table  .bg-danger-light td:last-child, .lights-off #table  .bg-danger-light td:first-child,
                  , .lights-off #table  td:first-child {
                      /* box-shadow: inset 0 0 0 9999px rgba(255, 255, 255, 0) !important; */
                      box-shadow: inset 0 0 0 9999px rgb(255, 255, 255) !important;
                  }

                  .bg-danger-light, .lights-off #table  .bg-danger-light td{
                      box-shadow: inset 0 0 0 9999px rgba(238, 182, 182, 0.521)!important;
                      /* background-color: #3239474f !important; */
                      color: rgba(25, 25, 25) !important;
                      /* text-shadow: 0 0 0.2em #fffcfc; */
                  }
                  .bg-success-light, .lights-off #table  .bg-success-light td{
                      box-shadow: inset 0 0 0 9999px rgba(203, 238, 216, 0.521)!important;
                      /* background-color: #3239474f !important; */
                      color: rgba(25, 25, 25) !important;
                      /* text-shadow: 0 0 0.2em #fffcfc; */
                  }
                    .lights-off #table  .bg-success-light td:first-child, .lights-off #table  .bg-danger-light td:first-child{
                      box-shadow: inset 0 0 0 9999px rgba(255, 254, 254, 1)!important;
                      color: rgba(25, 25, 25) !important;
                  }
                  .lights-off  #table  td:last-child {
                    box-shadow: inset 0 0 0 9999px rgba(255, 254, 254, 1)!important;
                      color: rgba(25, 25, 25) !important;
                  }

              </style>
              {{-- <div id="salesIds">
                Event summary - new salesIds added at the top
            </div> --}}

              <table id="table" class="table  table-striped  table-bordered   ">
                  <thead>
                      <tr>
                          <th class="text-right">
                            @if(in_array($routeRole, ['pumpadmin','pumpuser']))
                            --
                            @else
                              <input type="checkbox" name="select_all" value="1" id="table-select-all"
                                  class="toggle-all">
                            @endif
                          </th>
                          {{-- <th><input type="checkbox" id="select-all"></th> --}}
                          <th>{{ __('InvoiceDate') }}</th>
                          <th>{{ __('InvoiceNo') }}</th>
                          <th>{{ __('Name') }}</th>
                          <th> {{ __('MobileNo') }}</th>
                          <th> {{ __('VehicleNo') }}</th>
                          <th> {{ __('Product') }}</th>
                          <th class="text-right"> {{ __('Quantity') }}</th>
                          <th class="text-right"> {{ __('Rate') }}</th>
                          <th class="text-right"> {{ __('Discount') }}</th>
                          <th class="text-right"> {{ __('Total') }}</th>
                          {{-- <th class="text-center"> {{ __('PaymentMode') }}</th> --}}
                          <th>{{ __('Comment') }}</th>
                          <th>{{ __('Action') }}</th>

                      </tr>
                  </thead>
                  <tbody>
                      @forelse ($collections as $key => $data)
                          @php
                              $data = (object) $data;
                              if ($data->paymentModeName == 'Cash') {
                                  $bgColor = 'cash';
                              } elseif ($data->paymentModeName == 'UPI') {
                                  $bgColor = 'upi';
                              } elseif ($data->paymentModeName == 'Card') {
                                  $bgColor = 'cr_card';
                              } elseif ($data->paymentModeName == 'NetBanking') {
                                  $bgColor = 'net_bank';
                              } else {
                                  $bgColor = '';
                              }

                          @endphp

                          <tr class="{{ $data->status == 2 ? 'bg-danger-light' : '' }} {{ $data->status == 1 ? 'bg-success-light' : '' }}">
                              <td>
                                  @if ($data->status == 1)
                                      {{ 'verified|' }}{{ $data->salesId }}
                                  @elseif ($data->status == 2)
                                      {{ 'dispute|' }}{{ $data->salesId }}
                                  @elseif ($data->status == 0)
                                      {{ 'under_process|' }}{{ $data->salesId }}
                                  @endif
                              </td>
                              {{-- <td><input type="checkbox" name="row1"></td> --}}
                              <td><span
                                      class="sr-only">{{ $data->invoiceDate }}</span>{{ __(date('d-m-Y', strtotime($data->invoiceDate))) }}
                              </td>
                              <td>{{ __($data->invoiceNo) }}</td>
                              <td class="text-wrap text-truncate text-left">{{ __($data->customerName) }}</td>
                              <td class="text-wrap text-truncate  text-left">{{ __($data->mobileNo) }}</td>
                              <td class="text-wrap text-truncate  text-left">{{ __($data->vehicleNo) }}</td>
                              <td class="text-wrap text-truncate  text-left">{{ __($data->productTypeName) }}</td>
                              <td class="text-wrap text-truncate text-right">{{ __($data->quantity) }}</td>
                              <td class="text-wrap text-truncate text-right">
                                  {{ number_format($data->rate, 2, '.', '') }}</td>
                              <td class="text-wrap text-truncate text-right">
                                  {{ number_format($data->discount, 2, '.', '') }}</td>

                              <td class="text-wrap text-truncate  text-right {{ $bgColor }}"
                                  title="{{ __($data->paymentModeName) }}">
                                  {{ number_format($data->total, 2, '.', '') }}</td>
                              {{-- <td class="text-wrap text-truncate  text-center">{{ __($data->paymentModeName) }}</td> --}}
                              <td class="text-wrap text-truncate text-left">{{ __($data->comment) }}</td>
                              <td class="text-left py-2" style="overflow: inherit; text-align:left!important">
                                  <a href="javascript:" data-param="{{ base64_encode(json_encode($data)) }}"
                                      data-url="{{ route($routeRole . '.sales.show', $data->salesId) }}"
                                      title="{{ __('View') }}"
                                      class="load-popup edit    mx-2 text-info d-inline-flex "><i
                                          class="fa fa-eye fa-lg"></i></a>
                                  @if ($routeRole == 'companyadmin' || !in_array($data->status, [1, 2]))
                                      <a href="javascript:" data-param="{{ base64_encode(json_encode($data)) }}"
                                          data-url="{{ route($routeRole . '.sales.edit', $data->salesId) }}"
                                          title="{{ __('Edit') }}"
                                          class="load-popup edit    mx-2 text-info d-inline-flex "><i
                                              class="fa fa-edit fa-lg"></i></a>
                                      <a href="{{ route($routeRole . '.sales.delete', $data->salesId) }}"
                                          title="{{ __('Delete') }}"
                                          class="   d-inline-flex  my-2 text-lg  mx-2 delete   text-info"><i
                                              class="fa fa-trash fa-lg"></i></a>
                                  {{-- @elseif (in_array($routeRole, ['pumpadmin', 'pumpuser']))
                                                @if(in_array($data->status, [1, 2]))

                                                @endif --}}
                                  @endif
                              </td>
                          </tr>
                      @empty
                          {{-- <tr>
                                  <td colspan="12" class="align-left p-4" style="text-align: left!important">No Records Found</td>
                               </tr> --}}
                      @endforelse
                  </tbody>
              </table>



          </div>
      </div>
  </div>

  <script>
      function getSalesIds() {
          var ids = $.map(table.rows('.selected').data(), function(item) {
              return item[0];
          });
          //csv to array
        //   var ids = ids.toString().split(',');
        // ids = ids.toString().split(',').join('').replace(/under_process|dispute|\|/g, '');
        ids = ids.toString().split(',').map(id => id.replace(/(under_process|dispute|\|)/g, '')).join(',');
          //ids push into array
          salesIds.val(ids);
      }
  </script>
  <script>
      $(document).ready(function() {

          var salesIds = $('#salesIds');
          var routeRole = "{{ $routeRole }}";
          console.log(routeRole);
          var table = $('#table').DataTable({
              responsive: true,
              paging: true,
              zeroRecords: true,
              "oLanguage": langOpt,
              "lengthMenu": [
                  [-1, 10, 25, 50, 100, 200, 500],
                  ["All", 10, 25, 50, 100, 200, 500]
              ],
              pageLength: 25,



              columnDefs: [{
                  targets: 0,
                  orderable: false,
                  className: 'dt-body-center',
                  render: function(data, type, full, meta) {
                      var sales_status_id = data.toString().split('|');
                      // console.log(sales_status_id);
                      var sales_status = sales_status_id[0];
                      var sales_id = sales_status_id[1];
                      //   return '<input type="checkbox" class="cursor-pointer before_status" name="id[]" value="' +
                      //               $('<td>').text(sales_id).html() + '">';

                      //  console.log(jQuery.inArray( routeRole, ['pumpadmin','pumpuser'] ));
                      if (sales_status === 'verified') {
                          return '<i class="fas fa-check-double text-success after_status cursor-pointer" data-salesid="' +
                              sales_id + '" title="{{ __('verified') }}"></i>';
                      } else if (sales_status === 'dispute' && jQuery.inArray(routeRole, [
                              'pumpadmin', 'pumpuser'
                          ]) >= 0) {
                          return '<i class="fas   fa-question text-secondary text-shadow  after_status cursor-pointer"  data-salesid="' +
                              sales_id + '"  title="{{ __('disputed') }}"></i>';
                      } else if (sales_status === 'dispute' && jQuery.inArray(routeRole, [
                              'pumpadmin', 'pumpuser'
                          ]) < 0) {
                          return '<input type="checkbox" class="cursor-pointer before_status" name="id[]" value="' +
                              $('<td>').text(sales_id).html() + '">';
                      } else if (sales_status === 'under_process' && jQuery.inArray(routeRole,
                              ['pumpadmin', 'pumpuser']) >= 0) {
                          return '<i class="fas   fa-check text-secondary text-shadow  after_status cursor-pointer"  data-salesid="' +
                              sales_id + '"  title="{{ __('disputed') }}"></i>';

                      } else if (sales_status === 'under_process' && jQuery.inArray(routeRole,
                              ['pumpadmin', 'pumpuser']) < 0) {
                          return '<input type="checkbox" class="cursor-pointer before_status" name="id[]" value="' +
                              $('<td>').text(sales_id).html() + '">';
                      }
                      //   if (sales_status === 'dispute') {
                      //       //   return '<i class="fas   fa-gavel text-secondary text-shadow  after_status cursor-pointer" data-salesid="' +
                      //       //       sales_id + '"  title="{{ __('dispute') }}"></i>';
                      //       if ({{ in_array($routeRole, ['pumpadmin', 'pumpuser']) }}) {
                      //           return '<i class="fas   fa-question text-secondary text-shadow  after_status cursor-pointer"  data-salesid="' +
                      //               sales_id + '"  title="{{ __('dispute') }}"></i>';
                      //       } else {
                      //           return '<input type="checkbox" class="cursor-pointer before_status" name="id[]" value="' +
                      //               $('<td>').text(sales_id).html() + '">';
                      //       }

                      //   } else {
                      //       if ({{ in_array($routeRole, ['pumpadmin', 'pumpuser']) }}) {
                      //           return '<i class="fas   fa-check  text-secondary text-shadow  after_status cursor-pointer" data-salesid="' +
                      //               sales_id + '"  title="{{ __('Not Verified') }}"></i>';
                      //       } else {
                      //           return '<input type="checkbox" class="cursor-pointer before_status" name="id[]" value="' +
                      //               $('<td>').text(sales_id).html() + '">';
                      //       }

                      //   }


                  }
              }],
              select: {
                  style: 'multi',
                  selector: 'td:first-child input[type="checkbox"] ',

              },

              "order": [
                  [1, "desc"],
                  [2, "desc"]
              ]
          });



          // Handle click on checkbox to set state of "Select all" control
          $('#table tbody').on('change', 'input[type="checkbox"]', function(e) {
              //e.preventDefault();
              // If checkbox is not checked
              //   if (this.checked) {
              //     table.$('tr.selected').removeClass('selected');

              //   } else {
              //     table.$('tr').addClass('selected');
              //   }
              if (!this.checked) {
                  var el = $('#table-select-all').get(0);
                  // console.log(el.checked);
                  // If "Select all" control is checked and has 'indeterminate' property
                  if (el && el.checked && ('indeterminate' in el)) {
                      // Set visual state of "Select all" control
                      // as 'indeterminate'
                      el.indeterminate = true;
                  }


              } else {
                  this.checked = true;
              }
              var ids = $.map(table.rows('.selected').data(), function(item) {
                  return item[0];
              });
              $('#select_count').html(ids.length + ' selected');
              //csv to array
            //   var ids = ids.toString().split(',');
            // ids = ids.toString().split(',').join('').replace(/under_process|dispute|\|/g, '');
            ids = ids.toString().split(',').map(id => id.replace(/(under_process|dispute|\|)/g, '')).join(',');
              //ids push into array
              salesIds.val(ids);
          });

          $('#table-select-all').on('click', function() {
              // Get all rows with search applied
              var rows = table.rows({
                  'search': 'applied'
              }).nodes();
              // Check/uncheck checkboxes for all rows in the table
              $('input[type="checkbox"]', rows).prop('checked', this.checked);
              // console.log(this.checked);
              if (this.checked) {
                  // check and add selected class to each if first-child td contains checkbox

                  $(rows).each(function(index) {
                      //console.log( index + ": " + $(this).find('td:first-child input[type="checkbox"]').length);
                      if ($(this).find('td:first-child input[type="checkbox"]').length == 1) {
                          $(this).addClass('selected');

                      }

                  });




              } else {
                  table.$('tr.selected').removeClass('selected');
              }

              var ids = $.map(table.rows('.selected').data(), function(item) {
                  return item[0];
              });
              $('#select_count').html(ids.length + ' selected');
              //csv to array
            //   ids = ids.toString().split(',').join('').replace(/under_process|dispute|\|/g, '');
            ids = ids.toString().split(',').map(id => id.replace(/(under_process|dispute|\|)/g, '')).join(',');
            //   var ids = ids.toString().split(',');
            //   ids=str_replace(ids, 'under_process', '');
            //   ids=str_replace(ids, 'dispute', '');
            //   ids=str_replace(ids, '|', '');
              //ids push into array
              salesIds.val(ids);
              //  $('#table').DataTable().draw();

          });

          table
              .on('select', function(e, dt, type, indexes) {
                  //console.log('select');
                  var rowData = table.rows(indexes).data().toArray();
                  //checkedbox checked
                  var row = table.row(indexes).nodes().to$();
                  //   console.log(row.find('input[type="checkbox"]').prop('checked'));
                  if (row.find('input[type="checkbox"]').prop('checked') == false) {
                      row.find('input[type="checkbox"]').prop('checked', false);
                      // trigger remove selected from current row class
                      // console.log(row(indexes).removeClass('selected'));
                      var sender = row.find('input[type="checkbox"]');
                      sender_parent = sender.parent().parent();
                      // console.log(sender_parent);
                      sender_parent.removeClass('selected');

                  }
                  //   else{
                  //     row.find('input[type="checkbox"]').prop('checked', false);
                  //   }

                  //row.find('input[type="checkbox"]').prop('checked', true);


                  var ids = $.map(table.rows('.selected').data(), function(item) {
                      return item[0];
                  });
                  $('#select_count').html(ids.length + ' selected');
                  //csv to array
                //   var ids = ids.toString().split(',');
                // ids = ids.toString().split(',').join('').replace(/under_process|dispute|\|/g, '');
                ids = ids.toString().split(',').map(id => id.replace(/(under_process|dispute|\|)/g, '')).join(',');
                  //ids push into array
                  salesIds.val(ids);
              })
              .on('deselect', function(e, dt, type, indexes) {
                  console.log(2);
                  var rowData = table.rows(indexes).data().toArray();
                  //checkedbox unchecked
                  var row = table.row(indexes).nodes().to$();
                  //  row('input[type="checkbox"]').prop('checked', false);
                  //  row.find('input[type="checkbox"]').prop('checked', false);
                  if (row.find('input[type="checkbox"]').prop('checked') == true) {
                      row.find('input[type="checkbox"]').prop('checked', true);
                      // trigger remove selected from current row class
                      // console.log(row(indexes).removeClass('selected'));
                      var sender = row.find('input[type="checkbox"]');
                      sender_parent = sender.parent().parent();
                      // console.log(sender_parent);
                      sender_parent.addClass('selected');

                  }
                  //console.log(rowData[0][0]);
                  //comma separated values
                  var ids = $.map(table.rows('.selected').data(), function(item) {
                      return item[0];
                  });
                  $('#select_count').html(ids.length + ' selected');
                  //csv to array
                //   var ids = ids.toString().split(',');
                // ids = ids.toString().split(',').join('').replace(/under_process|dispute|\|/g, '');
                ids = ids.toString().split(',').map(id => id.replace(/(under_process|dispute|\|)/g, '')).join(',');
                  //ids push into array
                  salesIds.val(ids);
              });

          // Handle form verify event

          //   $('#btn-verify').on('click', function() {


      });
  </script>
