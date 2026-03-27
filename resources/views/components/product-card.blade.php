<div class="product-card fade-in">
    @if(isset($badge))
        <div class="product-badge" {{ isset($badgeStyle) ? 'style='.$badgeStyle : '' }}>{{ $badge }}</div>
    @endif
    <div class="product-img">
        @if(isset($image) && $image)
            <img src="{{ asset($image) }}" alt="{{ $name }}" style="width:100%; height:100%; object-fit:cover;">
        @else
            <i class="fa-solid {{ $icon ?? 'fa-box' }}"></i>
        @endif
        <div class="product-actions">
            <button class="product-action-btn" title="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
            <a href="{{ url('/product-details/'.$id) }}" class="product-action-btn" title="Quick View"><i class="fa-regular fa-eye"></i></a>
        </div>
    </div>
    <div class="product-info">
        <a href="{{ url('/vendor/'.$vendorId) }}" class="product-vendor">{{ $vendorName }}</a>
        <a href="{{ url('/product-details/'.$id) }}" class="product-title">{{ $name }}</a>
        <div class="product-rating">
            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
            <span>({{ $reviewsCount ?? 0 }})</span>
        </div>
        <div class="product-price-row">
            <div class="price-box">
                <span class="price">${{ number_format($price, 2) }}</span>
                @if(isset($oldPrice))
                    <span class="old-price">${{ number_format($oldPrice, 2) }}</span>
                @endif
            </div>
            <button class="btn btn-sm btn-primary"><i class="fa-solid fa-plus"></i></button>
        </div>
    </div>
</div>
