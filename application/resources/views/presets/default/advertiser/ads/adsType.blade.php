@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
@php
    $hasActiveSubscription = false;
    foreach ($isPurchase as $subscription) {
        if ($subscription->impression_point > 0 || $subscription->click_point > 0) {
            $hasActiveSubscription = true;
            break;
        }
    }

    $user = auth('advertiser')->user();
@endphp
<div class="row gy-4 justify-content-center">
    @forelse ($adTypes as $key => $item)
    <div class="col-md-3">
        <div class="price-cardBody">
            <div class="price-card-head mb-2">
                <p>{{__($item->ad_name)}}</p>
            </div>
                <ul>
                    <li>@lang('Type'): {{__($item->type)}}</strong>
                    </li>
                    <li>@lang('Width'): <strong>{{__($item->width)}}</strong>
                    </li>
                    <li>@lang('Height'): <strong>{{__($item->height)}}</strong>
                    </li>
                </ul>

            <div class="create mt-3">
                @if (($user->click <= 0 && $user->impression <= 0) && $hasActiveSubscription == false)
                <a href="{{route('advertiser.get.plan')}}" class="btn btn--secondary">
                    <i class="fas fa-cart-plus"></i>
                    @lang('Please Purchase a Plan First')
                </a>
            @else
                <a href="{{route('advertiser.ad.create',$item->id)}}" class="btn btn--base">
                    <i class="fas fa-cart-plus"></i>
                    @lang('Create Ad')
                </a>
            @endif
            </div>
        </div>
    </div>
    @empty
    @endforelse

    @if ($adTypes->hasPages())
    <div class="d-flex justify-content-end">
        {{ paginateLinks($adTypes) }}
    </div>
    @endif
</div>
@endsection
