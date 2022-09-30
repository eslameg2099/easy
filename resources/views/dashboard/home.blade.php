<x-layout :title="trans('dashboard.home')" :breadcrumbs="['dashboard.home']">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Order::whereDate('created_at', today())->count() }}</h3>

                    <p>{{ __('الطلبات اليوم') }}</p>
                </div>
                <a href="{{ route('dashboard.orders.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\Shop::count() }}</h3>
                    <p>{{ __('عدد المتاجر') }}</p>
                </div>
                <a href="{{ route('dashboard.shops.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Delegate::count() }}</h3>

                    <p>{{ __('عدد المندوبين') }}</p>
                </div>
                <a href="{{ route('dashboard.delegates.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\Customer::count() }}</h3>

                    <p>{{ __('عدد العملاء') }}</p>
                </div>
                <a href="{{ route('dashboard.customers.index') }}" class="small-box-footer">
                    @lang('عرض المزيد')
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>
{{--    @foreach(\App\Models\Product::where('quantity', '<', 5)->get())--}}

{{--    @endforeach--}}
</x-layout>
