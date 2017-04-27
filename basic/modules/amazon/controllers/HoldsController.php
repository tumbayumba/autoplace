<?php

namespace app\modules\amazon\controllers;
use Yii;
use yii\web\Controller;
use app\modules\amazon\models\UploadForm;
use app\modules\amazon\models\Hosts;
use app\modules\amazon\models\IdsMapping;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class HoldsController extends \yii\web\Controller
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
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->csvFile = UploadedFile::getInstance($model, 'csvFile');
            if ($model->upload()) {
                // file is uploaded successfully
            }
        }
        $dir =  \Yii::getAlias('@webroot').'/files/holds/';
        $files = scandir($dir);

        return $this->render('index', ['model' => $model, 'files'=>$files, 'hosts'=>$hosts]);
    }

    public function actionDownload($file){
    	$path = \Yii::getAlias('@webroot').'/files/holds/'.$file;
    	if (file_exists($path))
    	    return \Yii::$app->response->sendFile($path);
    }

    public function actionCreatefiles(){
    	$hosts = Hosts::find()->all();
    	$hold_file = \Yii::getAlias('@webroot').'/files/holds/holds.csv';
    	$ids = [];
    	$holdHandle = fopen($hold_file,"r");
    	while(($buffer=fgetcsv($holdHandle,"1000",","))!==false)
    		if($buffer[0]!='')
    			$ids[] = strtr($buffer[0],["\n"=>"","\r"=>""]);
    	fclose($holdHandle);
    	foreach($hosts as $host){
    		$delete_file = \Yii::getAlias('@webroot').'/files/holds/delete_'.date('Y-m-d').'_'.$host->alias.'.csv';
    		$content = "TemplateType=Home\tVersion=2015.0408\tThe top 3 rows are for Amazon.com use only. Do not modify or delete the top 3 rows.\n";
    		$content .= "SKU\tUpdate Delete\n";
    		$content .= "item_sku\tupdate_delete\n";
    		foreach($ids as $id)
    			$content .= $host->sku_prefix . $id ."\tx\n";
    		$handle = fopen($delete_file,"w");
    		fwrite($handle,$content);
    		fclose($handle);
    	}
    	return $this->redirect(Url::toRoute('/amazon/holds'));
    }

    public function actionDeletefilessku()
    {
        echo '<pre>';
        $hold_file = \Yii::getAlias('@webroot').'/files/holds/holds.csv';
        $delete_file = \Yii::getAlias('@webroot').'/files/holds/delete_'.date('Y-m-d').'_com.csv';
        $mapping = IdsMapping::find()->where('host_id=3 and sku is not null')->all();

        $ids = [];
        $holdHandle = fopen($hold_file,"r");
        while(($buffer=fgetcsv($holdHandle,"1000",","))!==false)
            if($buffer[0]!='')
                $ids[$buffer[0]] = strtr($buffer[0],["\n"=>"","\r"=>""]);
        fclose($holdHandle);

        $content = "TemplateType=Home\tVersion=2015.0408\tThe top 3 rows are for Amazon.com use only. Do not modify or delete the top 3 rows.\n";
            $content .= "SKU\tUpdate Delete\n";
            $content .= "item_sku\tupdate_delete\n";
        foreach($mapping as $map){
            if(isset($ids[$map->product_id])){
                $content .= $map->sku."\tDelete\n";
            }
        }
        $handle = fopen($delete_file,"w");
        fwrite($handle,$content);
        fclose($handle);
    }

}
