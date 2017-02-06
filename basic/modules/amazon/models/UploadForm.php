<?php
namespace app\modules\amazon\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $csvFile;
    public $hold_filename = 'holds.csv';

    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'checkExtensionByMimeType' => false, 'extensions' => 'csv'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $filename = $this->csvFile->baseName . '.' . $this->csvFile->extension;
            if($filename==$this->hold_filename){
                $this->csvFile->saveAs('files/holds/' . $filename);
                \Yii::$app->getSession()->setFlash('hold_file_upload', '<div class="alert alert-success" role="alert">Upload '.$filename.' success!</div>');
                return true;
            }
        } 
        \Yii::$app->getSession()->setFlash('hold_file_upload', '<div class="alert alert-danger" role="alert">Upload '.$filename.' error!</div>');
        return false;
    }
}