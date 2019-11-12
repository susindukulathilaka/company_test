@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css\bootstrap.min.css') }}">

<body>
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4 text-center">Add Item To Cart</h1>
    </div>
</div>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-sm-2 text-right pt-3">
            Select Item
        </div>
        <div class="col-sm-3 pt-3">
            <select id="selectItem" class="custom-select w-100">
                <option selected>Select Item</option>
                @foreach($items as $item)
                    <option id="itemId" value="{{ $item->id }}">{{ $item->item_name }}</option>

                @endforeach
            </select>
        </div>
        <div class="w-100"></div>
        <div class="col-sm-2 text-right pt-3">
            Item Price
        </div>
        <div class="col-sm-3 pt-3">
            <input class="form-control form-control-sm w-100" id="price" readonly value="0">
        </div>
        <div class="w-100"></div>
        <div class="col-sm-2 pt-3 text-right">
            Item Quantity
        </div>
        <div class="col-sm-3 pt-3">
            <input class="form-control form-control-sm w-100" id="quantity" type="number" min="0">
        </div>
        <div class="w-100"></div>
        <div class="col-sm-2 pt-3 text-right">
            <p>Total Price</p>
        </div>
        <div class="col-sm-3 pt-3">
            <p id="total"></p>
        </div>
        <div class="w-100"></div>
        <div class="col-sm-2 pt-3"></div>
        <div class="col-sm-2 text-left pt-3">
            <button id="addItem" class="btn-info btn btn-block col">Add to Cart</button>
        </div>
        <div class="col-sm-1 pt-3"></div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-sm-5 pt-3 mb-5">
            <table class="table">
                <tr>
                    <th>Item Name</th>
                    <th>Item Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <tbody id="tdata"></tbody>
            </table>
        </div>
        <div class="w-100"></div>
        <div class="col-sm-2 pt-3">
            <button id="save" class="btn btn-success">Save Invoice</button>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger" id="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
    $("#selectItem").change(function () {

        var id = $("#selectItem").val();
        var url = "{{route('itemprice', ':id')}}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                console.log(data);
                $('#price').val(data.html.item_price);
            }
        });
    });

    $("#quantity").change(function () {
        var quant = $("#quantity").val();
        var price = $("#price").val();
        var totalPrice = quant * price;
        $('#total').html(totalPrice);
    });

    var itmearr = [];
    var listData;

    function addItemData(name, price, quant, total) {
        this.tname = name;
        this.tprice = price;
        this.tquant = quant;
        this.ttotal = total;
    };
    
    $("#addItem").click(function () {

        var itemName = $("#selectItem :selected").text();
        var price = $("#price").val();
        var quant = $("#quantity").val();
        var total = $("#total").text();

        var createList = new addItemData(itemName, price, quant, total);

        itmearr.push(createList);

        $.ajax({
            url: "{{route('addtocart')}}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                data: itmearr,
            },
            success: function (data) {
                listData = data.html;
                content = "";

                jQuery.each(data.html, function (x, val) {
                    content += '<tr>' +
                        '<td>' + val.itemName + '</td>' +
                        '<td>' + val.itemPrice + '</td>' +
                        '<td>' + val.itemQuant + '</td>' +
                        '<td>' + val.totalPrice + '</td>';
                });
                content += "</tr>"

                $('#tdata').html(content);
            }
        });
    });

    $("#save").click(function () {
        $.ajax({
            url: "{{route('saveorder')}}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                data: listData,
            },
            success: function (data) {
                $('#error').html(data);
            }
        });
    });

</script>


