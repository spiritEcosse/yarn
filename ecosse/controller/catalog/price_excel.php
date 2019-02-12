<?php

ini_set("memory_limit","512M");
ini_set("max_execution_time",18000);
//set_time_limit( 60 );
chdir( '../system/PHPExcel' );
require_once( 'Classes/PHPExcel.php' );

class ControllerCatalogPriceExcel extends Controller {
    private $error = array();
    private $column_tag = 1;
    private $column_product_id = 2;
    private $column_option_vert = 4;
    private $column_option_value_vert = 5;
    private $column_prefix_price_first_list = 6;
    private $column_main_price = 7;
    private $column_after_price_first_list = 8;
    private $column_option_hor = 9;
    private $start_row = 0;
    private $start_row_second_list = 1;
    private $start_row_third_list = 1;
    private $column_price_second_list = 6;
    private $column_prefix_price_tree_list = 4;
    private $column_price_tree_list = 5;

    public function index() {
        $this->getForm();
    }

    public function getForm() {
        $this->load->language('catalog/priceExcel');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['heading_title'] = $this->language->get('heading_title');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/price_excel', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->template = 'catalog/priceExcel.tpl';
        $this->data['action'] = $this->url->link('catalog/price_excel/write', 'token=' . $this->session->data['token'], 'SSL');

        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function write() {
        $this->load->language('catalog/priceExcel');

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $uploadfile = DIR_UPLOAD_EXCEL . basename($_FILES['file_excel']['name']);
            $this->load->model('catalog/product');
            $this->load->model('catalog/option');
            $this->load->model('localisation/price_prefix');
            $this->load->model('localisation/price_after');

            if (move_uploaded_file($_FILES['file_excel']['tmp_name'], $uploadfile)) {
                $inputFileType = PHPExcel_IOFactory::identify($uploadfile);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                $reader = $objReader->load($uploadfile);

                if ($this->excelValid($reader)) {
                    $number_table = $this->writeFirstList($reader);

                    if ($reader->getSheet(1)) {
                        $this->writeSecondList($reader, $number_table);
                    }

                    if ($reader->getSheet(2)) {
                        $this->writeThirdList($reader);
                    }

                    $this->session->data['success'] = $this->language->get('text_success');
                    $this->redirect($this->url->link('catalog/price_excel', 'token=' . $this->session->data['token'], 'SSL'));
                }
            } else {
                $this->error['warning'][] = 'Файл не загружен.';
            }
        }

        $this->getForm();
    }

    public function writeThirdList($reader) {
        $data = $reader->getSheet(2);
        $count_rows = $data->getHighestRow();

        for ($this_row = $this->start_row_third_list; $this_row < $count_rows; $this_row++) {
            $this_product_id = trim($this->getCell($data, $this_row, $this->column_product_id));
            $this->model_catalog_product->deleteProductPrice($this_product_id);
        }

        for ($this_row = $this->start_row_third_list; $this_row < $count_rows; $this_row++) {
            $this_product_id = trim($this->getCell($data, $this_row, $this->column_product_id));

            $prefix_price = trim($this->getCell($data, $this_row, $this->column_prefix_price_tree_list));
            $data_prefix_price = $this->model_localisation_price_prefix->getPrefixByName($prefix_price);
            $price_prefix_id = $data_prefix_price['price_prefix_id'];
            $price = trim($this->getCell($data, $this_row, $this->column_price_tree_list));

            if ((substr($price, 0, 1) === '=' ) && (strlen($price) > 1)) {
                $price = trim($this->getCellgetOldCalculatedValue($data, $this_row, $this->column_price_tree_list));
            }

            $price = round($price);
            $this->model_catalog_product->addProductPrice($this_product_id, $price_prefix_id, $price);
        }
    }

    public function writeSecondList($reader, $number_table) {
        $data = $reader->getSheet(1);
        $count_rows = $data->getHighestRow();
        $number_table += 1;
        $id_option_value_hor = 0;

        for ($this_row = $this->start_row_second_list, $counter = 1; $this_row < $count_rows; $this_row++, $counter++) {
            $options = False;
            $write_base = False;

            $this_product_id = trim($this->getCell($data, $this_row, $this->column_product_id));

            if ($this_row - 1 >= $this->start_row_second_list) {
                $prev_product_id = trim($this->getCell($data, $this_row - 1, $this->column_product_id));

                if ($this_product_id == $prev_product_id) {
                    $options = True;
                }
            }

            if ($options == False) {
                $counter = 1;

                $table['table'] = array();

                $table['table'][$number_table] =
                    array(
                        'type_table' => 1,
                        'product_table_id' => '',
                        'product_table_sort' => $number_table,
                        'product_table_name' => ''
                    );
            }

            if ($this_row + 1 <= $count_rows) {
                $next_product_id = trim($this->getCell($data, $this_row + 1, $this->column_product_id));

                if ($this_product_id != $next_product_id) {
                    $write_base = True;
                }
            }

            $option_name = trim($this->getCell($data, $this_row, $this->column_option_vert));
            $id_option = $this->model_catalog_option->getOptionByName($option_name);
            $id_option = $id_option['option_id'];

            if (!isset($table['table'][$number_table]['option_id'][$id_option])) {
                $table['table'][$number_table]['option_id'][$id_option] =
                    array(
                        'product_table_option_id' => '',
                        'vertical' => 1
                    );
            }

            $option_value_name = trim($this->getCell($data, $this_row, $this->column_option_value_vert));
            $id_option_value = $this->model_catalog_option->getOptionValueByName($id_option, $option_value_name);
            $id_option_value = $id_option_value['option_value_id'];

            $table['table'][$number_table]['option_id'][$id_option]['product_table_option_value'][$id_option_value] =
                array(
                    'option_value_id' => $id_option_value,
                    'product_table_option_value_id' => '',
                    'product_table_option_value_sort' => $counter
                );

            $price = trim($this->getCell($data, $this_row, $this->column_price_second_list));

            if((substr($price, 0, 1) === '=' ) && (strlen($price) > 1)) {
                $price = trim($this->getCellgetOldCalculatedValue($data, $this_row, $this->column_price_second_list));
            }

            $price = round($price);

            $table['table'][$number_table]['option_value_horizont'][$id_option_value_hor]['option_value_vertical'][$id_option_value] =
                array(
                    'price' => $price,
                    'product_table_option_value_price_id' => ''
                );

            if ($write_base == True) {
                $this->model_catalog_product->insertProductTable($table, $this_product_id);
                $table['table'] = array();
            }
        }
    }

    public function writeFirstList($reader) {
        $data = $reader->getSheet(0);
        $count_rows = $data->getHighestRow();
        $start = False;
        $number_table = 0;

        for ($this_row = $this->start_row; $this_row <= $count_rows; $this_row++) {
            $this->model_catalog_product->delProductTable(trim($this->getCell($data, $this_row, $this->column_product_id)));
        }

        for ($this_row = $this->start_row; $this_row <= $count_rows; $this_row++) {
            if (trim($this->getCell($data, $this_row, $this->column_tag)) == '&') {
                $start = True;
            }

            if ($start == True) {
                $number_table += 1;
                $ids_option_value_hor = array();

                $count_columns = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn($this_row + 2));
                $option_name = trim($this->getCell($data, $this_row, $this->column_option_hor));
                $id_option_hor = $this->model_catalog_option->getOptionByName($option_name);
                $id_option_hor = $id_option_hor['option_id'];

                $this_row += 1;

                for ($this_column = $this->column_option_hor; $this_column <= $count_columns; $this_column++) {
                    $option_value_name = trim($this->getCell($data, $this_row, $this_column));
                    $id_option_value = $this->model_catalog_option->getOptionValueByName($id_option_hor, $option_value_name);
                    $id_option_value = $id_option_value['option_value_id'];

                    $ids_option_value_hor[] = $id_option_value;
                }

                $this_row += 1;

                for ($counter = 1; $this_row <= $count_rows; $this_row++, $counter++) {
                    $options = False;
                    $set_table = False;
                    $write_base = False;

                    $this_product_id = trim($this->getCell($data, $this_row, $this->column_product_id));

                    if ($this_row - 1 >= $this->start_row) {
                        $prev_product_id = trim($this->getCell($data, $this_row - 1, $this->column_product_id));

                        if ($this_product_id == $prev_product_id) {
                            $options = True;
                        }
                    }

                    if ($options == False) {
                        $main_price = trim($this->getCell($data, $this_row, $this->column_main_price));

                        if((substr($main_price, 0, 1) === '=' ) && (strlen($main_price) > 1)) {
                            $main_price = trim($this->getCellgetOldCalculatedValue($data, $this_row, $this->column_main_price));
                        }

                        $main_price = round($main_price);

                        if (!empty($main_price)) {
                            $this->model_catalog_product->updateProductPrice($this_product_id, $main_price);
                        }

                        $prefix_price = trim($this->getCell($data, $this_row, $this->column_prefix_price_first_list));

                        if ($prefix_price == 'del') {
                            $this->model_catalog_product->updateProductPrefix($this_product_id, 0);
                        } elseif (!empty($prefix_price)) {
                            $data_prefix_price = $this->model_localisation_price_prefix->getPrefixByName($prefix_price);
                            $price_prefix_id = $data_prefix_price['price_prefix_id'];
                            $this->model_catalog_product->updateProductPrefix($this_product_id, $price_prefix_id);
                        }

                        $after_price = trim($this->getCell($data, $this_row, $this->column_after_price_first_list));

                        if ($after_price == 'del') {
                            $this->model_catalog_product->updateProductAfter($this_product_id, 0);
                        } elseif (!empty($after_price)) {
                            $data_after_price = $this->model_localisation_price_after->getAfterByName($after_price);
                            $price_after_id = $data_after_price['price_after_id'];

                            $this->model_catalog_product->updateProductAfter($this_product_id, $price_after_id);
                        }

                        $column_price = $this->column_option_hor;

                        foreach ($ids_option_value_hor as $id_option_value_hor) {
                            $price = trim($this->getCell($data, $this_row, $column_price));
                            $column_price++;

                            if (!empty($price)) {
                                $set_table = True;
                            }
                        }

                        if ($set_table == True) {
                            $table['table'] = array();

                            $table['table'][$number_table] =
                                array(
                                    'type_table' => 0,
                                    'product_table_id' => '',
                                    'product_table_sort' => $number_table,
                                    'product_table_name' => ''
                                );

                            $table['table'][$number_table]['option_id'][$id_option_hor] =
                                array(
                                    'product_table_option_id' => '',
                                    'vertical' => 0
                                );
                        }
                    }

                    $column_price = $this->column_option_hor;
                    $counter_hor = 1;

                    foreach ($ids_option_value_hor as $id_option_value_hor) {
                        $price = trim($this->getCell($data, $this_row, $column_price));

                        if((substr($price, 0, 1) === '=' ) && (strlen($price) > 1)) {
                            $price = trim($this->getCellgetOldCalculatedValue($data, $this_row, $column_price));
                        }

                        $price = round($price);
                        $column_price++;

                        if (!empty($price) && !isset($table['table'][$number_table]['option_id'][$id_option_hor]['product_table_option_value'][$id_option_value_hor])) {
                            $table['table'][$number_table]['option_id'][$id_option_hor]['product_table_option_value'][$id_option_value_hor] =
                                array(
                                    'option_value_id' => $id_option_value_hor,
                                    'product_table_option_value_id' => '',
                                    'product_table_option_value_sort' => $counter_hor
                                );
                        }

                        $counter_hor++;
                    }

                    if ($this_row + 1 <= $count_rows) {
                        $next_product_id = trim($this->getCell($data, $this_row + 1, $this->column_product_id));

                        if ($this_product_id == $next_product_id) {
                            $options = True;
                        } else {
                            $write_base = True;
                        }
                    }

                    $id_option_value = 0;

                    if ($options == True) {
                        $option_name = trim($this->getCell($data, $this_row, $this->column_option_vert));
                        $id_option = $this->model_catalog_option->getOptionByName($option_name);
                        $id_option = $id_option['option_id'];

                        if (!isset($table['table'][$number_table]['option_id'][$id_option])) {
                            $table['table'][$number_table]['option_id'][$id_option] =
                                array(
                                    'product_table_option_id' => '',
                                    'vertical' => 1
                                );
                        }

                        $option_value_name = trim($this->getCell($data, $this_row, $this->column_option_value_vert));
                        $id_option_value = $this->model_catalog_option->getOptionValueByName($id_option, $option_value_name);
                        $id_option_value = $id_option_value['option_value_id'];

                        $table['table'][$number_table]['option_id'][$id_option]['product_table_option_value'][$id_option_value] =
                            array(
                                'option_value_id' => $id_option_value,
                                'product_table_option_value_id' => '',
                                'product_table_option_value_sort' => $counter
                            );
                    }

                    $column_price = $this->column_option_hor;

                    foreach ($ids_option_value_hor as $id_option_value_hor) {
                        $price = trim($this->getCell($data, $this_row, $column_price));

                        if((substr($price, 0, 1) === '=' ) && (strlen($price) > 1)) {
                            $price = trim($this->getCellgetOldCalculatedValue($data, $this_row, $column_price));
                        }

                        $price = round($price);

                        $column_price++;

                        $table['table'][$number_table]['option_value_horizont'][$id_option_value_hor]['option_value_vertical'][$id_option_value] =
                            array(
                                'price' => $price,
                                'product_table_option_value_price_id' => ''
                            );
                    }

                    if ($write_base == True) {
                        $this->model_catalog_product->insertProductTable($table, $this_product_id);
                        $table['table'] = array();
                    }

                    if (trim($this->getCell($data, $this_row, $this->column_tag)) == '#') {
                        $start = False;
                        break;
                    }
                }
            }
        }

        return $number_table;
    }

    public function excelValid($reader) {
        if ($reader->getSheet(0)) {
            $this->excelValidFirstList($reader);
        } else {
            $this->error['warning'][] = 'Нет 1-го листа';
        }

        if ($reader->getSheet(1)) {
            $this->excelValidSecondList($reader);
        }

        if ($reader->getSheet(2)) {
            $this->excelValidThirdList($reader);
        }

        if (!$this->error) {
            return true;
        }

        return false;
    }

    public function excelValidThirdList($reader) {
        $data = $reader->getSheet(2);
        $name_list = $data->getTitle();
        $count_rows = $data->getHighestRow();

        for ($this_row = $this->start_row_third_list; $this_row < $count_rows; $this_row++) {
            $this_product_id = trim($this->getCell($data, $this_row, $this->column_product_id));
            $fail_row = $this_row + 1;

            if (empty($this_product_id)) {
                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_product_id . ") " . 'Не указан id товара';
            } elseif (!$this->model_catalog_product->getProduct($this_product_id)) {
                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_product_id . ")" . 'Нет товара с id: ' . $this_product_id;
            }

            $prefix_price = trim($this->getCell($data, $this_row, $this->column_prefix_price_tree_list));

            if (empty($prefix_price)) {
                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_prefix_price_tree_list . ") " . 'Не указанo знач. пере ценой';
            } elseif(!$this->model_localisation_price_prefix->getPrefixByName($prefix_price)) {
                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_prefix_price_tree_list . ") " . " Нет такого знач. пере ценой: '" . $prefix_price . "' ";
            }
        }
    }

    public function excelValidSecondList($reader) {
        $data = $reader->getSheet(1);
        $name_list = $data->getTitle();
        $count_rows = $data->getHighestRow();

        for ($this_row = $this->start_row_second_list, $counter = 1; $this_row < $count_rows; $this_row++, $counter++) {
            $this_cell_id = trim($this->getCell($data, $this_row, $this->column_product_id));
            $fail_row = $this_row + 1;

            if (empty($this_cell_id)) {
                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_product_id . ") " . 'Не указан id товара';
            } elseif (!$this->model_catalog_product->getProduct($this_cell_id)) {
                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_product_id . ")" . 'Нет товара с id: ' . $this_cell_id;
            }

            $option_name = trim($this->getCell($data, $this_row, $this->column_option_vert));

            $id_option = $this->model_catalog_option->getOptionByName($option_name);

            if (!$id_option) {
                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_option_vert . ") " . 'Нет такой опции: ' . $option_name;
            } else {
                $id_option = $id_option['option_id'];
                $option_value_name = trim($this->getCell($data, $this_row, $this->column_option_value_vert));
                $id_option_value = $this->model_catalog_option->getOptionValueByName($id_option, $option_value_name);

                if (!$id_option_value) {
                    $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_option_vert . ") " . "Опция: " . $option_name . ". Нет такого значения опции: '" . $option_value_name . "' ";
                }
            }
        }
    }

    public function excelValidFirstList($reader) {
        $data = $reader->getSheet(0);
        $name_list = $data->getTitle();
        $count_rows = $data->getHighestRow();
        $start = False;

        for ($this_row = $this->start_row; $this_row <= $count_rows; $this_row++) {
            if (trim($this->getCell($data, $this_row, $this->column_tag)) == '&') {
                $start = True;
            }

            if ($start == True) {
                $count_columns = PHPExcel_Cell::columnIndexFromString($data->getHighestDataColumn($this_row + 2));
                $option_name = trim($this->getCell($data, $this_row, $this->column_option_hor));
                $id_option = $this->model_catalog_option->getOptionByName($option_name);
                $fail_row = $this_row + 1;

                if (!$id_option) {
                    $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_option_hor . ") Нет такой опции: " . $option_name;
                } else {
                    $id_option = $id_option['option_id'];
                }

                $this_row += 1;

                for ($this_column = $this->column_option_hor; $this_column <= $count_columns; $this_column++) {
                    $option_value_name = trim($this->getCell($data, $this_row, $this_column));
                    $id_option_value = $this->model_catalog_option->getOptionValueByName($id_option, $option_value_name);

                    if (!$id_option_value) {
                        $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this_column . ") Опция: " . $option_name . ". Нет такого значения опции: '" . $option_value_name . "' ";
                    }
                }

                $this_row += 1;

                for (; $this_row <= $count_rows; $this_row++) {
                    $options = False;
                    $fail_row = $this_row + 1;

                    $this_cell_id = trim($this->getCell($data, $this_row, $this->column_product_id));

                    if (empty($this_cell_id)) {
                        $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_product_id . ") " . 'Не указан id товара';
                    } elseif (!$this->model_catalog_product->getProduct($this_cell_id)) {
                        $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_product_id . ")" . 'Нет товара с id: ' . $this_cell_id;
                    }

                    if ($this_row + 1 <= $count_rows) {
                        $next_cell_id = trim($this->getCell($data, $this_row + 1, $this->column_product_id));

                        if ($this_cell_id == $next_cell_id) {
                            $options = True;
                        }
                    }

                    if ($this_row - 1 >= $this->start_row) {
                        $prev_cell_id = trim($this->getCell($data, $this_row - 1, $this->column_product_id));

                        if ($this_cell_id == $prev_cell_id) {
                            $options = True;
                        }
                    }

                    if ($options == True) {
                        $option_name = trim($this->getCell($data, $this_row, $this->column_option_vert));

                        $id_option = $this->model_catalog_option->getOptionByName($option_name);

                        if (!$id_option) {
                            $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_option_vert . ") " . 'Нет такой опции: ' . $option_name;
                        } else {
                            $id_option = $id_option['option_id'];
                            $option_value_name = trim($this->getCell($data, $this_row, $this->column_option_value_vert));
                            $id_option_value = $this->model_catalog_option->getOptionValueByName($id_option, $option_value_name);

                            if (!$id_option_value) {
                                $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_option_vert . ") " . "Опция: " . $option_name . ". Нет такого значения опции: '" . $option_value_name . "' ";
                            }
                        }
                    }

                    $prefix_price = trim($this->getCell($data, $this_row, $this->column_prefix_price_first_list));

                    if (!empty($prefix_price) && $prefix_price != 'del') {
                        $data_prefix_price = $this->model_localisation_price_prefix->getPrefixByName($prefix_price);

                        if (!$data_prefix_price) {
                            $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_prefix_price_first_list . ") " . " Нет такого значения: " . $prefix_price;
                        }
                    }

                    $after_price = trim($this->getCell($data, $this_row, $this->column_after_price_first_list));

                    if (!empty($after_price) && $after_price != 'del') {
                        $data_after_price = $this->model_localisation_price_after->getAfterByName($after_price);

                        if (!$data_after_price) {
                            $this->error['warning'][] = "Лист: $name_list, (строка " . $fail_row . ", колонка: " . $this->column_after_price_first_list . ") " . " Нет такого значения: " . $after_price;
                        }
                    }

                    if (trim($this->getCell($data, $this_row, $this->column_tag)) == '#') {
                        $start = False;
                        break;
                    }
                }
            }
        }
    }

    public function getCellgetOldCalculatedValue(&$worksheet, $row, $col, $default_val='') {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel used 1-based row index
        return ($worksheet->cellExistsByColumnAndRow($col,$row)) ? $worksheet->getCellByColumnAndRow($col,$row)->getOldCalculatedValue() : $default_val;
    }

    public function getCell(&$worksheet, $row, $col, $default_val='') {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel used 1-based row index
        return ($worksheet->cellExistsByColumnAndRow($col,$row)) ? $worksheet->getCellByColumnAndRow($col,$row)->getValue() : $default_val;
    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/price_excel')) {
            $this->error['warning'][] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        }

        return false;
    }
}

?>