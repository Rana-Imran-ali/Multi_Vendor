{{--
    COMPONENT: x-product-card
    Props: id, name, slug, price, oldPrice, discount, rating, reviewsCount,
           image, icon, badge, badgeType (sale|new|hot|featured),
           vendorId, vendorName, vendorSlug, inStock
--}}

@php
    $badgeClasses = [
        'sale'     => 'pc-badge--sale',
        'new'      => 'pc-badge--new',
        'hot'      => 'pc-badge--hot',
        'featured' => 'pc-badge--featured',
    ];
    $badgeClass = $badgeClasses[$badgeType ?? 'sale'] ?? 'pc-badge--sale';
    $productUrl = url('/products/' . ($slug ?? $id));
    $vendorUrl  = url('/vendors/'  . ($vendorSlug ?? $vendorId ?? '#'));

    // Star rendering
    $stars    = round($rating ?? 4);
    $maxStars = 5;
@endphp

<div class="pc-card">

    {{-- Image area --}}
    <div class="pc-image-wrap">

        @if(isset($badge) && $badge)
            <span class="pc-badge {{ $badgeClass }}">{{ $badge }}</span>
        @endif

        <a href="{{ $productUrl }}" class="pc-image-link" aria-label="{{ $name }}">
            @if(!empty($image))
                <img src="{{ asset($image) }}" alt="{{ $name }}" class="pc-img" loading="lazy">
            @else
                <div class="pc-img-placeholder">
                    <i class="fa {{ $icon ?? 'fa-box' }}"></i>
                </div>
            @endif
        </a>

        {{-- Hover actions --}}
        <div class="pc-actions">
            <button class="pc-action-btn" title="Add to Wishlist" aria-label="Wishlist">
                <i class="fa-regular fa-heart"></i>
            </button>
            <a href="{{ $productUrl }}" class="pc-action-btn" title="Quick View" aria-label="Quick View">
                <i class="fa-regular fa-eye"></i>
            </a>
            <button class="pc-action-btn" title="Compare" aria-label="Compare">
                <i class="fa-solid fa-arrows-left-right-to-line"></i>
            </button>
        </div>
    </div>

    {{-- Info area --}}
    <div class="pc-body">

        <a href="{{ $vendorUrl }}" class="pc-vendor-name">
            <i class="fa-solid fa-store fs-xs me-1"></i>{{ $vendorName ?? 'Vendo Store' }}
        </a>

        <a href="{{ $productUrl }}" class="pc-product-name">{{ $name }}</a>

        {{-- Stars --}}
        <div class="pc-rating">
            <div class="pc-stars">
                @for($i = 1; $i <= $maxStars; $i++)
                    @if($i <= $stars)
                        <i class="fa-solid fa-star"></i>
                    @else
                        <i class="fa-regular fa-star"></i>
                    @endif
                @endfor
            </div>
            <span class="pc-review-count">({{ $reviewsCount ?? 0 }})</span>
        </div>

        {{-- Price row --}}
        <div class="pc-price-row">
            <div class="pc-prices">
                <span class="pc-price">Rs {{ number_format($price ?? 0) }}</span>
                @if(!empty($oldPrice))
                    <span class="pc-old-price">Rs {{ number_format($oldPrice) }}</span>
                @endif
            </div>
            @if(!empty($discount))
                <span class="pc-discount-tag">{{ $discount }}% off</span>
            @endif
        </div>

        {{-- Add to cart --}}
        <button
            class="pc-add-cart {{ isset($inStock) && !$inStock ? 'pc-add-cart--disabled' : '' }}"
            {{ isset($inStock) && !$inStock ? 'disabled' : '' }}
        >
            @if(isset($inStock) && !$inStock)
                <i class="fa-solid fa-ban me-1"></i> Out of Stock
            @else
                <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
            @endif
        </button>

    </div>
</div>

<style>
/* Only inject once — guard using a Blade stack in your layout:
   @stack('product-card-styles')
   and push once. For simplicity, styles are self-contained here. */

.pc-card {
    background: #fff;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-light);
    overflow: hidden;
    transition: box-shadow .25s ease, transform .25s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.pc-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
}

/* Image area */
.pc-image-wrap {
    position: relative;
    overflow: hidden;
    aspect-ratio: 1 / 1;
    background: #f7f8fa;
}
.pc-image-link { display: block; width: 100%; height: 100%; }
.pc-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}
.pc-card:hover .pc-img { transform: scale(1.06); }

.pc-img-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #c8ced8;
    background: linear-gradient(135deg, #f0f2f5, #e8eaed);
}

/* Badge */
.pc-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 2;
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    padding: 3px 9px;
    border-radius: 4px;
    color: #fff;
}
.pc-badge--sale     { background: var(--brand-primary); }
.pc-badge--new      { background: #22c55e; }
.pc-badge--hot      { background: #ef4444; }
.pc-badge--featured { background: #8b5cf6; }

/* Hover actions */
.pc-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    opacity: 0;
    transform: translateX(12px);
    transition: all .25s ease;
    z-index: 2;
}
.pc-card:hover .pc-actions {
    opacity: 1;
    transform: translateX(0);
}
.pc-action-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid var(--border-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    font-size: .85rem;
    cursor: pointer;
    text-decoration: none;
    transition: all .18s ease;
    box-shadow: var(--shadow-sm);
}
.pc-action-btn:hover {
    background: var(--brand-primary);
    border-color: var(--brand-primary);
    color: #fff;
}

/* Body */
.pc-body {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: .35rem;
}
.pc-vendor-name {
    font-size: .72rem;
    font-weight: 600;
    color: var(--brand-primary);
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: .4px;
}
.pc-vendor-name:hover { text-decoration: underline; }

.pc-product-name {
    font-size: .9rem;
    font-weight: 600;
    color: var(--text-primary);
    text-decoration: none;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.pc-product-name:hover { color: var(--brand-primary); }

/* Rating */
.pc-rating {
    display: flex;
    align-items: center;
    gap: .35rem;
}
.pc-stars { color: #f59e0b; font-size: .78rem; display: flex; gap: 1px; }
.pc-review-count { font-size: .75rem; color: var(--text-muted); }

/* Price */
.pc-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    margin-top: .15rem;
}
.pc-prices { display: flex; align-items: baseline; gap: .5rem; flex-wrap: wrap; }
.pc-price {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text-primary);
}
.pc-old-price {
    font-size: .82rem;
    color: var(--text-muted);
    text-decoration: line-through;
}
.pc-discount-tag {
    font-size: .68rem;
    font-weight: 700;
    color: #22c55e;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    padding: 2px 7px;
    border-radius: 4px;
    white-space: nowrap;
}

/* Add to cart */
.pc-add-cart {
    margin-top: auto;
    width: 100%;
    padding: .5rem;
    background: var(--brand-light);
    border: 1.5px solid transparent;
    border-radius: var(--radius-sm);
    color: var(--brand-primary);
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.pc-add-cart:hover {
    background: var(--brand-primary);
    color: #fff;
}
.pc-add-cart--disabled {
    background: #f3f4f6;
    color: var(--text-muted);
    cursor: not-allowed;
}
.fs-xs { font-size: .68rem; }
</style>
