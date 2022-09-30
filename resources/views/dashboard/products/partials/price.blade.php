@if($product->has_discount)
    <s class="badge badge-danger p-2">{{ price($product->price) }}</s>
    <span class="badge badge-success p-2">{{ price($product->offer_price) }}</span>
@else
    <span class="badge badge-success p-2">{{ price($product->price) }}</span>
@endif