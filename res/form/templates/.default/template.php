<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>


<?php //var_dump($arResult["error_message"]); ?>

<form id="contact-form" method="post" action="<?=POST_FORM_ACTION_URI?>">

    <input type="hidden" name="id_form" value="contact-form" >
    <?php if(!empty($arParams["TITLE_FORM"])): ?>
        <h2><?=$arParams["TITLE_FORM"]?></h2>
    <?php endif; ?>
    <?php
        if(!empty($arParams["ARRAY_FIELDS"])){
            foreach ($arParams["ARRAY_FIELDS"] as $name_field => $field){
                $error_field = '<span style="color: darkred;padding-left: 10px">'.$arResult["error_message"]["$name_field"].'</span>';
                switch ($name_field) {
                    case "email":
                        echo '<input type="email"  name="email"  placeholder="'.$field.'" />'.$error_field.'<br>';
                        break;
                    case "message":
                        echo '<textarea  name="message" placeholder="'.$field.'"  rows="5" ></textarea>'.$error_field.'<br>';
                        break;
                    default:
                        echo '<input type="text" name="'.$name_field.'"  placeholder="'.$field.'" >'.$error_field.'<br>';
                }
            }
        }
    if(!empty($arParams["ADD_CUSTOM_FIELD"])){
        foreach ($arParams["ADD_CUSTOM_FIELD"] as  $field){
            $tag = explode(":", $field["tag"]);
            $name = $field['name'];
            switch ($tag[0]) {
                case "input":
                    echo '<input type="'.$tag[1].'" name="'.$name.'"  placeholder="'.$field['label'].'" ><span class="error">'.$arResult["error_message"]["$name"].'</span><br>';
                    break;
                case "textarea":
                    echo '<textarea  name="'.$name.'" placeholder="'.$field['label'].'"  rows="5" ></textarea><span class="error">'.$arResult["error_message"]["$name"].'</span><br>';
                    break;
            }
        }
    }
  ?>

    <?php if($arParams["USE_CAPTCHA"] == "Y"): ?>
        <input type="hidden" name="captcha_sid" value="<?=$arResult["captcha"];?>" />
        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["captcha"];?>" alt="CAPTCHA" />
        <span style="color: darkred;padding-left: 10px"><?=$arResult["error_message"]["captcha"]?></span>
    <? endif; ?>
    <input type="submit" value="Send">

</form>

<span style="color: limegreen;"><?=$arResult["success"]?></span>

