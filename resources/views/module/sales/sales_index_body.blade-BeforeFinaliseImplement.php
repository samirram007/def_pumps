  <div class="rounded card p-3  bg-white shadow ">


      <div id="searchPanel" class="searchPanel">
          <div id="data-grid" class="data-tab-custom rounded">




              <table id="table" class="table  table-striped  table-bordered   ">
                  <thead>
                      <tr>
                          <th>{{ __('InvoiceDate') }}</th>
                          <th>{{ __('InvoiceNo') }}</th>
                          <th>{{ __('Name') }}</th>
                          <th> {{ __('MobileNo') }}</th>
                          <th> {{ __('VehicleNo') }}</th>
                          <th> {{ __('Product') }}</th>
                          <th class="text-center"> {{ __('Quantity') }}</th>
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

                          <tr>
                              <td><span class="sr-only">{{$data->invoiceDate}}</span>{{ __(date('d-m-Y', strtotime($data->invoiceDate))) }}</td>
                              <td>{{ __($data->invoiceNo) }}</td>
                              <td class="text-wrap text-truncate text-left">{{ __($data->customerName) }}</td>
                              <td class="text-wrap text-truncate  text-left">{{ __($data->mobileNo) }}</td>
                              <td class="text-wrap text-truncate  text-left">{{ __($data->vehicleNo) }}</td>
                              <td class="text-wrap text-truncate  text-left">{{ __($data->productTypeName) }}</td>
                              <td class="text-wrap text-truncate text-left">{{ __($data->quantity) }}</td>
                              <td class="text-wrap text-truncate text-right">
                                  {{ number_format($data->rate, 2, '.', '') }}</td>
                              <td class="text-wrap text-truncate text-right">
                                  {{ number_format($data->discount, 2, '.', '') }}</td>

                              <td class="text-wrap text-truncate  text-right {{ $bgColor }}" title="{{__($data->paymentModeName)}}">
                                  {{ number_format($data->total, 2, '.', '') }}</td>
                              {{-- <td class="text-wrap text-truncate  text-center">{{ __($data->paymentModeName) }}</td> --}}
                              <td class="text-wrap text-truncate text-left">{{ __($data->comment) }}</td>
                              <td class="text-center " style="overflow: inherit;">
                                  <a href="javascript:" data-param=""
                                      data-url="{{ route($routeRole . '.sales.edit', $data->salesId) }}"
                                      title="{{ __('Edit') }}"
                                      class="load-popup edit   btn btn-rounded animated-shine "><i
                                          class="fa fa-edit "></i></a>



                                  <a href="{{ route($routeRole . '.sales.delete', $data->salesId) }}"
                                      title="{{ __('Delete') }}"
                                      class="delete  btn btn-rounded animated-shine-danger  pm-0  "><i
                                          class="fa fa-trash "></i></a>
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
