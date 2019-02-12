<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>

    <div class="box">
            <div class="heading">
                <h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
                <div class="buttons"><a onclick="updatePrice();" class="button"><?php echo $button_update; ?></a></div>
            </div>
        <div class="content">
            <table class="form" >
                <tbody>
                    <tr>
                        <td class="left"><?php echo $text_manufacturer; ?></td>
                        <td>
                            <select id="manufacturer">
                                <option value="0" selected="selected"><?php echo $text_none; ?></option>
                                <?php foreach ($manufacturers as $manufacturer) { ?>
                                    <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="left"><?php echo $text_product; ?></td>
                        <td class="longscroll">
                            <div class="container_box">
                            <div class="scrollbox">
                                <div id="product_copy_id">
                                    <div id="product_list_id">
                                    </div>
                                </div>
                            </div>
                                <a onclick="$(this).parent().find(':checkbox').attr('checked', true);">
                                    <?php echo $text_select_all; ?>
                                </a> /
                                <a onclick="$(this).parent().find(':checkbox').attr('checked', false);">
                                    <?php echo $text_unselect_all; ?>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="left"><?php echo $text_update; ?></td>
                        <td>
                            <select id="type">
                                <option value="0" select="selected"><?php echo $text_none; ?></option>
                                <option value="1"><?php echo $text_increase; ?></option>
                                <option value="2"><?php echo $text_reduce; ?></option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="left"><?php echo 'Таблицы'; ?></td>
                        <td>
                            <select id="type_table">
                                <option value="0">Все таблицы - доп. опции</option>
                                <option value="2">Все таблицы + доп. опции</option>
                                <option value="1">Только доп. опции</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="left"><?php echo $text_factor; ?></td>
                        <td>
                            <select id='factor'>
                                <option value="0"><?php echo $text_none; ?></option>

                                <?php for ($count = 1; $count < 100; $count++) { ?>
                                    <option value="<?php echo $count / 100; ?>"><?php echo $count; ?></option>
                                <?php } ?>
                            </select>
                            <?php echo $text_percent; ?>
                            <div>или</div>
                            <div>
                                <input type="number" id="fix_number">&#164;
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Акция:
                        </td>
                        <td>
                            <select id="special">
                                <option value="0">Нет</option>
                                <option value="1">Да</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Дата начала акции:
                        </td>
                        <td>
                            <input type="text" id="date_start" value="" class="date" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Дата окончания акции:
                        </td>
                        <td>
                            <input type="text" id="date_end" value="" class="date" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
var token = "<?php echo $_GET['token']; ?>";
$('.date').datepicker({dateFormat: 'yy-mm-dd'});

function loading(div) {
        var bmodal = document.createElement('div');
        bmodal.setAttribute("id", "modal-product");

        var img = document.createElement('img');
        img.src = "view/image/loading-admin.gif";

        bmodal.appendChild(img);
        div.appendChild(bmodal);
}

function deleteLoading() {
    var elem = document.getElementById('modal-product');
    elem.parentNode.removeChild(elem);
}

function loadingbig() {
    var arcticmodal = document.createElement("div");
    arcticmodal.setAttribute("id", "arcticmodal-overlay");
    arcticmodal.setAttribute("style", "background-color: rgb(0, 0, 0); opacity: 0.6;");
    document.body.appendChild(arcticmodal);

    var modal = document.createElement('div');
    modal.setAttribute("id", "arcticmodal-container");

    var table = document.createElement('table');
    table.setAttribute("id", "arcticmodal-container_i");

    var tbody = document.createElement('tbody');
    var tr = document.createElement('tr');
    var td = document.createElement('td');
    td.setAttribute("id", "arcticmodal-container_i2");

    var bmodal = document.createElement('div');
    bmodal.setAttribute("id", "b-modal");

    var img = document.createElement('img');
    img.src = "view/image/loading-admin.gif";

    bmodal.appendChild(img);
    td.appendChild(bmodal);
    tr.appendChild(td);
    tbody.appendChild(tr);
    table.appendChild(tbody);
    modal.appendChild(table);
    document.body.appendChild(modal);
}

function loadingbigDel() {
    var elem = document.getElementById('arcticmodal-container');
    elem.parentNode.removeChild(elem);

    var elem = document.getElementById('arcticmodal-overlay');
    elem.parentNode.removeChild(elem);
}

function listProduct() {
    var manufacturer_id = $('#manufacturer').val();

    if (manufacturer_id == '0') {
         $('#product_list_id').html('');
         return(false);
    }

    $('#product_list_id').html('');

    loading(product_copy_id);

    var url  = "index.php?route=catalog/product_price/getProduct&token=" + token;

    $.get(
        url,
        "manufacturer_id=" + manufacturer_id,
        function (product) {
            if (product.type == 'error') {
                alert(product.message);
                return(false);
            } else {
                var div = '';

                $(product.data).each(function() {
                    div += '<div id="product_id">';
                    div += '<input type="checkbox" id="product_data" value="' + $(this).attr('product_id') + '"';
                    div += '>';
                    div +=    $(this).attr('name') + " (" + $(this).attr('model') + ")";
                    div += '</div>';
                });
                $('#product_list_id').html(div);
            }
        },
        "json"
    );

    deleteLoading();
};

function updatePrice() {
    var product = new Array();
    var tableElem = document.getElementById('product_list_id');
    var elements = tableElem.getElementsByTagName('input');
    var text_confirm = 'Проверьте правильность данных: \n\n';
    text_confirm += 'Производитель: ' + $('#manufacturer option[value="' + $('#manufacturer').val() + '"]').text() + '\n';

    for (var i = 0, j = 0; i < elements.length; i++) {
        var input = elements[i];

        if (input.checked == true) {
            product[j] = input.value;
            j++;
        }
    }

    if (product.length == '0') {
        alert('Не выбран товар!');
        return(false);
    }

    var type = $('#type').val();

    if (type == '0') {
        alert('Не выбран тип изменения!');
        return(false);
    }

    text_confirm += 'Изменить как: ' + $('#type option[value="' + $('#type').val() + '"]').text() + '\n';

    var factor = $('#factor').val();
    var fix_number = $('#fix_number').val();

    if ((fix_number == '' && factor == '0') || (fix_number != '' && factor != '0')) {
        var fail = 'Сделайте выбор или поле ¤ или коэффициент';
        alert(fail);
        return false;
    }

    text_confirm += 'Числовой коэффициент: ';

    var type_table = $("#type_table").val();

    var url = 'index.php?route=catalog/product_price/updatePrice&token=' + token;
    url += '&product=' + product + '&type=' + type + '&type_table=' + type_table;

    if (fix_number != '') {
        url += '&fix_number=' + fix_number;
        text_confirm += $('#fix_number').val() + ' ¤\n';
    } else if (factor != '0') {
        url += '&factor=' + factor;
        text_confirm += $('#factor option[value="' + $('#factor').val() + '"]').text() + ' %\n';
    }

    text_confirm += 'Таблицы: ' + $('#type_table option[value="' + $('#type_table').val() + '"]').text() + '\n';
    text_confirm += 'Акция: ' + $('#special option[value="' + $('#special').val() + '"]').text() + ' \n';

    if ($('#special').val() == 1) {
        if ($('#date_start').val() == '') {
            alert('Дата начала акции не определена');
            return false;
        } else {
            text_confirm += 'Дата начала акции: ' + $('#date_start').val() + '\n';
        }

        if ($('#date_end').val() == '') {
            alert('Дата окончания акции не определена');
            return false;
        } else {
            text_confirm += 'Дата окончания акции: ' + $('#date_end').val() + '\n';
        }
    }

    if (confirm(text_confirm) == false) {
        return false;
    }

    url += '&special=' + $('#special').val() + '&date_start=' + $('#date_start').val() + '&date_end=' + $('#date_end').val();

    loadingbig();

    $.get(
        url,
        function (result) {
            alert(result.message);
            window.location.reload();
            loadingbigDel();
        },
        "json"
    );
}

$('#manufacturer').change(listProduct);
</script>
<?php echo $footer; ?>