<?php

namespace app\modules\amazon\controllers;
use Yii;
use app\modules\amazon\models\Ean;
use app\modules\amazon\models\FieldMapping;
use app\modules\amazon\models\CategoryMapping;
use app\modules\amazon\models\Hosts;
use yii\filters\AccessControl;

class PlacementController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        //'actions' => ['*'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDe()
    {
    	echo '<pre>';
    	$items_file = $_SERVER['DOCUMENT_ROOT'].'/files/items/amazon_placement_de.csv';
    	$place_file = $_SERVER['DOCUMENT_ROOT'].'/files/items/place_de.csv';
    	//GET EANS
    	$eans = array();
    	$_eans = Ean::find()->orderBy('ean desc')->limit(3000)->all();
    	foreach($_eans as $e)
    		$eans[] = $e->ean;
    	//GET FIELDS
    	$fms = array();
    	$_fms = FieldMapping::find()->where(['host_id'=>1])->all();
    	foreach($_fms as $fm)
    		$fms[$fm->amz_field] = $fm->description;
    	//GET CATEGORY MAPPING
    	$cms = array();
    	$_cms = CategoryMapping::find()->where(['host_id'=>1])->all();
    	foreach($_cms as $cm)
    		$cms[$cm->mh_cat_id] = $cm;
    	//GET HOST
    	$host = Hosts::find()->where(['id'=>1])->one();
    	$items = array();
    	$handle = fopen($items_file,"r");
    	while(($buffer=fgetcsv($handle,"5000",";"))!==false){
    		if($buffer[0]!='')
    			$items[$buffer[0]] = $buffer;
    	}
    	fclose($handle);
    	$t = "\t";
    	$content = "TemplateType=Home".$t."Version=2015.0413".$t."Die oberen drei Zeilen sind nur zur Verwendung durch Amazon.de vorgesehen. Verändern oder löschen Sie die obersten drei Zeilen nicht.\n";
    	$content .= implode($t,$fms)."\n";
    	$content .= implode($t,array_keys($fms))."\n";
    	$counter = 0;
    	foreach($items as $product_id=>$item){
    		$category_id = $item[1];
    		if(isset($cms[$category_id])){
    			$title = $item[2];
    			$about = $item[3];
    			$price = $item[4];
    			$weight	 = $item[5];
    			$length = ($item[6]==0) ? 0.01 : $item[6];
    			$width = ($item[7]==0) ? 0.01 : $item[7];
    			$height = ($item[8]==0) ? 0.01 : $item[8];
    			$intro = $item[9];
    			$serv = $item[10];
    			$keywords = $this->convertStr($this->clear($item[11]));
    			$photo1 = $item[12];
    			$photo2 = $item[13];
    			$photo3 = $item[14];
    			$photo4 = $item[15];
    			$photo5 = $item[16];
    			$fragile = $item[17];

    			$shipPrice = $this->newShippingPrice([
    				'host' => 'de',
    				'category_id' => $category_id,
    				'weight' => $weight,
    				'fragile' => $fragile,
    				'currencyrate' => 0.9
    			]);
    			$maxShipPrice = 21.79;
    			if($shipPrice<=$maxShipPrice)
    				$shipWeight = $this->newShippingWeight($shipPrice,"EUR");
    			else
    				$shipWeight = $this->shippingWeight($weight,$fragile,'de',$shipPrice);
    			
    			$searchTermsArr = explode(',',trim(strip_tags(str_replace("?","",$keywords))));
    			for($i=0;$i<5;$i++){
    				if(!empty($searchTermsArr[$i])){
    					$len = strlen($searchTermsArr[$i]);
    					$diff = -($len-50);
    					if($len>50)
    						$searchTermsArr[$i] = substr($searchTermsArr[$i],0,$diff);
    				}
    			}
    			$row1 = $this->clear($this->convertStr($intro));
    			$row2 = $this->dimStr($host->id,['length'=>$length,'width'=>$width,'height'=>$height],$weight);
    			$row3 = $this->clear($this->convertStr($serv));
    			if(!in_array($category_id,array(360422031,342104011,1981479031,360423031,327473011,2076346031,342099011,5846405031,3769065031,3769064031,2867662031,591285031,3769067031,4769966031,358357031,3769069031)))
    				$row4 = utf8_decode("PERSONALISIERUNG - Machen Sie dieses Produkt einzigartiges und persönliches Geschenk! Lassen Sie mich wissen, und ich hinzufüge den Namen Ihrer Familienmitglieder, personalisierte Haustier Name, Gedenkdatum, Stadtname oder anderen Text und Bild. Dieser Dienst steht gegen Gebühr zur Verfügung. Kontaktieren Sie mich, um zusätzliche Informationen zu erhalten.");
    			else
    				$row4 = '';
    			$row5 = strtr(implode(",",$searchTermsArr), array("\r"=>"", "\n"=>"", "\t"=>""));

    			$content .= $host->sku_prefix . $product_id . $t;
    			$content .= $this->clear($this->convertStr($title)) . $t;
    			$content .= $eans[$counter] . $t;
    			$content .= $host->external_product_id_type . $t;
    			$content .= $host->feed_product_type . $t;
    			$content .= $host->brand_name . $t;
    			$content .= $host->manufacturer . $t;
    			$content .= $this->clear($this->convertStr($intro)) . $this->dimStr($host->id,['length'=>$length,'width'=>$width,'height'=>$height],$weight) . $t;
    			$content .= "99" . $t;
    			$content .= round($price*1.2,2) . $t;
    			$content .= $host->currency . $t;
    			$content .= 'NEW' . $t;
    			$content .= date('Y-m-d') . $t;
    			$content .= ((isset($cms[$category_id])) ? $cms[$category_id]->fulfillment_latency : '30' ) . $t;
    			$content .= '1' . $t;
    			$content .= $shipWeight . $t;
    			$content .= 'GR' . $t;
    			$content .= $weight . $t;
    			$content .= 'GR' . $t;
    			$content .= $length . $t;
    			$content .= 'CM' . $t;
    			$content .= $width . $t;
    			$content .= 'CM' . $t;
    			$content .= $height . $t;
    			$content .= 'CM' . $t;
    			$content .= $this->clear(substr($row1,0,499)) . $t;
    			$content .= $this->clear(substr($row2,0,499)) . $t;
    			$content .= $this->clear(substr($row3,0,499)) . $t;
    			$content .= $this->clear(substr($row4,0,499)) . $t;
    			$content .= $this->clear(substr($row5,0,499)) . $t;
    			$content .= $cms[$category_id]->browse_node . $t;
    			for($i=0;$i<2;$i++){
    				$content .= $searchTermsArr[0] . $t;
    				$content .= $searchTermsArr[1] . $t;
    				$content .= $searchTermsArr[2] . $t;
    				$content .= $searchTermsArr[3] . $t;
    				$content .= $searchTermsArr[4] . $t;
    			}
    			$content .= (strpos($photo1,"http")!==false ? $photo1 : '') . $t;
    			$content .= (strpos($photo2,"http")!==false ? $photo2 : '') . $t;
    			$content .= (strpos($photo3,"http")!==false ? $photo3 : '') . $t;
    			$content .= (strpos($photo4,"http")!==false ? $photo4 : '') . $t;
    			$content .= (strpos($photo5,"http")!==false ? $photo5 : '') . $t;
    			$content .= 'multicolor' . $t;
    			$content .= 'multicolor';
    			$content .= "\n";

    			$counter++;
    		}
    	}

        $writeHandle = fopen($place_file,"w");
        fwrite($writeHandle,$content);
        fclose($writeHandle);
    }

    public function actionFr()
    {
    	echo '<pre>';
    	$items_file = $_SERVER['DOCUMENT_ROOT'].'/files/items/amazon_placement_fr.csv';
    	$place_file = $_SERVER['DOCUMENT_ROOT'].'/files/items/place_fr.csv';
    	//GET EANS
    	$eans = array();
    	$_eans = Ean::find()->orderBy('ean desc')->limit(3000)->offset(3000)->all();
    	foreach($_eans as $e)
    		$eans[] = $e->ean;
    	//GET FIELDS
    	$fms = array();
    	$_fms = FieldMapping::find()->where(['host_id'=>2])->all();
    	foreach($_fms as $fm)
    		$fms[$fm->amz_field] = $fm->description;
    	//GET CATEGORY MAPPING
    	$cms = array();
    	$_cms = CategoryMapping::find()->where(['host_id'=>2])->all();
    	foreach($_cms as $cm)
    		$cms[$cm->mh_cat_id] = $cm;
    	//GET HOST
    	$host = Hosts::find()->where(['id'=>2])->one();
    	$items = array();
    	$handle = fopen($items_file,"r");
    	while(($buffer=fgetcsv($handle,"5000",";"))!==false){
    		if($buffer[0]!='')
    			$items[$buffer[0]] = $buffer;
    	}
    	fclose($handle);
    	$t = "\t";
    	$content = "TemplateType=Home".$t."Version=2015.0310".$t."Les 3 lignes supérieures sont réservées à Amazon.com. Ne pas modifier ou supprimer les 3 lignes supérieures.\n";
    	$content .= implode($t,$fms)."\n";
    	$content .= implode($t,array_keys($fms))."\n";
    	$counter = 0;
    	foreach($items as $product_id=>$item){
    		$category_id = $item[1];
    		if(isset($cms[$category_id])){
    			$title = $item[2];
    			$about = $item[3];
    			$price = $item[4];
    			$weight	 = $item[5];
    			$length = ($item[6]==0) ? 0.01 : $item[6];
    			$width = ($item[7]==0) ? 0.01 : $item[7];
    			$height = ($item[8]==0) ? 0.01 : $item[8];
    			$intro = $item[9];
    			$serv = $item[10];
    			$keywords = $this->convertStr($this->clear($item[11]));
    			$photo1 = $item[12];
    			$photo2 = $item[13];
    			$photo3 = $item[14];
    			$photo4 = $item[15];
    			$photo5 = $item[16];
    			$fragile = $item[17];

    			$shipPrice = $this->newShippingPrice([
    				'host' => 'fr',
    				'category_id' => $category_id,
    				'weight' => $weight,
    				'fragile' => $fragile,
    				'currencyrate' => 0.9
    			]);
    			$maxShipPrice = 21.79;
    			if($shipPrice<=$maxShipPrice)
    				$shipWeight = $this->newShippingWeight($shipPrice,"EUR");
    			else
    				$shipWeight = $this->shippingWeight($weight,$fragile,'fr',$shipPrice);
    			
    			$searchTermsArr = explode(',',trim(strip_tags(str_replace("?","",$keywords))));
    			for($i=0;$i<5;$i++){
    				if(!empty($searchTermsArr[$i])){
    					$len = strlen($searchTermsArr[$i]);
    					$diff = -($len-50);
    					if($len>50)
    						$searchTermsArr[$i] = substr($searchTermsArr[$i],0,$diff);
    				}
    			}
    			$row1 = $this->clear($this->convertStr($intro));
    			$row2 = $this->dimStr($host->id,['length'=>$length,'width'=>$width,'height'=>$height],$weight);
    			$row3 = $this->clear($this->convertStr($serv));
    			if(!in_array($category_id,array(197028031,3883162031,197026031,197024031,197031031,197027031,2984863031,2984864031,2984873031,2984874031,3520920031,2984872031,2984863031,193711031)))
    				$row4 = utf8_decode("PERSONNALISATION - Présentez ce produit comme un cadeau unique et personnel! Laissez-moi savoir, et je vais ajouter les noms des membres de votre famille, de vos animaux domestiques, date mémorable, le nom de la ville ou tout autre texte et l'image. Ce service est disponible moyennant un supplément. S'il vous plaît, contactez-moi pour en savoir plus sur le service.");
    			else
    				$row4 = '';
    			$row5 = strtr(implode(",",$searchTermsArr), array("\r"=>"", "\n"=>"", "\t"=>""));

    			$content .= $host->sku_prefix . $product_id . $t;
    			$content .= $eans[$counter] . $t;
    			$content .= $host->external_product_id_type . $t;
    			$content .= $this->clear($this->convertStr($title)) . $t;
    			$content .= $host->brand_name . $t;
    			$content .= $host->manufacturer . $t;
    			$content .= $host->feed_product_type . $t;
    			$content .= $this->clear($this->convertStr($intro)) . $this->dimStr($host->id,['length'=>$length,'width'=>$width,'height'=>$height],$weight) . $t;
    			$content .= round($price*1.2,2) . $t;
    			$content .= $host->currency . $t;
    			$content .= "99" . $t;
    			$content .= 'NEW' . $t;
    			$content .= ((isset($cms[$category_id])) ? $cms[$category_id]->fulfillment_latency : '30' ) . $t;
    			$content .= '1' . $t;
    			$content .= $shipWeight . $t;
    			$content .= 'GR' . $t;
    			$content .= $length . $t;
    			$content .= 'CM' . $t;
    			$content .= $width . $t;
    			$content .= 'CM' . $t;
    			$content .= $height . $t;
    			$content .= 'CM' . $t;
    			$content .= $weight . $t;
    			$content .= 'GR' . $t;
    			$content .= $cms[$category_id]->browse_node . $t;
    			$content .= $cms[$category_id]->browse_node . $t;
    			$content .= $this->clear(substr($row1,0,499)) . $t;
    			$content .= $this->clear(substr($row2,0,499)) . $t;
    			$content .= $this->clear(substr($row3,0,499)) . $t;
    			$content .= $this->clear(substr($row4,0,499)) . $t;
    			$content .= $this->clear(substr($row5,0,499)) . $t;
    			for($i=0;$i<2;$i++){
    				$content .= $searchTermsArr[0] . $t;
    				$content .= $searchTermsArr[1] . $t;
    				$content .= $searchTermsArr[2] . $t;
    				$content .= $searchTermsArr[3] . $t;
    				$content .= (isset($searchTermsArr[4]) ? $searchTermsArr[4] : '') . $t;
    			}
    			$content .= (strpos($photo1,"http")!==false ? $photo1 : '') . $t;
    			$content .= (strpos($photo2,"http")!==false ? $photo2 : '') . $t;
    			$content .= (strpos($photo3,"http")!==false ? $photo3 : '') . $t;
    			$content .= (strpos($photo4,"http")!==false ? $photo4 : '') . $t;
    			$content .= (strpos($photo5,"http")!==false ? $photo5 : '') . $t;
    			$content .= 'multicolor' . $t;
    			$content .= 'multicolor';
    			$content .= "\n";

    			$counter++;
    		}
    	}

        $writeHandle = fopen($place_file,"w");
        fwrite($writeHandle,$content);
        fclose($writeHandle);
    }

    public function dimStr($host_id,$dims,$weight){
    	switch($host_id){
    		case 1 : $dimStr = " Länge: ".$dims['length']." cm, Breite: ".$dims['width']." cm, Höhe: ".$dims['height']." cm, Gewicht: ".($weight/1000)." kg.";break;
    		case 2 : $dimStr = " Longueur: ".$dims['length']." cm, largeur: ".$dims['width']." cm, hauteur: ".$dims['height']." cm, poids: ".($weight/1000)." kg.";break;
    		default : $dimStr = '';
    	}
    	return $this->convertStr($dimStr);
    }

    public function clear($str){
    	return trim(strip_tags(strtr($str,["\t"=>" ","\n"=>"","\r"=>""])));
    }

    public function convertStr($str){
    	return mb_convert_encoding($str,"ISO-8859-1","auto");
    }

    public function newShippingPrice($params)
	{
		$location = ($params['host']=='com') ? 1 : 0;
		// List of eggs categories
        $eggs = [457962289, 483353735, 2111667581, 1350481928];

        // If the product is an egg the weight is null
        $weight = in_array($params['category_id'], $eggs) ? null : (int) $params['weight'];

        // If it IS NOT an egg
        if ($weight) {
            // Fragile products coefficient
            $fragile = $params['fragile'] == 1 ? 2 : 1;

            // Total product weight (with packaging)
            if ($weight <= 100) {
                $weight += 80 * $fragile;
            } elseif ($weight > 100 && $weight <= 250) {
                $weight += 150 * $fragile;
            } elseif ($weight > 250 && $weight <= 500) {
                $weight += 200 * $fragile;
            } elseif ($weight > 500 && $weight <= 1000) {
                $weight += 250 * $fragile;
            } elseif ($weight > 1000 && $weight <= 2000) {
                $weight += 350 * $fragile;
            } elseif ($weight > 2000 && $weight <= 30000) {
                // если товар хрупкий, то к общему весу товара добавим 40%, если не хрупкий - 20%
                $weight = $fragile == 2 ? $weight * 1.4 : $weight * 1.2;
            }

            // Location prices (for goods over 2000 gr) - zone => [package price, price per each kilo]
            $location_price = [
                0 => ['per_package' => 15, 'per_kilo' => 7],   // Восточная Азия, Африка, Южная и Центральная Америка
                1 => ['per_package' => 11, 'per_kilo' => 6],   // Северная Америка
                2 => ['per_package' => 13, 'per_kilo' => 3.5], // Россия, Европа, Центральная Азия и Ближний Восток
                3 => ['per_package' => 11, 'per_kilo' => 12]   // Австралия и Океания
            ];

            // Price per weight
            if ($weight <= 100) {
                $price = 4;
            } elseif ($weight > 100 && $weight <= 250) {
                $price = 7;
            } elseif ($weight > 250 && $weight <= 500) {
                $price = 10;
            } elseif ($weight > 500 && $weight <= 1000) {
                $price = 15;
            } elseif ($weight > 1000 && $weight <= 2000) {
                $price = 22;
            } elseif ($weight > 2000) {
                $weistr = (string)$weight; // вес товара
                // розрадность значения веса. Если $length == 4, то число от 1000 до 9999; 5 - 10 000 до 99 999
                $length = strlen($weistr);
                $coeff = 0;
                // если 4-х значное число, то забираем первое и второе. Например если вес был 2500 грамм, то забираем 25
                if ($length == 4) {
                    $coeff = (int)substr($weistr, 0, 2);
                } // если 5-и значное число, то забираем первое, второе и третье. Например если вес был 12000 грамм, то забираем 120
                elseif ($length == 5) {
                    $coeff = (int)substr($weistr, 0, 3);
                }
                // Например если вес был 12000 грамм, то цена доставки = 120 * цена за каждые 100 грамм для данного региона + цена посылки для данного региона
                $price = $coeff * ($location_price[$location]['per_kilo'] * 0.1) + $location_price[$location]['per_package'];
            }

            // для товаров c весом меньше 2000 грамм добавляем 10% от стоимости
            $price = $weight <= 2000 ? $price * 1.1 : $price;

            // If it IS an egg
        } else {
            $eggs_price = [
                457962289  => 10, // Писанки из куриного яйца
                483353735  => 10, // Писанки из гусиного яйца
                2111667581 => 10, // Писанки из индюшиного яйца
                1350481928 => 15  // Писанки из страусиного яйца
            ];

            $price = $eggs_price[$params['category_id']];
        }
        
		$shipPrice = round(($price*$params['currencyrate']),2);
		return $shipPrice;
	}

	public function newShippingWeight($shipPrice,$currency)
	{
		if($currency=='EUR'){
			if($shipPrice>=1 && $shipPrice<=4) $packageWeight=25;
			if($shipPrice>=4 && $shipPrice<=7) $packageWeight=232;
			if($shipPrice>=8 && $shipPrice<=10) $packageWeight=438;
			if($shipPrice>=11 && $shipPrice<=15) $packageWeight=782;
			if($shipPrice>=16 && $shipPrice<=22) $packageWeight=1263;
		}
		if($currency=='USD'){
			if($shipPrice>=1 && $shipPrice<=5) $packageWeight=25;
			if($shipPrice>=6 && $shipPrice<=8) $packageWeight=211;
			if($shipPrice>=9 && $shipPrice<=11) $packageWeight=400;
			if($shipPrice>=12 && $shipPrice<=17) $packageWeight=712;
			if($shipPrice>=18 && $shipPrice<=25) $packageWeight=1150;
		}
		if($currency=='GBP'){
			if($shipPrice>=1 && $shipPrice<=3) $packageWeight=25;
			if($shipPrice>=4 && $shipPrice<=5) $packageWeight=232;
			if($shipPrice>=6 && $shipPrice<=8) $packageWeight=438;
			if($shipPrice>=9 && $shipPrice<=11) $packageWeight=782;
			if($shipPrice>=12 && $shipPrice<=16) $packageWeight=1263;
		}
		return $packageWeight;
	}

    public function shippingWeight($weight,$fragile,$host,$shipPrice = 'default')
	{
		switch($weight){
				case ($weight>=0 && $weight<100): $packageWeight=80;break;
				case ($weight>101 && $weight<250): $packageWeight=150;break;
				case ($weight>251 && $weight<500): $packageWeight=200;break;
				case ($weight>501 && $weight<1000): $packageWeight=250;break;
				case ($weight>1001 && $weight<2000): $packageWeight=350;break;
				case ($weight>2001 && $weight<3000): $packageWeight=500;break;
				case ($weight>3001 && $weight<4000): $packageWeight=700;break;
				case ($weight>4001 && $weight<5000): $packageWeight=900;break;
				case ($weight>5001 && $weight<6000): $packageWeight=1100;break;
				case ($weight>6001 && $weight<7000): $packageWeight=1300;break;
				case ($weight>9001 && $weight<10000): $packageWeight=1900;break;
				case ($weight>10001 && $weight<11000): $packageWeight=2100;break;
				case ($weight>11001 && $weight<12000): $packageWeight=2300;break;
				case ($weight>12001 && $weight<13000): $packageWeight=2500;break;
				case ($weight>13001 && $weight<14000): $packageWeight=2700;break;
				case ($weight>14001 && $weight<15000): $packageWeight=2900;break;
				default : $packageWeight=1100;
		}
		if($fragile == 1)
			$packageWeight *= 2;
		if($host=='com' || $host=='com.mx' || $host=='ca'){
			$shipArr = $this->shipping2Amazon($shipPrice);
			if($shipArr['packageWeight']!='default'){
				$packNAWeight = ($shipArr['packageWeight']!='default') ? $shipArr['packageWeight'] : $packageWeight;
				$packageWeight = ($packNAWeight>$packageWeight) ? $packNAWeight : $packageWeight ;
			}
			else{
				$packageWeight += $weight;
			}
		}
		if($host=='com' || $host=='com.mx' || $host=='ca')
			$totalWeight = $packageWeight;
		else
			$totalWeight = $packageWeight+$weight;
		return $totalWeight;
	}

	public function shipping2Amazon($shippingPrice)
	{
		$shipArr = array();
		$shippingPrice = round($shippingPrice,1);
		switch($shippingPrice){
			case ($shippingPrice==(float) "4.4") : $shipArr=array('packageWeight'=>'default');break;
			case ($shippingPrice==(float) "7.7") : $shipArr=array('packageWeight'=>215);break;
			case ($shippingPrice==(float) "11") : $shipArr=array('packageWeight'=>400);break;
			case ($shippingPrice==(float) "16.5") : $shipArr=array('packageWeight'=>715);break;
			case ($shippingPrice==(float) "24.2") : $shipArr=array('packageWeight'=>1150);break;
			default : $shipArr=array('packageWeight'=>'default');break;
		}
		return $shipArr;
	}

}
