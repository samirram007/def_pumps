<div>
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
    <div class="row  border-top border-primary mt-0 pt-2">
        <div class="col-md-4">
            <div class="form-group"> 
                <label for="test">Select Test</label>
                <div class="controls">
                     
                        <select name="test[]" id="test" class="form-control test">
                            <option value="">Select test</option>
                            @foreach ($collection as $item)
                                <option value="{{ $item->id }}" data-amount="{{$item->amount}}">{{ $item->name }}</option>
                            @endforeach
                            {{-- @dd($item) --}}
                        </select>
                    @error('test')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" class="form-control test_amount" id="test_amount" name="tset_amount[]"
                    placeholder="Enter Package Amount">
            </div>
        </div>
            <div class="col-md-4 text-center m-auto  ">

                <div class="pb-4 text-center">
                    <span class=" btn btn-outline-info    p-0 addeventmore mr-2">
                        <span class="iconify" data-icon="akar-icons:circle-plus" data-width="30" data-height="30"></span></span>

                    <span class="btn btn-outline-danger   p-0    removeeventmore">
                        <span class="iconify" data-icon="ant-design:minus-circle-outlined" data-width="30" data-height="30"></span>
                    </span>


                </div>



            </div>
        
    </div>
     
</div>
