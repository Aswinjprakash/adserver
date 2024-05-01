@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-xl-8 col-lg-8">
        <div class="user-profile global-card">
            <form action="{{route('publisher.domain.update',$domain->tracker)}}" method="post">
                @csrf
                <div class="row gy-3">
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <input id="name" type="text" class="form--control"  value="{{$domain->name}}"  placeholder="" readonly>
                            <label for="name" class="form--label required">@lang('Domain Name')<span class="text-danger">*</span></label>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <select name="keywords[]" class="form--control select2-auto-tokenize w-100" id="keyWords" multiple="multiple">
                                @foreach($keywords as $key => $item)
                                <option value="{{ $item->keywords }}" {{ in_array($item->keywords, $selectedKeywords) ? 'selected' : '' }}>{{ __($item->keywords) }}</option>
                            @endforeach
                            </select>
                            <label for="keywords" class="form--label required"> @lang('Keywords') <span class="text-danger">* @lang('Reserved keywords')</span></label>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button type="submit" class="btn btn--base">@lang('Update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        'use strict';
        $('#keyWords').select2({
            dropdownParent: $('.user-profile'),
            tags: true,
            tokenSeparators: [',']
        });
    </script>
@endpush

