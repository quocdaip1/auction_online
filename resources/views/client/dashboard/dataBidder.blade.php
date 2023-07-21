<div class="table-title-area">
    <h3>Products I've Bidden on in Auctions</h3>

</div>
{{-- @php
    dd($list_bids);
@endphp --}}

<div class="table-wrapper">
    <table class="eg-table order-table table mb-0">
        <thead>
            <tr>
                <th>Title</th>
                <th>name high bidder</th>
                <th>Current price</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_bids as $auction)
                @php
                    $imagePath = public_path('image/imageProducts/user_' . $auction->user_id . '/product_' . $auction->product_id . '/' . $auction->product_image);
                    $imageUrl = asset('image/imageProducts/user_' . $auction->user_id . '/product_' . $auction->product_id . '/' . urlencode($auction->product_image));
                    $defaultImagePath = asset('image/imageProducts/no_image_available-product.png');
                    
                    // Kiểm tra xem tệp tin có tồn tại trong thư mục "user_" hay không
                    if (!file_exists($imagePath)) {
                        $imageUrl = $defaultImagePath;
                    }



                    $highest_bid = DB::table('bids')
                    ->join('auctions', 'bids.auction_id', '=', 'auctions.id')
                    ->join('user_info', 'bids.user_id', '=', 'user_info.user_id')
                    ->where('auctions.product_id', '=',$auction->id)
                    ->orderBy('bids.amount', 'desc') // Sort by bid amount in descending order
                    ->select('user_info.name', 'bids.amount')
                    ->first();
                @endphp
               
                <tr>
                    <td data-label="Title">{{ $auction->product_name }}</td>
                    <td data-label="Bidding ID">{{$highest_bid->name}}</td>
                    <td data-label="Bid Amount(USD)">{{$auction->current_price?$auction->current_price: $auction->starting_price }}</td>
                    <td data-label="Image"><img alt="image" src="{{$imageUrl}}" class="img-fluid"></td>
                    <td data-label="Status" class="text-green">
                        @php
                        switch ($auction->status) {
                            case 1:
                                echo 'Pending Confirmation';
                                break;
                            case 2:
                                echo 'Confirmed';
                                break;
                            case 3:
                                echo 'In progress';
                                break;
                            case 4:
                                echo 'Auction ended';
                                break;
                            default:
                                echo 'Unknown';
                                break;
                        }
                    @endphp
                    </td>
                    <td data-label="Action">
                        <a class="btn btn-danger"
                        href="{{ route('client.productDetails', ['id' => $auction->product_id]) }}">Details</a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>

<div class="table-pagination" data-table="table2">
    {{ $list_bids->links('vendor.pagination.paginationcustom') }}
</div>
