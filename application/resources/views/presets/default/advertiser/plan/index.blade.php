@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4">
    @forelse ($plans as $item)
    <div class="col-md-3">
        <div class="price-cardBody">
            <div class="price-card-head mb-2">
                <p>{{__($item->name)}}</p>
                <h2>{{__($general->cur_sym)}} {{showAmount(__($item->price))}}</h2>
            </div>

                <ul>
                    <li>

                        <span>@lang('Type'): {{__($item->type)}}</span>
                    </li>
                    <li>

                        <span>@lang('Points'): {{__($item->points)}}</span>
                    </li>
                </ul>

            <div class="create mt-3">
                <a href="{{route('user.payment',$item->id)}}" class="btn btn--base planPurchase">
                    <i class="fas fa-cart-plus"></i>
                   @lang('Purchase')</a>
            </div>
        </div>
    </div>
    @empty
    @endforelse
</div>
@endsection
