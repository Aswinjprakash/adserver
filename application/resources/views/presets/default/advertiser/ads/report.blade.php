@extends($activeTemplate.'layouts.advertiser.master')
@section('content')
<div class="row gy-4 justify-content-center">
    <div class="col-lg-12">
        <div class="order-wrap">
            <div class="row justify-content-end">
                <div class="col-md-3 mb-3">
                    <div class="search-box w-100">
                        <form action="{{route('advertiser.ad.report.search')}}" method="GET">
                            <div class="form-group">
                            <input type="text" name="search" class="form--control" autocomplete="off" placeholder="">
                            <label class="form--label">@lang('Search') <span class="text-danger">@lang('by title/country')</span></label>
                            <button type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table--responsive--lg">
                <thead>
                    <tr>
                        <th>@lang('Ad Image')</th>
                        <th>@lang('Ad Name')</th>
                        <th>@lang('Ad Title')</th>
                        <th>@lang('Ad Resolution')</th>
                        <th>@lang('Country(From)')</th>
                        <th>@lang('Ad Type')</th>
                        <th>@lang('Click Count')</th>
                        <th>@lang('Impr. Count')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adReports as $report)
                        <tr>
                            <td data-label="@lang('Ad Image')">
                                <img class="adImage" src="{{ getImage(getFilePath('adImage').'/'.@$report->ad->image)}}" alt="image" class="rounded" style="width:80px; height:80px;"></div>
                            </td>
                            <td data-label="@lang('Ad Name')">{{__(@$report->ad->ad_name)}}</td>
                            <td data-label="@lang('Ad Title')">{{__(@$report->ad->title)}}</td>
                            <td data-label="@lang('Ad Resolution')">{{__(@$report->ad->resolution)}}</td>

                            <td data-label="@lang('Country(From)')">{{__($report->country ??'N/A')}}</td>
                            <td data-label="@lang('Ad Type')"><span class="badge badge--base">{{__(@$report->ad->ad_type)}}</span></td>
                            <td data-label="@lang('Click Count')">{{number_format($report->click_count)??'N/A'}}</td>
                            <td data-label="@lang('Impr. Count')">{{number_format($report->imp_count)??'N/A'}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td data-label="@lang('Ads Report Table')" class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($adReports->hasPages())
    <div class=" d-flex justify-content-end">
        {{ paginateLinks($adReports) }}
    </div>
    @endif
</div>
@endsection






