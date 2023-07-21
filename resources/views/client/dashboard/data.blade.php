    <div class="table-title-area">
        <h3>All Products</h3>
    </div>
    <div class="table-wrapper">
        <table class="eg-table order-table table mb-0">
            <thead>
                <tr>
                    <th>Name product</th>
                    <th>Auctions ID</th>
                    <th>Current Price(USD)</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="itemlist-user">
                @foreach ($auctions as $auction)
                    @php
                        $imagePath = public_path('image/imageProducts/user_' . $user_login->id . '/product_' . $auction->product_id . '/' . $auction->product_image);
                        $imageUrl = asset('image/imageProducts/user_' . $user_login->id . '/product_' . $auction->product_id . '/' . urlencode($auction->product_image));
                        $defaultImagePath = asset('image/imageProducts/no_image_available-product.png');
                        
                        // Kiểm tra xem tệp tin có tồn tại trong thư mục "user_" hay không
                        if (!file_exists($imagePath)) {
                            $imageUrl = $defaultImagePath;
                        }
                    @endphp

                    <tr>
                        <td data-label="Title">{{ $auction->product_name }}</td>
                        <td data-label="Bidding ID">{{$auction->id}}</td>
                        <td data-label="Current price(USD)">
                            {{ $auction->current_price ? $auction->current_price : $auction->starting_price }}</td>
                        <td data-label="Image"><img alt="image" src="{{ $imageUrl }}" class="img-fluid"></td>
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
    <div class="table-pagination"  data-table="table1">
        {{ $auctions->links('vendor.pagination.paginationcustom') }}
    </div>
