@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css\bootstrap.min.css') }}">

<style>
    #frame {
        margin-top: 200px;
        margin-left: 200px;
        margin-right: 200px;
    }

    #selectItem {
        width: 200px;
        margin-bottom: 20px;
    }

    #price {
        padding-bottom: 20px;
        width: 200px;
        margin-bottom: 20px;
    }

    #quantity {
        padding-bottom: 20px;
        padding-top: 20px;
        width: 200px;
    }

    #total {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .title {
        margin-top: 30px;
        font-size: 50px;
        margin-left: 50px;
    }

    #labalitem {
        margin-right: 10px;
    }

</style>
<div class="title">
    Add Item To Cart
</div>

<div class="container" id="frame">
    <div class="row">
        <label for="selectItem" id="labalitem"> Select the Item</label>
        <select id="selectItem" class="custom-select">
            <option selected>Select Item</option>
            @foreach($items as $item)
                <option id="itemId" value="{{ $item->id }}">{{ $item->item_name }}</option>

            @endforeach
        </select>

    </div>

    <input class="form-control" id="price" readonly value="0">


    <input class="form-control" id="quantity" type="number" min="0">

    <div class="row"> Total Price
        <div id="total"></div>
    </div>
    <button id="addItem" class="btn-info">Add to Cart</button>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        <tbody id="tdata"></tbody>
    </table>

    <button id="save" class="btn btn-success">Save Invoice</button>
</div>

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
            success: function () {
                console.log();
            }
        });

        content = "<tr>"

        jQuery.each(createList, function (x, val) {
            content += '<td>' + val + '</td>';
        });
        content += "</tr>"

        $('#tdata').append(content);

    });

    $("#save").click(function () {

        $.ajax({
            url: "{{route('saveorder')}}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                data: itmearr,
            },
            success: function (data) {
                console.log('success');
            }
        });
    });

</script>


