<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$fields_form = array();
$array_name_field = array_keys($arParams["ARRAY_FIELDS"]);

$form_requests = $_REQUEST;

if($arParams["USE_CAPTCHA"] == "Y"){
    $arResult["captcha"]=$APPLICATION->CaptchaGetCode();
}

if(!empty($form_requests["id_form"])) {

//validate
    $error_message = array();
    $error_required = array();


    if(!empty($arParams["ARRAY_FIELDS_REQUIRED"])){
        foreach ($arParams["ARRAY_FIELDS_REQUIRED"] as  $name_field ){
            if(empty($form_requests["$name_field"])){
                $error_required["$name_field"] = "field required";
            }
        }
    }

    if(!empty($form_requests)){
        foreach ($arParams["VALIDATE_FIELDS"] as $name_field => $validate){

            switch ($validate) {
                case "name":
                    if (!preg_match("/^[a-zA-Z ]*$/",$form_requests["$name_field"])) {
                        $error_message["$name_field"] = "Only letters and white space allowed";
                    }
                    break;
                case "email":
                    if (!filter_var($form_requests["$name_field"], FILTER_VALIDATE_EMAIL)) {
                        $error_message["$name_field"] = "error email";
                    }
                    break;
            }
        }
    }

    if($arParams["USE_CAPTCHA"] == "Y"){
        if (!$APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_sid"]))
        {
            $error_message["captcha"] = "wrong captcha code";
        }
    }


    $arResult["error_message"] = array_merge($error_message,$error_required);

//send email
    if(empty($arResult["error_message"])){
        $arMailFields = Array();
        $arMailFields[] = array("EMAIL_TO" => $arParams["EMAIL_TO"]);
        foreach($array_name_field as $name_field){
            $arMailFields[] = array(strtoupper($name_field) => trim ($form_requests["error_message"]));
        }

        CEvent::Send($arParams["TEMPLATE"], SITE_ID , $arMailFields);
        AddMessage2Log("Отправка", "CEvent::Send");

        if($arParams["SEND_EMAIL_USER"] == "Y"){
            $arMailFields["EMAIL_TO"] = $form_requests["email"];
            $arMailFields["MESSAGE"] = $arParams["TEXT_MESSAGE"];

            CEvent::Send($arParams["TEMPLATE"], SITE_ID , $arMailFields);
            AddMessage2Log("Отправка", "CEvent::Send");
        }
        $arResult["success"] = "Success";
    }
}

$this->IncludeComponentTemplate();
?>