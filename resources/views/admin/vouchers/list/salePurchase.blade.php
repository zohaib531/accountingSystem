@extends('layouts.admin')
@section('title', 'Sale/Purchase Voucher List')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-6 text-right">
                                <h4 class="card-title">All Sale/Purchase Voucher</h4>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('salePurchase.create') }}">
                                    <button type="button" class="btn btn-primary">
                                        Add new +
                                    </button>
                                </a>
                            </div>
                            {{-- Filter Code Start --}}
                            <div class="col-10">

                                <form method="post" action="{{ route('applyFilter') }}">
                                    @csrf
                                    <div class="row mt-2 align-items-end">
                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Start Date<span class="text-danger">*</span></label>
                                            <div class="col-lg-12 px-0">
                                                {{-- <input name="start_date" id="val-start_date" class="form-control @error('start_date') border-danger @enderror" @if(in_array($start_date, $filterElementsArr)) value="{{$start_date}}" @endif placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text"> --}}
                                                <input name="start_date" id="val-start_date" class="form-control @error('start_date') border-danger @enderror" value="{{old('start_date')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">

                                                @if ($errors->has('start_date'))
                                                    <span class="text-danger">Please start end date.</span>
                                                @else
                                                    <span class="fade">Some Data</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0" for="val-end_date">End date<span class="text-danger">*</span></label>
                                            <div class="col-lg-12 px-0">
                                                <input name="end_date" id="val-end_date"  class="form-control  @error('end_date') border-danger @enderror" value="{{old('end_date')}}"  placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                @if ($errors->has('end_date'))
                                                    <span class="text-danger">Please enter end date.</span>
                                                @else
                                                    <span class="fade">Some Data</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Product Type<span class="text-danger">*</span></label>
                                            <select class="form-control searchableSelectFilterProductType" name="product_type" onchange="productChange(this)">
                                                <option selected value="all">All</option>
                                                @foreach ($unique_product_titles as $product)
                                                    <option value="{{$product->title}}"  @if(in_array($product->title , $filterElementsArr)) selected @endif>{{$product->title}}</option>
                                                @endforeach
                                            </select>
                                            <span class="fade">Some Data</span>
                                        </div>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                            <select name="sub_account_id" class="form-control searchableSelectFilterSubaccount">
                                                <option selected value="all">All</option>
                                                @foreach ($subAccounts as $subAccount)
                                                    <option value="{{$subAccount->id}}" @if(in_array($subAccount->id, $filterElementsArr)) selected @endif>{{$subAccount->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                            <select name="product_narration" id="productWithFilter" class="form-control searchableSelectFilterProduct">
                                                <option selected value="all" >All</option>
                                                @if (isset($filterElementsArr[2]) && $filterElementsArr[2] != 'all')
                                                    @foreach ($products as $product)
                                                        @if(in_array($product->title , $filterElementsArr) )
                                                            <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}"  @if(in_array($product->title." - ".$product->narration." - ".$product->product_unit , $filterElementsArr)) selected @endif>{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($products as $product)
                                                            <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}"  @if(in_array($product->title." - ".$product->narration." - ".$product->product_unit , $filterElementsArr)) selected @endif>{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Transaction Type<span class="text-danger">*</span></label>
                                            <select name="entry_type" class="form-control searchableSelectFilterTransaction">
                                                <option selected value="all">All</option>
                                                <option value="debit" @if(in_array('debit', $filterElementsArr)) selected @endif>Debit</option>
                                                <option value="credit" @if(in_array('credit', $filterElementsArr)) selected @endif>Credit</option>
                                            </select>
                                        </div>

                                        <div class="col-3 text-center">
                                            <button type="submit" class="btn btn-primary">
                                                Apply Filter
                                            </button>
                                            <a href="{{ route('salePurchase.index') }} "  class="{{ Request::is('applyFilter') ? 'd-inline' : 'd-none' }}">
                                                <button type="button" class="btn btn-danger">
                                                    Refresh Filter
                                                </button>
                                            </a>
                                        </div>

                                    </div>

                                </form>


                            </div>
                            {{-- Filter Code Start --}}

                        </div>

                        <div class="d-flex justify-content-end px-3 ">
                            <a class="btn btn-success text-white" href="{{ route('salePurchaseReport') }}">Export to PDF</a>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Sub account</th>
                                        <th>Product</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $num = 0;
                                    @endphp
                                    @foreach ($vouchers as $key => $voucherDetail)
                                        @if($voucherDetail->voucher->voucher_type=='sale_purchase_voucher')

                                            <tr>
                                                <td>{{ ++$num }}</td>
                                                <td>{{date('d/m/y',strtotime($voucherDetail->date))}}</td>
                                                <td>{{ $voucherDetail->subAccount['title']  }}</td>
                                                <td>{{ $voucherDetail->product_narration }}</td>
                                                {{-- Code for Debit start --}}
                                                @if ($voucherDetail->entry_type =='debit')
                                                    <td>{{ number_format($voucherDetail->debit_amount , 2) }}</td>
                                                @else
                                                    <td>0.00</td>
                                                @endif
                                                {{-- Code for Debit start --}}

                                                {{-- Code for Credit start --}}
                                                @if ($voucherDetail->entry_type == 'credit')
                                                    <td>{{ number_format($voucherDetail->credit_amount , 2) }}</td>
                                                @else
                                                    <td>0.00</td>
                                                @endif
                                                {{-- Code for Credit start --}}

                                                <td class="text-right">
                                                    <a href="{{route('salePurchase.edit',$voucherDetail->voucher->id)}}">
                                                        <button class="btn btn-info text-white btn-sm">
                                                            Update
                                                        </button>
                                                    </a>
                                                    {{-- <button class="btn btn-danger btn-sm" onclick="commonFunction(true,'{{ route('salePurchase.destroy', $voucherDetail->voucher->id) }}','{{ route('salePurchase.index') }}','delete','Are you sure you want to delete?','');">
                                                        Delete
                                                    </button> --}}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')

    <script>
        $(document).ready(function() {
            $('.searchableSelectFilterSubaccount').select2({dropdownParent: $('.searchableSelectFilterSubaccount').parent()});
            $('.searchableSelectFilterProduct').select2({dropdownParent: $('.searchableSelectFilterProduct').parent()});
            $('.searchableSelectFilterTransaction').select2({dropdownParent: $('.searchableSelectFilterTransaction').parent()});
            $('.searchableSelectFilterProductType').select2({dropdownParent: $('.searchableSelectFilterProductType').parent()});
        });

        // const productChange = (e) => {
        //     // productWithFilter.innerHTML = '<option selected value="all" >All</option>';
        //     let html = '<option selected value="all" >All</option>';
        //     let newSingleHTML = '';

        //     var allproduct = {!! $products !!};
        //     for(let singleProduct of allproduct){
        //         if(e.value == 'all'){
        //             html +=`<option value="${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}" >${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}</option>`;
        //         }
        //         if(e.value == singleProduct.title){

        //             newSingleHTML +=`<option value="${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}" >${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}</option>`;

        //         }

        //     }

        //     e.value == 'all' ? productWithFilter.innerHTML = html : productWithFilter.innerHTML = newSingleHTML;
        // }


        const productChange = (e) => {
            let html = '<option selected value="all" >All</option>';
            var allproduct = {!! $products !!};
            for(let singleProduct of allproduct){
                if(e.value == 'all'){
                    html +=`<option value="${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}" >${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}</option>`;
                }
                if(e.value == singleProduct.title){
                    html +=`<option value="${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}" >${singleProduct.title} - ${singleProduct.narration} - ${singleProduct.product_unit}</option>`;
                }
            }
            productWithFilter.innerHTML= html;
        }
    </script>

@endsection
