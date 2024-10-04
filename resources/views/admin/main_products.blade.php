@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h5>Products</h5>
</div>
    <div class="row">
        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="productManagementTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="approved-products-tab" data-bs-toggle="tab" href="#approved-products" role="tab" aria-controls="approved-products" aria-selected="true">Approved Products</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pending-products-tab" data-bs-toggle="tab" href="#pending-products" role="tab" aria-controls="pending-products" aria-selected="false">Pending Approval</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="productManagementTabContent">
                <!-- Approved Products Tab -->
                <div class="tab-pane fade show active" id="approved-products" role="tabpanel" aria-labelledby="approved-products-tab">
                    <div class="card mt-3 shadow">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Brand Name</th>
                                        <th>Generic Name</th>
                                        <th>Dosage</th>
                                        <th>Form</th>
                                        <th>Age Group</th>
                                        <th>OTC</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mainProducts as $mainProduct)
                                        <tr>
                                            <td>{{ $mainProduct->general_id }}</td>
                                            <td>{{ $mainProduct->brand_name }}</td>
                                            <td>{{ $mainProduct->generic_name }}</td>
                                            <td>{{ $mainProduct->dosage }}</td>
                                            <td>{{ $mainProduct->form }}</td>
                                            <td>{{ $mainProduct->age_group }}</td>
                                            <td>{{ $mainProduct->over_the_counter ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('main_products.edit', $mainProduct->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('main_products.destroy', $mainProduct->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $mainProducts->links() }} <!-- Pagination for approved products -->
                        </div>
                    </div>
                </div>

                <!-- Pending Approval Products Tab -->
                <div class="tab-pane fade" id="pending-products" role="tabpanel" aria-labelledby="pending-products-tab">
                    <div class="card mt-3 shadow">
                        <div class="card-body">
                            <form action="{{ route('admin.approve_multiple_products') }}" method="POST">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th> <!-- Select all checkbox -->
                                            <th>Brand Name</th>
                                            <th>Generic Name</th>
                                            <th>Dosage</th>
                                            <th>Form</th>
                                            <th>Age Group</th>
                                            <th>OTC</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($unapprovedProducts as $product)
                                            <tr>
                                                <td><input type="checkbox" name="products[]" value="{{ $product->id }}"></td> <!-- Product checkbox -->
                                                <td>{{ $product->brand_name }}</td>
                                                <td>{{ $product->generic_name }}</td>
                                                <td>{{ $product->dosage }}</td>
                                                <td>{{ $product->form }}</td>
                                                <td>{{ $product->age_group }}</td>
                                                <td>{{ $product->over_the_counter ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.approve_product', $product->id) }}" class="btn btn-sm btn-success">Approve</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-sm btn-success">Approve Selected</button> <!-- Approve button -->
                            </form>
                            {{ $unapprovedProducts->links() }} <!-- Pagination for unapproved products -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    // Script to handle select all functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="products[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>

@endsection

@section('styles')
<style>
    .nav-tabs .nav-link {
        font-weight: 600;
        color: #4e73df;
    }

    .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #4e73df;
        border-color: #4e73df;
    }

    .card {
        border: 1px solid #dee2e6;
    }

    .table thead th {
        font-weight: bold;
        background-color: #f8f9fc;
    }

    .table tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>
@endsection
