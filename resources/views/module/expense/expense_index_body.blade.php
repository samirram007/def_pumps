  <div class="rounded card p-3  bg-white shadow ">


      <div id="searchPanel" class="searchPanel">
          <div id="data-grid" class="data-tab-custom rounded">


              <div class="table-responsive">

                  <table id="table" class="table   table-striped table-bordered   ">
                      <thead>
                          <tr>
                              <th>{{__('VoucherDate')}}</th>
                              <th>{{__('VoucherNo')}}</th>
                              <th>{{__('Particulars')}}</th>
                              <th class="text-right"> {{__('Amount')}}</th>
                              <th>{{__('Action')}}</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($collections as $key => $data)
                              @php
                                  $data = (object) $data;

                              @endphp
                              <tr>
                                  <td><span class="sr-only">{{  $data->voucherDate}}</span>{{  __(date('d-m-Y', strtotime($data->voucherDate)))}}</td>
                                  <td><span class="sr-only">{{  $data->expenseId}}</span>{{  __($data->voucherNo)}}</td>
                                  <td class="text-wrap text-truncate text-left">{{ __($data->particulars) }}</td>
                                  <td class="text-wrap text-truncate  text-right">{{ number_format($data->amount, 2, '.', '') }}</td>

                                  <td class="text-right " style="overflow: inherit;">
                                      {{-- <a href="{{ route($routeRole.'.expense.edit', $data->expenseId) }}" title="{{__('Edit')}}" class="edit   btn btn-rounded animated-shine "><i class="fa fa-edit m-0 "></i></a> --}}
                                      <a href="javascript:" data-param="" data-url="{{ route($routeRole.'.expense.edit', $data->expenseId) }}"
                                      title="{{ __('Edit Expense Voucher') }}" class="load-popup edit   btn btn-rounded animated-shine ">
                                      <i class="fa fa-edit m-0 "></i></a>
                                      <a href="{{ route($routeRole.'.expense.delete', $data->expenseId) }}" title="{{__('Delete')}}" class="delete  btn btn-rounded animated-shine-danger    "><i class="fa fa-trash m-0 "></i></a>
                                  </td>
                              </tr>

                          @endforeach
                      </tbody>
                  </table>
              </div>


          </div>
      </div>
  </div>

  <script>
      $(document).ready(function() {
          var table = $('#table').DataTable({
              responsive: true,
              select: false,
              paging: true,
              zeroRecords: true,
              "oLanguage": langOpt,


              "order": [
                  [0, "desc"],
                    [1, "desc"]
              ]
          });
      });
  </script>
