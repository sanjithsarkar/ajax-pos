<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>

<body>
    <section id="pos" style="margin-top: 10px;">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Monthly Recap Report</h6>
                        <a class="btn btn-sm btn-info">
                            <font color="FFFFFF">Add Customer</font>
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="font-size:15px;">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>id</th>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posItems as $index => $posItem)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $posItem->name }}</td>
                                            <td><input type="text" value="{{ $posItem->quantity }}" readonly
                                                    style="width: 60px;"><br>
                                                <button data-quantity="{{ $posItem->quantity }}"
                                                    data-id="{{ $posItem->id }}"
                                                    class="badge badge-sm badge-success increase-quantity">+</button>
                                                {{-- <button class="badge badge-sm badge-success increase-quantity" onclick="increase({{ $posItem->pro_id }})">+</button> --}}
                                                @if ($posItem->quantity >= 2)
                                                    <button class="badge badge-sm badge-danger decrease-quantity"
                                                        onfunction="decrease()">-</button>
                                                @else
                                                    <button class="badge badge-sm badge-danger" disabled>-</button>
                                                @endif

                                            </td>
                                            <td>{{ $posItem->price }}</td>
                                            <td><span class="badge badge-success">{{ $posItem->sub_total }}</span></td>
                                            <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
                                            <td><button class="badge badge-sm badge-danger"
                                                    @click.prevent="deleteItem(cart.id)">X</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer"></div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">Total
                                Quantity:
                                <strong id="totalQuantity"></strong>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">Sub Total:
                                <strong>$</strong>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">Discount(%):
                                <input type="number" v-model="discount" class="form-control">
                                <strong>($)</strong>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">Total:
                                <strong>$</strong>
                            </li>
                        </ul>
                        <br>
                        <form @submit.prevent="orderDone">
                            <label>Customer Name</label>
                            <select class="form-control" name="Customer">
                                <option selected>Select Customer</option>
                                {{-- <option :value="customer.id" v-for="customer in customerData.data">{{ customer.name }}
                                </option> --}}
                            </select>

                            <label>Payment Receive</label>
                            <input type="number" id="paymentReceive" name="paymentReceive" class="form-control">

                            <label for="due">Due</label>
                            <li class="list-group-item">
                                <strong>$</strong>
                            </li>


                            <label for="pay by">Pay By</label>
                            <select class="form-control" name="payby" id="payby">
                                <option value="HandCash">Hand Cash</option>
                                <option value="Bkash">Bkash</option>
                                <option value="Cheaque">Cheaque</option>
                                <option value="GiftCard">GiftCard</option>
                            </select>
                            <br>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        Products Sold
                    </div>
                    <div class="card-body">
                        <input type="text" name="searchQuery" id="searchQuery" placeholder="Search Product">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">

                        @foreach ($products as $product)
                            <button class="btn btn-sm addToPos" data-pro_id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-quantity="1">


                                <div class="card" style="margin-bottom: 10px; width: 11rem;">
                                    <div class="image d-flex justify-content-center mt-2">
                                        {{-- <img class="" :src="product.image_url" alt="no"
                                            :height="50" :width="60"> --}}
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5><br>
                                        <div class=""><br>
                                            Price: <span
                                                class="text-start badge badge-success">{{ $product->price }}</span><br>
                                            @if ($product->quantity >= 1)
                                                Quantity: <span class="badge badge-success">Available
                                                    {{ $product->quantity }}</span>
                                            @else
                                                <span class="badge badge-danger">Stock Out</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    {{-- <script>
        // Get a reference to the button element
        var button = document.getElementById("myButton");
      
        // Add a click event listener to the button
        button.addEventListener("click", function() {
          alert("Button clicked!");
        });
      
        // Programmatically trigger a click event on the button
        button.click();
      </script> --}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $(".addToPos").on("click", function() {

                // Get values from input fields
                var pro_id = $(this).data("pro_id");
                var name = $(this).data("name");
                var price = $(this).data("price");
                var quantity = $(this).data("quantity");
                var sub_total = price * quantity;

                // window.alert(proId);

                // Create an object with the data
                var data = {
                    pro_id: pro_id,
                    name: name,
                    price: price,
                    quantity: quantity,
                    sub_total: sub_total,
                    _token: "{{ csrf_token() }}",
                };

                // Send the data to the server using Ajax
                $.ajax({
                    type: "POST",
                    url: "/insert/pos", // Replace with the actual server endpoint
                    data: data,
                    success: function(response) {
                        // Handle the server's response (if needed)
                        console.log(response);
                        alert("Item added to POS");
                    },
                    error: function(error) {
                        // Handle errors (if any)
                        console.error(error);
                        alert("Failed to add item to POS");
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $(".increase-quantity").on("click", function() {
                var proId = $(this).data("id");
                increaseQuantity(proId);
            });
        });

        function increaseQuantity(proId) {
            // Perform an AJAX request to increase the quantity on the server.
            $.ajax({
                type: "GET",
                url: "/increase/quantity/" + proId,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Handle the server's response (if needed)
                    console.log(response);
                    // alert("Item Increase Successfully");
                    // You can update the quantity displayed on the page here.
                    // Reload the page to reflect the updated quantity
                    location.reload();
                },
                error: function(error) {
                    // Handle errors (if any)
                    console.error(error);
                    alert("Failed to Increase Item");
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            // Make an AJAX request to fetch the total quantity from the server
            $.ajax({
                type: "GET",
                url: "/total/quantity", // Replace with your actual API endpoint
                success: function(data) {
                    // Update the content of the totalQuantity element with the fetched data
                    updateTotalQuantity(data); // Assuming your data structure includes 'totalQuantity'
                },
                error: function(error) {
                    // Handle errors (if any)
                    console.error(error);
                }
            });

            // Function to update the content of the totalQuantity element
            function updateTotalQuantity(quantity) {
                $("#totalQuantity").text(quantity);
            }
        });
    </script>
</body>

</html>
