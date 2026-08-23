<?php

namespace Rehla\Dashboard\Http\Controllers\Customers\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use Rehla\Dashboard\Http\Controllers\Controller;
use Rehla\Dashboard\Http\Resources\WishlistItemResource;

class WishlistController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected WishlistRepository $wishlistRepository) {}

    /**
     * Returns the compare items of the customer.
     */
    public function items(int $id): JsonResource
    {
        $wishlistItems = $this->wishlistRepository
            ->with('product')
            ->where('customer_id', $id)
            ->get();

        return WishlistItemResource::collection($wishlistItems);
    }

    /**
     * Removes the item from the cart if it exists.
     */
    public function destroy(int $id): JsonResource
    {
        $this->validate(request(), [
            'item_id' => 'required|exists:wishlist_items,id',
        ]);

        $itemId = request()->input('item_id');

        Event::dispatch('customer.wishlist.delete.before', $itemId);

        $this->wishlistRepository->delete(request()->input('item_id'));

        Event::dispatch('customer.wishlist.delete.after', $itemId);

        return new JsonResource([
            'message' => trans('dashboard::app.customers.customers.view.wishlist.delete-success'),
        ]);
    }
}
