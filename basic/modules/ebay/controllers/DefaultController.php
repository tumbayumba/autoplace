<?php

namespace app\modules\ebay\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Default controller for the `ebay` module
 */
class DefaultController extends Controller
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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSethold($acc,$host)
    {
    	echo '<pre>';
        $hold_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'holds'.DIRECTORY_SEPARATOR.'holds.csv';
        $listing_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'listings'.DIRECTORY_SEPARATOR.'listing_'.$acc.'_'.$host.'.csv';
        $end_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'revise'.DIRECTORY_SEPARATOR.'end_'.$host.'.csv';

    	$holds = $this->getHolds($hold_file);
        $listing = $this->getListingWithSku($listing_file);

    	$end_content = "*Action(SiteID=UK|Country=UA|Currency=GBP|Version=745),ItemID,EndCode\n";
    	foreach($listing as $pid=>$item_id){
    		if(isset($holds[$pid])){
    			echo $pid." : ".$item_id."\n";
    			$end_content .= "End,".$item_id.",Incorrect\n";
    			
    		}
    	}
    	$this->writeFile($end_file,$end_content);
    }

    public function actionSetrevise($host)
    {
        $source_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'mplacement'.DIRECTORY_SEPARATOR.'combined_'.$host.'.csv';
        $revise_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'revise'.DIRECTORY_SEPARATOR.'revise_'.$host.'.csv';

        $content = "*Action(SiteID=UK|Currency=GBP|Version=745),ItemID,CustomLabel\n";
    	$content .= $this->getSource($source_file);
    	$this->writeFile($revise_file,$content);
    }

    public function actionCombine($acc,$host)
    {
    	echo '<pre>';
    	$listing_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'listings'.DIRECTORY_SEPARATOR.'listing_'.$acc.'_'.$host.'.csv';
    	$mp_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'mplacement'.DIRECTORY_SEPARATOR.'mplacement_'.$host.'.csv';
    	$combined_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'mplacement'.DIRECTORY_SEPARATOR.'combined_'.$host.'.csv';
    	$debug_file = Yii::$app->basePath.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'ebay'.DIRECTORY_SEPARATOR.'debug'.DIRECTORY_SEPARATOR.'debug_'.Yii::$app->controller->action->id.'.csv';

    	$listing = $this->getListing($listing_file);
    	$mplacement = $this->getMplacement($mp_file);

    	$combined_content = '';
    	$debug_content = '';
    	foreach($listing as $row){
    		if(isset($mplacement[$row]))
    			$combined_content .= $mplacement[$row].";".$row."\n";
    		else
    			$debug_content .= $row."\n";
    	}

    	$this->writeFile($combined_file,$combined_content);
    	$this->writeFile($debug_file,$debug_content);
        
    }

    protected function getListing($file){
    	$arr = [];
    	$handle = fopen($file,"r");
    	while(($buffer=fgetcsv($handle,"5000",",")))
    	    if($buffer[0]!='' && strpos($buffer[1],"MADEH-")===false  && is_numeric($buffer[0]))
    	        $arr[$buffer[0]] = $buffer[0];
    	fclose($handle);
    	return $arr;
    }

    protected function getListingWithSku($file){
    	$arr = [];
    	$handle = fopen($file,"r");
    	while(($buffer=fgetcsv($handle,"5000",",")))
    	    if($buffer[0]!='' && strpos($buffer[1],"MADEH-")!==false  && is_numeric($buffer[0])){
    	    	$product_id = strtr($buffer[1],array("MADEH-"=>""));
    	        $arr[$product_id] = $buffer[0];
    	    }
    	fclose($handle);
    	return $arr;
    }

    protected function getMplacement($file){
    	$arr = [];
    	$handle = fopen($file,"r");
    	while(($buffer=fgetcsv($handle,"1000",";")))
    	    if($buffer[0]!=''){
    	    	preg_match("/[0-9]{12,12}/",$buffer[1],$itemIdArr);
    	    	$itemId = $itemIdArr[0];
    	        $arr[$itemId] = $buffer[0];
    	    }
    	fclose($handle);
    	return $arr;
    }

    protected function getSource($file){
    	$content = '';
    	$handle = fopen($file,"r");
    	while(($buffer=fgetcsv($handle,"1000",";")))
    	    if($buffer[0]!='' && is_numeric($buffer[0]))
    	       $content .= "Revise,".$buffer[1].",MADEH-".$buffer[0]."\n";
    	fclose($handle);
    	return $content;
    }

    protected function getHolds($file){
    	$arr = [];
    	$handle = fopen($file,"r");
    	while(($buffer=fgetcsv($handle,"1000",";")))
    	    if($buffer[0]!='')
    	        $arr[$buffer[0]] = $buffer[0];
    	fclose($handle);
    	return $arr;
    }

    protected function writeFile($file,$content){
    	$writeHandle = fopen($file,"w");
    	fwrite($writeHandle,$content);
    	fclose($writeHandle);
    }

}
