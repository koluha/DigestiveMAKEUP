<?php

class PriceUploaderModel {

    private $reader = null;
    private $fileName = null;
    private $lineCount = 0;
    private $pid = 0;
    private $isNew = true;

    public function __construct($fname, $pid, $isNew = true) {
        if (!file_exists($fname) || !is_readable($fname)) {
            throw new Exception('Invalid file name');
        }
        $this->fileName = $fname;

        $this->reader = new Spreadsheet_Excel_Reader($fname, true, 'UTF-8');
        $this->lineCount = $this->reader->rowcount();
        $this->isNew = $isNew;
        $this->pid = $pid;
        // if ($this->isNew && ($this->reader->colcount() != 6)) {
        //     throw new Exception('Неверное количество колонок. В прайсе с новыйми деталями должно быть 6 колонок.');
        // } 
    }

    public function process() {
        $db = Yii::app()->db;
        $insert = $db->createCommand("
	    INSERT INTO {{product}} (pid, article, group_1, key_group_1, group_2, key_group_2, group_3, key_group_3,
           f_brand, f_s_brand, f_country, f_s_country, f_region, f_s_region,f_type, f_s_type, f_class, f_s_class, f_alcohol, f_s_alcohol, f_taste, f_s_taste, f_sugar, f_s_sugar, f_grape_sort, f_s_grape_sort, f_vintage_year, f_s_vintage_year, f_color, f_s_color, f_excerpt, f_s_excerpt, f_fortress, f_volume, f_packaging,
           i_name_sku, i_availability, i_popular, i_limitedly, i_old_price, i_price, i_manufacturer_importer, i_supplier,
           d_desc_product, d_photo_small, d_photo_middle, d_photo_high, d_link_manuf, d_logo_manuf,
           t_url, t_meta_title, t_meta_keyword, t_meta_description)
	    VALUES (:pid, :article, :group_1, :key_group_1, :group_2, :key_group_2, :group_3, :key_group_3, :f_brand, :f_s_brand, :f_country, :f_s_country, :f_region, :f_s_region, :f_type, :f_s_type, :f_class, :f_s_class, :f_alcohol, :f_s_alcohol, :f_taste, :f_s_taste, :f_sugar, :f_s_sugar, :f_grape_sort, :f_s_grape_sort, :f_vintage_year, :f_s_vintage_year, :f_color, :f_s_color, :f_excerpt, :f_s_excerpt, :f_fortress, :f_volume, :f_packaging, :i_name_sku, :i_availability, :i_popular, :i_limitedly, :i_old_price, :i_price, :i_manufacturer_importer, :i_supplier, :d_desc_product, :d_photo_small, :d_photo_middle, :d_photo_high, :d_link_manuf, :d_logo_manuf, :t_url, :t_meta_title, :t_meta_keyword, :t_meta_description)
	");

        $transaction = $db->beginTransaction();
        $rowCounter = 3;
        $skipped = 0;
        $funcName = 'getRowNew';
        try {
            for ($rowCounter; $rowCounter <= $this->lineCount; $rowCounter++) {
                $row = $this->$funcName($rowCounter);
                if ($row['i_price'] == 0) {  //Если цена ноль пропускаем
                    $skipped++;
                    continue;
                }

                $insert->execute(array(
                    ':pid' => $this->pid,
                    ':article' => $row['article'],
                    ':group_1' => $row['group_1'],
                    ':key_group_1' => $row['key_group_1'],
                    ':group_2' => $row['group_2'],
                    ':key_group_2' => $row['key_group_2'],
                    ':group_3' => $row['group_3'],
                    ':key_group_3' => $row['key_group_3'],
                    ':f_brand' => $row['f_brand'],
                    ':f_s_brand' => $row['f_s_brand'],
                    ':f_country' => $row['f_country'],
                    ':f_s_country' => $row['f_s_country'],
                    ':f_region' => $row['f_region'],
                    ':f_s_region' => $row['f_s_region'],
                    ':f_type' => $row['f_type'],
                    ':f_s_type' => $row['f_s_type'],
                    ':f_class' => $row['f_class'],
                    ':f_s_class' => $row['f_s_class'],
                    ':f_alcohol' => $row['f_alcohol'],
                    ':f_s_alcohol' => $row['f_s_alcohol'],
                    ':f_taste' => $row['f_taste'],
                    ':f_s_taste' => $row['f_s_taste'],
                    ':f_sugar' => $row['f_sugar'],
                    ':f_s_sugar' => $row['f_s_sugar'],
                    ':f_grape_sort' => $row['f_grape_sort'],
                    ':f_s_grape_sort' => $row['f_s_grape_sort'],
                    ':f_vintage_year' => $row['f_vintage_year'],
                    ':f_s_vintage_year' => $row['f_s_vintage_year'],
                    ':f_color' => $row['f_color'],
                    ':f_s_color' => $row['f_s_color'],
                    ':f_excerpt' => $row['f_excerpt'],
                    ':f_s_excerpt' => $row['f_s_excerpt'],
                    ':f_fortress' => $row['f_fortress'],
                    ':f_volume' => $row['f_volume'],
                    ':f_packaging' => $row['f_packaging'],
                    ':i_name_sku' => $row['i_name_sku'],
                    ':i_availability' => $row['i_availability'],
                    ':i_popular' => $row['i_popular'],
                    ':i_limitedly' => $row['i_limitedly'],
                    ':i_old_price' => $row['i_old_price'],
                    ':i_price' => $row['i_price'],
                    ':i_manufacturer_importer' => $row['i_manufacturer_importer'],
                    ':i_supplier' => $row['i_supplier'],
                    ':d_desc_product' => $row['d_desc_product'],
                    ':d_photo_small' => $row['d_photo_small'],
                    ':d_photo_middle' => $row['d_photo_middle'],
                    ':d_photo_high' => $row['d_photo_high'],
                    ':d_link_manuf' => $row['d_link_manuf'],
                    ':d_logo_manuf' => $row['d_logo_manuf'],
                    ':t_url' => $row['t_url'],
                    ':t_meta_title' => $row['t_meta_title'],
                    ':t_meta_keyword' => $row['t_meta_keyword'],
                    ':t_meta_description' => $row['t_meta_description']
                ));


                //Проверка на одинаковое URL продукта
                $last_id = $db->lastInsertID;
                $urw = $row['t_url'];
                $on_url = $db->createCommand("SELECT id,t_url FROM tb_product WHERE t_url='$urw' AND id!=$last_id")->queryRow();

                if (!empty($on_url['id']) && !empty($row['t_url'])) {
                    $url_out = $on_url['t_url'];
                    throw new Exception("Уже есть такой URL поля t_url,замените дублированный t_url с названием=$url_out");
                }
                 if (empty($row['t_url'])) {
                        throw new Exception("URL поле пустое");
                }
            }
            $db->createCommand("UPDATE {{prices}} SET updated=CURRENT_TIMESTAMP WHERE pid=:pid")
                    ->execute(array(
                        ':pid' => $this->pid
            ));
            $transaction->commit();
        } catch (Exception $e) {
            if ($transaction->getActive()) {
                $transaction->rollback();
            }
            throw $e;
        }
    }

    private function getRowNew($row) {
        $out = array(
            'article' => $this->reader->val($row, 'A'),
            'group_1' => $this->reader->val($row, 'B'),
            'key_group_1' => (int) $this->reader->val($row, 'C'),
            'group_2' => $this->reader->val($row, 'D'),
            'key_group_2' => (int) $this->reader->val($row, 'E'),
            'group_3' => $this->reader->val($row, 'F'),
            'key_group_3' => (int) $this->reader->val($row, 'G'),
            'f_brand' => $this->reader->val($row, 'H'),
            'f_s_brand' => $this->reader->val($row, 'I'),
            'f_country' => $this->reader->val($row, 'J'),
            'f_s_country' => $this->reader->val($row, 'K'),
            'f_region' => $this->reader->val($row, 'L'),
            'f_s_region' => $this->reader->val($row, 'M'),
            'f_type' => $this->reader->val($row, 'N'),
            'f_s_type' => $this->reader->val($row, 'O'),
            'f_class' => $this->reader->val($row, 'P'),
            'f_s_class' => $this->reader->val($row, 'Q'),
            'f_alcohol' => $this->reader->val($row, 'R'),
            'f_s_alcohol' => $this->reader->val($row, 'S'),
            'f_taste' => $this->reader->val($row, 'T'),
            'f_s_taste' => $this->reader->val($row, 'U'),
            'f_sugar' => $this->reader->val($row, 'V'),
            'f_s_sugar' => $this->reader->val($row, 'W'),
            'f_grape_sort' => $this->reader->val($row, 'X'),
            'f_s_grape_sort' => $this->reader->val($row, 'Y'),
            'f_vintage_year' => $this->reader->val($row, 'Z'),
            'f_s_vintage_year' => $this->reader->val($row, 'AA'),
            'f_color' => $this->reader->val($row, 'AB'),
            'f_s_color' => $this->reader->val($row, 'AC'),
            'f_excerpt' => $this->reader->val($row, 'AD'),
            'f_s_excerpt' => $this->reader->val($row, 'AE'),
            'f_fortress' => $this->reader->val($row, 'AF'),
            'f_volume' => $this->reader->val($row, 'AG'),
            'f_packaging' => $this->reader->val($row, 'AH'),
            'i_name_sku' => $this->reader->val($row, 'AI'),
            'i_availability' => $this->reader->val($row, 'AJ'),
            'i_popular' => $this->reader->val($row, 'AK'),
            'i_limitedly' => $this->reader->val($row, 'AL'),
            'i_old_price' => floatval($this->reader->val($row, 'AM')),
            'i_price' => floatval($this->reader->val($row, 'AN')),
            'i_manufacturer_importer' => $this->reader->val($row, 'AO'),
            'i_supplier' => $this->reader->val($row, 'AP'),
            'd_desc_product' => $this->reader->val($row, 'AQ'),
            'd_photo_small' => $this->reader->val($row, 'AR'),
            'd_photo_middle' => $this->reader->val($row, 'AS'),
            'd_photo_high' => $this->reader->val($row, 'AT'),
            'd_link_manuf' => $this->reader->val($row, 'AU'),
            'd_logo_manuf' => $this->reader->val($row, 'AV'),
            't_url' => Myhelper::translitUrl($this->reader->val($row, 'AX')),
            't_meta_title' => $this->reader->val($row, 'AY'),
            't_meta_keyword' => $this->reader->val($row, 'AZ'),
            't_meta_description' => $this->reader->val($row, 'BA')
        );
        return $out;
    }

    public function __destruct() {
        @unlink($this->fileName);
    }

}
