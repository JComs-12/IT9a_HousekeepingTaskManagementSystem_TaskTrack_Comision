@foreach ($proucts as $product)

    {{ $product -> product_name}} -
    {{$product -> price}}

@endforeach