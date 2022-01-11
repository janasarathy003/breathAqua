<?php
namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\db\Query;
use yii\filters\VerbFilter;
use api\modules\v1\models\ApiRequestResponseLog;
use api\modules\v1\models\MerchantCategoryMasterApi;
use api\modules\v1\models\MerchantMasterApi;
use api\modules\v1\models\ProductMasterApi;
use api\modules\v1\models\PackageLimitationMappingApi;
use api\modules\v1\models\ReferalMergeLogApi;
use api\modules\v1\models\RandomGeneration;

/**
 * Site controller
 */
class MerchantMgntController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {    
        $params = (Yii::$app->request->headers);
        if($authorization=$params['authorization']){        
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
        }else{
            $list['status'] = 'error';
            $list['message'] = 'Bad Request ';
            $response=$list;
            echo json_encode($response);
            die;
        }
    } 

    # Author : Jana
    # Timestamp : 24-02-2020 03:45 PM
    # Desc : Checking Authentication at each Time

    function authorization(){  
        $params = (Yii::$app->request->headers);
        $authorization=$params['authorization'];
        $authorization=str_replace('Bearer', '', $authorization);
        $authorization=trim($authorization);
        $acStAr = array('A','R');
        $user_data_role = MerchantMasterApi::find()
            ->where(['authKey'=>$authorization])
            ->andWhere(['IN','activeStatus',$acStAr])
            ->one();
        if($user_data_role){
            return $user_data_role;
        }else{ 
            return false;
        }
    }

    # Author : Jana
    # Timestamp : 20-07-2020 03:18 PM
    # Desc :  Merchant  Management using Mobile Application

    public function actionMerchantMgnt(){
        $list = array();                
        $list['status'] = 'error';
        $list['message'] = 'Invalid Authorization Request!';    
        if($user_data_role=$this->authorization()){
            $merchantId = $user_data_role->merchantId; 
            $postd=(Yii::$app ->request ->rawBody);
            $requestInput = json_decode($postd,true); 
            $uniqueCode = "";  
            if(array_key_exists('mobileUniqueCode', $requestInput)){
                $uniqueCode = $requestInput['mobileUniqueCode'];
            }
            $list['status'] = 'error';
            $list['message'] = 'Invalid Apimethod';
            
            $requestInput['merchantId'] = $merchantId;
            $requestInput['callReqFrom'] = 'appCall';

            $model_log = new ApiRequestResponseLog();        
            $model_log->requestData = $postd;
            $model_log->apiMethod   = "Merchant Management";
            $model_log->mobileCode  = $uniqueCode;
            $model_log->createdAt   = date("Y-m-d H:i:s");
            $model_log->save();
            $log_id = $model_log->autoid;
            if($requestInput['apiMethod']=="CategoryList"){
                $newMs = new MerchantCategoryMasterApi();
                $list  = $newMs->CategoryList($requestInput);
            }else{
                $newMs = new MerchantMasterApi();
                $list  = $newMs->MerchantDetails($requestInput);                
            }
            
            if($log_id!=''){
                $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
                $model_log->response= json_encode($list);
                $model_log->save();
            }
        }
        return json_encode($list);
    }

    # Author : Jana
    # Timestamp : 23-07-2020 03:18 PM
    # Desc :  Merchant  Management using Mobile Application

    public function actionProfileUpdateMedia(){
        $list = array();                
        $list['status'] = 'error';
        $list['message'] = 'Invalid Authorization Request!';    
        if($user_data_role=$this->authorization()){
            $merchantId = $user_data_role->merchantId; 
            $postd=Yii::$app->request->post();
            $requestInput = $postd; 
            $uniqueCode = "";  
            if(array_key_exists('mobileUniqueCode', $requestInput)){
                $uniqueCode = $requestInput['mobileUniqueCode'];
            }
            $list['status'] = 'error';
            $list['message'] = 'Invalid Apimethod';
            // echo "<pre>";print_r($merchantId);die;
            
            $requestInput['merchantId'] = $merchantId;
            $requestInput['callReqFrom'] = 'appCall';

            $model_log = new ApiRequestResponseLog();
            $model_log->requestData = $postd;
            $model_log->apiMethod   = "Merchant Profile Update";
            $model_log->mobileCode  = $uniqueCode;
            $model_log->createdAt   = date("Y-m-d H:i:s");
            $model_log->save();
            $log_id = $model_log->autoid;

            $newMs = new MerchantMasterApi();
            $list  = $newMs->ProfileUpdate($requestInput,$_FILES);

            if(!empty($list)){
                if($list['status']=='success'){
                    $resDa = ArrayHelper::toArray(json_decode($user_data_role->paymentResponse));
                    $resDa['printdata']['merchant'] = ArrayHelper::toArray($user_data_role);
                        // echo "<prE>";print_r($resDa);die;
                    if(!empty($resDa)){
                        if(array_key_exists('status', $resDa)){
                            if ($resDa['status']=="success") {
                                if (array_key_exists('printdata', $resDa)) {
                                             //echo "<pre>"; print_r($list); die;
                                    $print_pass_array = array();
                                    $print_pass_array['MerchantMaster'] = $resDa['printdata']['merchant'];
                                    $print_pass_array['MerchantPackageMaster'] = $resDa['printdata']['package'];   
                                    //$print_pass_array['Pay'] = $newPack; 
                                   // $mm = new MerchantMaster();
                                    $print = $this->print($print_pass_array); 
                                    $printed ="";
                                    $base = Yii::$app->basePath; 
                                   // $printed =  $base.'/web/uploads/merchant/receipt/'.$model->merchantName.date('Y-m-d H:i').'.pdf'; 
                                    $printed = $user_data_role->merchantName.date('Y-m-d_H:i').'.pdf'; 
                                   // $model->ReceiptFile = $printed;
     
                                    $base1 = Url::base(); 
                                    if (strpos($base1,'api')) {  
                                       $base1 =  str_replace('api', 'backend', $base1);
                                    }
                                    $headers = 'From: afynder@gmail.com' . "\r\n" .
                                        'Reply-To: noreply@afynder.com' . "\r\n" .
                                        'X-Mailer: PHP/' . phpversion();
                                    $headers .= "MIME-Version: 1.0\r\n";
                                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                    $to = trim($user_data_role->shopMailId);
                                    // $to = 'janarthanan.istrides@gmail.com';
                                    $url = base64_encode($to);
                                    $sub = "Merchant Subscription - Afynder";
                                    $body = '<h4>Dear '.$user_data_role->merchantName.',</h4>
                                    <p>Thank you for subscription renewal of aFynder. <br>Please click the link for payment receipt <a href="https://'.$_SERVER['HTTP_HOST'].$base1.'/uploads/merchant/receipt/'.$user_data_role->merchantName.date('Y-m-d H:i').'.pdf" target="_blank"  download="true">Download Receipt</a>
                                      </p>'; //echo $body; die; 
                                    $mail = mail($to,$sub,$body,$headers);
                                    if ($mail==true) {
                                    //  echo $to;  
                                    }else{
                                    //  echo "No";  
                                    }
                                    $user_data_role->paymentResponse = 'done';
                                    $user_data_role->save();
                                }
                            }                            
                        }
                    }                   

                }
            }
                
            if($log_id!=''){
                $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
                $model_log->response= json_encode($list);
                $model_log->save();
            }
        }
        return json_encode($list);
    } 


    public function actionProfileUpdate(){
        $list = array();                
        $list['status'] = 'error';
        $list['message'] = 'Invalid Authorization Request!';    
        if($user_data_role=$this->authorization()){
            $merchantId = $user_data_role->merchantId; 
            $postd=(Yii::$app ->request ->rawBody);
            $requestInput = json_decode($postd,true); 
            $uniqueCode = "";  
            if(array_key_exists('mobileUniqueCode', $requestInput)){
                $uniqueCode = $requestInput['mobileUniqueCode'];
            }
            $list['status'] = 'error';
            $list['message'] = 'Invalid Apimethod';
            
            $requestInput['merchantId'] = $merchantId;
            $requestInput['callReqFrom'] = 'appCall';

            $model_log = new ApiRequestResponseLog();
            $model_log->requestData = $postd;
            $model_log->apiMethod   = "Merchant Profile Update";
            $model_log->mobileCode  = $uniqueCode;
            $model_log->createdAt   = date("Y-m-d H:i:s");
            $model_log->save();
            $log_id = $model_log->autoid;

            $newMs = new MerchantMasterApi();
            $list  = $newMs->ProfileUpdate($requestInput,$_FILES);
                
            if($log_id!=''){
                $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
                $model_log->response= json_encode($list);
                $model_log->save();
            }
        }
        return json_encode($list);
    }   



    # Author : Jana
    # Timestamp : 25-07-2020 10:15 AM
    # Desc :  Merchant Product Management using Mobile Application

    public function actionProductManagement(){
        $list = array();                
        $list['status'] = 'error';
        $list['message'] = 'Invalid Authorization Request!';    
        if($user_data_role=$this->authorization()){
            $merchantId = $user_data_role->merchantId; 
            $shopName = $user_data_role->ShopName; 
            $postd=Yii::$app->request->post();
            // echo "<pre>";print_r($postd);die;
            $requestInput = $postd; 
            $uniqueCode = "";  
            if(array_key_exists('mobileUniqueCode', $requestInput)){
                $uniqueCode = $requestInput['mobileUniqueCode'];
            }
            $list['status'] = 'error';
            $list['message'] = 'Invalid Apimethod';
            
            $requestInput['merchantId'] = $merchantId;
            $requestInput['shopName'] = $shopName;
            $requestInput['callReqFrom'] = 'appCall';

            $model_log = new ApiRequestResponseLog();
            $model_log->requestData = $postd;
            $model_log->apiMethod   = "Merchant Profile Update";
            $model_log->mobileCode  = $uniqueCode;
            $model_log->createdAt   = date("Y-m-d H:i:s");
            $model_log->save();
            $log_id = $model_log->autoid;

            $newMs = new ProductMasterApi();
            $list  = $newMs->ProductMgnt($requestInput,$_FILES);
                
            if($log_id!=''){
                $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
                $model_log->response= json_encode($list);
                $model_log->save();
            }
        }
        return json_encode($list);
    }   



    # Author : Jana
    # Timestamp : 25-07-2020 10:15 AM
    # Desc :  Merchant Product Management using Mobile Application

    public function actionProductContent(){
        $list = array();                
        $list['status'] = 'error';
        $list['message'] = 'Invalid Authorization Request!';    
        if($user_data_role=$this->authorization()){
            $merchantId = $user_data_role->merchantId; 
            $postd=(Yii::$app ->request ->rawBody);
            $requestInput = json_decode($postd,true); 
            $uniqueCode = "";  
            if(array_key_exists('mobileUniqueCode', $requestInput)){
                $uniqueCode = $requestInput['mobileUniqueCode'];
            }
            $list['status'] = 'error';
            $list['message'] = 'Invalid Apimethod';
            
            $requestInput['merchantId'] = $merchantId;
            $requestInput['callReqFrom'] = 'appCall';

            $model_log = new ApiRequestResponseLog();        
            $model_log->requestData = $postd;
            $model_log->apiMethod   = "Merchant Management";
            $model_log->mobileCode  = $uniqueCode;
            $model_log->createdAt   = date("Y-m-d H:i:s");
            $model_log->save();
            $log_id = $model_log->autoid;

            $newMs = new ProductMasterApi();
            $list  = $newMs->ProductMgnt($requestInput);
            
            if($log_id!=''){
                $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
                $model_log->response= json_encode($list);
                $model_log->save();
            }
        }
        return json_encode($list);
    }   



    # Author : Jana
    # Timestamp : 30-07-2020 10:15 AM
    # Desc :  Merchant Product Management using Mobile Application

    public function actionOverallOffer(){
        $list = array();                
        $list['status'] = 'error';
        $list['message'] = 'Invalid Authorization Request!';    
        if($user_data_role=$this->authorization()){
            $merchantId = $user_data_role->merchantId; 
            $postd=(Yii::$app ->request ->rawBody);
            $requestInput = json_decode($postd,true); 
            $uniqueCode = "";  
            if(array_key_exists('mobileUniqueCode', $requestInput)){
                $uniqueCode = $requestInput['mobileUniqueCode'];
            }
            $list['status'] = 'error';
            $list['message'] = 'Invalid Apimethod';
            
            $requestInput['merchantId'] = $merchantId;
            $requestInput['callReqFrom'] = 'appCall';

            $model_log = new ApiRequestResponseLog();        
            $model_log->requestData = $postd;
            $model_log->apiMethod   = "Overall Offer";
            $model_log->mobileCode  = $uniqueCode;
            $model_log->createdAt   = date("Y-m-d H:i:s");
            $model_log->save();
            $log_id = $model_log->autoid;

            $newMs = new MerchantOverallOfferEditLogApi();
            $list  = $newMs->overallOffer($requestInput);
            
            if($log_id!=''){
                $model_log=ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
                $model_log->response= json_encode($list);
                $model_log->save();
            }
        }
        return json_encode($list);
    } 




    public function print($model=array()) {
        

        require ('../../vendor/tcpdf/tcpdf.php');
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 8, '', true);
        $pdf->SetMargins(10, false, 10, true); // set the margins
        $pdf->AddPage(); 
        $base = Yii::$app->basePath; 
            if (strpos($base,'frontend')) {
               $base =  str_replace('frontend', 'backend', $base);
            }
            if (strpos($base,'api')) {
               $base =  str_replace('api', 'backend', $base);
            }

        $files=$base.'/web/images/Logo.png';
        $filetype = explode('.', $files);
       $pdf->Image( $files, 35, 11, 30, '', 'PNG', '', 'L', false, 500, 'L', false, false, 0, false, false, false);
       $sno=1;

       $model = ArrayHelper::toArray($model); //echo "<pre>"; print_r($model); die;
       $merchantGST ="";
       if (array_key_exists('MerchantMaster', $model)) {
          if(array_key_exists('gstNumber', $model['MerchantMaster'])){
            $merchantGST = $model['MerchantMaster']['gstNumber'];
          }
        }
       $RandomGeneration = RandomGeneration::find()->where(['key_id'=>'Tax'])->one();

       $receiptnumber="";
       $RandomGenerationReceipt = RandomGeneration::find()->where(['key_id'=>'receipt'])->one();
       if (!empty($RandomGenerationReceipt)) {
         $receiptnumber = $RandomGenerationReceipt->random_number;
       }
       $RandomGenerationReceiptUpdate = RandomGeneration::find()->where(['key_id'=>'receipt'])->one();
       if (!empty($RandomGenerationReceiptUpdate)) { 
       $RandomGenerationReceiptUpdate->random_number = $RandomGenerationReceiptUpdate->random_number+1;
       $RandomGenerationReceiptUpdate->save();
       }
     //  echo "<pre>"; print_r($model); die;
       $tax = 18;
       if (!empty($RandomGeneration)) {
       $tax = $RandomGeneration->random_number; 
       }
       $packageAmount=0;
       $packageName="";
       $packageCode="";

       $merchantCode="";
       $merchantName=""; 
       $shopCategoryName=""; 
       $ShopAddress=""; 
       $shopContactNumber=""; 
       $shopMailId=""; 

       if (array_key_exists('MerchantMaster', $model)) {
          if(array_key_exists('merchantName', $model['MerchantMaster'])){
            $merchantName = $model['MerchantMaster']['merchantName'];
          }
          if(array_key_exists('merchantCode', $model['MerchantMaster'])){
            $merchantCode = $model['MerchantMaster']['merchantCode'];
          }
          if(array_key_exists('shopCategoryName', $model['MerchantMaster'])){
            $shopCategoryName = $model['MerchantMaster']['shopCategoryName'];
          }
          if(array_key_exists('ShopAddress', $model['MerchantMaster'])){
            $ShopAddress = $model['MerchantMaster']['ShopAddress'];
          }
          if(array_key_exists('shopContactNumber', $model['MerchantMaster'])){
            $shopContactNumber = $model['MerchantMaster']['shopContactNumber'];
          } 
          if(array_key_exists('shopMailId', $model['MerchantMaster'])){
            $shopMailId = $model['MerchantMaster']['shopMailId'];
          }
        }

       if (array_key_exists('MerchantPackageMaster', $model)) {
          if(array_key_exists('packageAmount', $model['MerchantPackageMaster'])){
            $packageAmount = $model['MerchantPackageMaster']['packageAmount'];
          }
          if(array_key_exists('packageName', $model['MerchantPackageMaster'])){
            $packageName = $model['MerchantPackageMaster']['packageName'];
          }
          if(array_key_exists('packageCode', $model['MerchantPackageMaster'])){
            $packageCode = $model['MerchantPackageMaster']['packageCode'];
          }
       }
       
       $calculation_amount = ($packageAmount * $tax)/100;
       $total = $calculation_amount+$packageAmount;
       
      $html = '
      <html>
      <style>
      .custom-font{
        font-size:12px;
      }
      .border-cst{
        border-bottom:1px #FF5722;
        border-bottom-width:14px;
      }
      .border-cs{
        border-style: solid;
      }
       .border-cs1{
        border-bottom: 1px #000 solid;
        margin-bottom: 5px;
      }
      .ht-cs{
        line-height:25px;
      }
      .head-cs{
       background-color:#ff5722;
       color:white;
      }
     </style>
     <body>
    <div class="border-cst"></div>
    <p></p>
       <div>
        <table width="100%">
        <tr>
        <td align="right" width="20%"><h4>Afynder</h4></td>
        <td style="text-align:right"width="80%"><b>RECEIPT</b></td> 
        </tr>
        <tr>
        <td  width="54%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;First Floor. SF No: 556, Site No: 01, Thadagam Road,</td>
        <td width="46%"></td>
        </tr>
        <tr>
        <td width="13%"></td>
        <td align="" width="51.5%">&nbsp;&nbsp; Near Avila Convent Higher Secondary School, Coimbatore, 641 025</td>
        <td width="37.5%"></td>
        </tr>
        <tr>
        <td align="right" width="24.4%">919047767564</td> 
        <td style="text-align:right" width="75.6%"> '.date('d-m-Y H:i:s').' </td>
        </tr>
        <tr>
        <td align="right" width="34.4%">&nbsp;&nbsp;GST NO: 33ABRFA8921E1ZE</td>  
        <td style="text-align:right" width="65.6%"><b>RECEIPT NO : MER-SUB-'.str_pad($receiptnumber, 6, '0', STR_PAD_LEFT).'</b></td>
        </tr>
 
         
        <tr>
        <td></td>
        <td></td>
        </tr>
        <tr>
        <td></td> 
        <td></td> 
        </tr>
        </table>
        </div>
        <p></p>
        <table border="0" class="custom-font">
        <thead>
        <tr>
        <th class="border-cs1" width="45%"><b>BILL TO</b></th>
        <th width="10%"></th>
        <th class="border-cs1" width="45%"><b>SHIP TO</b></th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td width="45%">'.$ShopName.'</td>
        <td width="10%"></td>
        <td width="45%">'.$ShopName.'</td>
        </tr>
        <tr>
        <td>'.$shopCategoryName.'</td>
        <td></td>
        <td>'.$shopCategoryName.'</td>
        </tr>
        <tr>
        <td>'.$ShopAddress.'</td>
        <td></td>
        <td>'.$ShopAddress.'</td>
        </tr>
        <tr>
        <td>'.$shopContactNumber.'</td>
        <td></td>
        <td>'.$shopContactNumber.'</td>
        </tr>
        <tr>
        <td>'.$shopMailId.'</td>
        <td></td>
        <td>'.$shopMailId.'</td>
        </tr>
        <tr>
        <td>GST- '.$merchantGST.'</td>
        <td></td>
        <td>GST- '.$merchantGST.'</td>
        </tr>
       </tbody>
        </table>
        <p></p>
        <table border="1" width="100%" class="custom-font">
        <thead>
        <tr>

        <th align="center" width="10%" class="head-cs"><b>SNO</b></th>
        <th align="center" width="20%" class="head-cs"><b>Package Name</b></th>
        <th align="center" width="20%" class="head-cs"><b>Package Code</b></th>
        <th align="center" width="10%" class="head-cs"><b>Amount</b></th>
        <th align="center" width="20%" class="head-cs"><b>Payment Type</b></th>
        <th align="center" width="20%" class="head-cs"><b>Paid Amount</b></th>
        
        </tr>
        </thead>
          <tbody>
          <tr>
          <td width="10%">1</td>
          <td width="20%">'.$packageName.'</td>
          <td width="20%">'.$packageCode.'</td>
          <td align="right" width="10%">'.number_format($packageAmount,2).'</td>
          <td width="20%">'."Cash".'</td>
          <td align="right" width="20%">'.number_format($total,2).'</td>
          
          </tr>
          </tbody>
        </table>
         <table border="0" width="100%" class="custom-font">
          <tbody>
          <tr>
          <td style="text-align:center">Remarks, notes</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>   
          </tr>
          <tr>
          <td></td>
          <td></td>
          <td></td>
          <td align="right" class="ht-cs"><b>Actual Amount</b></td>
          <td align="right" class="border-cs1 ht-cs"><b>'.number_format($packageAmount,2).'</b></td>
          </tr>
          
          <tr>
          <td></td>
          <td></td>
          <td></td>
          <td align="right" class="ht-cs"><b>Tax Rate(%)</b></td>
          <td align="right" class="border-cs1 ht-cs"><b>'.number_format($tax,2).'</b></td>
          </tr>
          <tr>
          <td></td>
          <td></td>
          <td></td>
          <td align="right" class="ht-cs"><b>Tax Amount</b></td>
          <td align="right" class="border-cs1 ht-cs"><b>'.number_format($calculation_amount,2).'</b></td>
          </tr>
          <tr>
          <td></td>
          <td></td>
          <td></td>
          <td align="right" class="ht-cs"><b>Final Amount</b></td>
          <td align="right" class="border-cs1"><b>'.number_format($total,2).'</b></td>
          </tr>
          <tr>
          <td></td>
          <td></td>
          <td></td>
          <td align="right" class="ht-cs"><b>Paid Amount</b></td>
          <td align="right" class="border-cs1"><b>'.number_format($total,2).'</b></td>
          </tr>
          
          </tbody>
        </table>
        <p></p><p></p><p></p><p></p><p></p>
            <div class="border-cst"></div>
        </body>
        </html>';
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);  
       
             $base = Yii::$app->basePath; 
            if (strpos($base,'frontend')) {
               $base =  str_replace('frontend', 'backend', $base);
            }
            if (strpos($base,'api')) {
               $base =  str_replace('api', 'backend', $base);
            }
       // $pdf->Output('Afynder_print.pdf');
       return $pdf->Output($base.'/web/uploads/merchant/receipt/'.$merchantName.date('Y-m-d H:i').'.pdf', 'F');
    }  

    public function actionWalletHistory(){
        $list = array();                
        $list['status'] = 'error';
        $list['message'] = 'Invalid Authorization Request!';    
        if($user_data_role=$this->authorization()){
            $merchantId = $user_data_role->merchantId; 
            $postd=(Yii::$app ->request ->rawBody);
            $requestInput = json_decode($postd,true); 
            $uniqueCode = "";  
            if(array_key_exists('mobileUniqueCode', $requestInput)){
                $uniqueCode = $requestInput['mobileUniqueCode'];
            }
            $list['status'] = 'error';
            $list['message'] = 'Invalid Apimethod';
            
            $requestInput['referenceId'] = $merchantId;
            $requestInput['requestFrom'] = 'merchant';

            $model_log = new ApiRequestResponseLog();        
            $model_log->requestData = $postd;
            $model_log->apiMethod   = "Shopee Wallet history";
            $model_log->mobileCode  = $uniqueCode;
            $model_log->createdAt   = date("Y-m-d H:i:s");
            $model_log->save();
            $log_id = $model_log->autoid;

            $newMs = new ReferalMergeLogApi();
            $list  = $newMs->WalletHistory($requestInput);
            
            if($log_id!=''){
                $model_log = ApiRequestResponseLog::find()->where(['autoid'=>$log_id])->one();
                $model_log->response = json_encode($list);
                $model_log->save();
            }
        }
        return json_encode($list);
    }   
}


