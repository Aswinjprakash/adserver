@extends($activeTemplate.'layouts.frontend')
@section('content')

    <section class="container py-120">
        <div class="row">
            <div class="col wyg">
                <div class="single-terms mb-30">
                    <p>
                        @php
                            echo $policy->data_values->details
                        @endphp
                    </p>
                </div>
            </div>
        </div>
    </div>
 </section>

@endsection

@push('style')
<style>
    .wyg h1, .wyg h2, .wyg h3, .wyg h4 {
        color:hsl(var(--black));
    }
    .wyg p{
        color:hsl(var(--black));
    }
    .wyg ul {
        margin: 35px;
    }
    .wyg ul li{
        list-style-type: disc;
        color:hsl(var(--black));
        font-family: var(--body-font);
    }

    /*========= dark css =======*/
    .dark .wyg h1, .dark .wyg h2, .dark .wyg h3, .dark .wyg h4 {
        color:hsl(var(--white)/.6);
    }
    .dark .wyg p{
        color:hsl(var(--white)/.6);
    }
    .dark .wyg ul {
        margin: 35px;
    }
    .dark .wyg ul li{
        list-style-type: disc;
        color:hsl(var(--white));
    }
</style>
@endpush

