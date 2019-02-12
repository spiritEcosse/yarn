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
            <div class="buttons" >
                <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
            </div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

            <table class="list">
                <thead>
                <tr>
                    <td class="left" >
                        Название категории
                    </td>
                    <td class="left" >
                        Сортировка
                    </td>
                    <td></td>
                </tr>
                </thead>
                <tbody id="category_fabric">
                <?php $numb = 0; ?>
                
                <?php foreach ($categories_fabric as $fabric) { ?>
                    <tr id="category_fabric_<?php echo $numb; ?>">
                        <td class="left" >
                            <input type="hidden" name="category_fabric[<?php echo $numb; ?>][fabric_id]" value="<?php echo $fabric['fabric_id']; ?>" />
                            <input type="text" name="category_fabric[<?php echo $numb; ?>][name]; ?>" size="20" maxlength="100" value="<?php echo $fabric['name']; ?>" />
                        <?php if (isset($error_category_fabric[$numb])) { ?>
                        <span class="error"><?php echo $error_category_fabric[$numb]; ?></span>
                        <?php }?>
                        </td>
                        <td class="left" >
                            <input type="number" name="category_fabric[<?php echo $numb; ?>][sort_order]" value="<?php echo $fabric['sort_order']; ?>" >
                        </td>
                        <td class="left" >
                            <?php $row_id = 'category_fabric_' . $numb; ?>
                            
                            <?php if (isset($error_category_fabric[$numb])) { ?>
                                <a onclick="if (confirm('Удаление невозможно отменить! Вы уверены, что хотите это сделать?')) { rowDelete('<?php echo $row_id; ?>'); }" class="button">
                                    <?php echo $button_delete; ?>
                                </a>
                            <?php } else { ?>
                                <?php $fabric_id = $fabric['fabric_id']; ?>
                                <a onclick="if (confirm('Удаление невозможно отменить! Вы уверены, что хотите это сделать?')) { delete_fabric('<?php echo $fabric_id; ?>', '<?php echo $row_id; ?>'); }" class="button">
                                    <?php echo $button_delete; ?>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $numb += 1; ?>
                <?php }?>
                </tbody>
                <tr>
                    <td></td><td></td>
                    <td class="left" >
                        <a onclick="insert_category();" class="button">
                            <?php echo $text_insert; ?>
                        </a>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
    var token = "<?php echo $_GET['token']; ?>";
    var count_category = "<?php echo count($categories_fabric); ?>";
    
function insert_category() {
    var category_fabric = document.getElementById('category_fabric');
    var tr = document.createElement('tr');
    var td_1 = document.createElement('td');
    var td_2 = document.createElement('td');
    var td_3 = document.createElement('td');
    var input_1 = document.createElement('input');
    var input_hidden_1 = document.createElement('input');
    var input_2 = document.createElement('input');
    var link = document.createElement('a');
    
    tr.setAttribute('id', 'category_fabric_' + count_category);
    td_1.setAttribute('class', 'left');
    td_2.setAttribute('class', 'left');
    td_3.setAttribute('class', 'left');
    
    input_1.setAttribute('type', 'text');
    input_1.setAttribute('name', 'category_fabric[' + count_category + '][name]')
    input_1.setAttribute('size', '20');
    input_1.setAttribute('maxlength', '100');
    input_1.setAttribute('value', '');
    input_hidden_1.setAttribute('type', 'hidden');
    input_hidden_1.setAttribute('name', 'category_fabric[' + count_category + '][fabric_id]');
    input_hidden_1.setAttribute('value', '');
    input_2.setAttribute('type', 'number');
    input_2.setAttribute('value', '');
    input_2.setAttribute('name', 'category_fabric[' + count_category + '][sort_order]')
    link.setAttribute('onclick', 'if (confirm("Удаление невозможно отменить! Вы уверены, что хотите это сделать?")) { rowDelete("category_fabric_' + count_category + '"); }');
    link.setAttribute('class', 'button');
    link.innerHTML = 'Удалить';
    
    td_1.appendChild(input_1);
    td_1.appendChild(input_hidden_1);
    td_2.appendChild(input_2);
    td_3.appendChild(link);
    
    tr.appendChild(td_1);
    tr.appendChild(td_2);
    tr.appendChild(td_3);
    
    category_fabric.appendChild(tr);
    count_category++;
}

function rowDelete(row_id) {
   var row = document.getElementById(row_id);
   row.parentNode.removeChild(row);
}

function delete_fabric(fabric_id, row_id) {
var url = 'index.php?route=catalog/category_fabric/delete&token=' + token;

$.get(
    url,
    "fabric_id=" + fabric_id,
    function (message) {
            alert(message);
            
            rowDelete(row_id);
    },
    "json"
);
}
</script>