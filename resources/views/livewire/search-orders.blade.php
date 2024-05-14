<div class="card mb-4 mb-xl-0">
    <div class="card-header">
        List Product
        <div class="ms-auto text-secondary">
            Search:
            <div class="ms-2 d-inline-block">
                <input type="text" wire:model.live="search" class="form-control form-control-sm"
                    aria-label="Search product">
            </div>
        </div>
    </div>


    <div class="card-body">
        <div class="col-lg-12">
            <x-spinner.loading-spinner />
            <div class="table-responsive">
                <table wire:loading.remove class="table table-striped table-bordered align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">SKU</th>
                            <th scope="col">Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="text-center">
                                    {{ $product->sku }}
                                </td>
                                <td class="text-center">
                                    {{ $product->name }}
                                </td>
                                <td class="text-center">
                                    {{ $product->quantity }}
                                </td>
                                <td class="text-center">
                                    {{ number_format($product->cost_price, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <form action="{{ route('pos.addCartItem', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <input type="hidden" name="name" value="{{ $product->name }}">
                                            <input type="hidden" name="sale_price" value="{{ $product->cost_price }}">

                                            <button type="submit" class="btn btn-icon btn-outline-primary">
                                                <x-icon.cart />
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-icon btn-outline-warning ms-2"
                                            data-bs-toggle="modal" data-bs-target="{{ '#' . $product->id }}">
                                            <x-icon.eye />
                                        </button>
                                    </div>
                                </td>
                                <div class="modal modal-lg" id="{{ $product->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    {{ $product->name }}
                                                </h5>
                                                <button type="button" class="close btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mx-auto">
                                                            <div class="row mb-3">
                                                                <div class="col-6">Name</div>
                                                                <div class="col-6">{{ $product->name }}</div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-6">Cost Price</div>
                                                                <div class="col-6">{{ $product->cost_price }}</div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-6">Sale Price</div>
                                                                <div class="col-6">{{ $product->sale_price }}</div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-6">Whole Sale Price</div>
                                                                <div class="col-6">{{ $product->whole_sale_price }}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-6">Quantity</div>
                                                                <div class="col-6">{{ $product->quantity }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="6" class="text-center">
                                    Data not found!
                                </th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
