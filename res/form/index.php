<?$APPLICATION->IncludeComponent(
		"res:form",
		"",
		Array(
				"ARRAY_FIELDS_REQUIRED" => array(
						"name",
						"email",
						"message",
				),
				"VALIDATE_FIELDS" => array(
						"name" => "name",
				),
				"ELEMENT_SORT_FIELD" => "sort",
				"ELEMENT_SORT_ORDER" => "asc",
				"SEND_EMAIL_USER" => "Y",
				"EMAIL_TO" => "vv@ff.vob",
				"TEXT_MESSAGE" => "test",
				"NAME_TEMPLATE" => "",
				"TITLE_FORM" => "Title form",
				"ARRAY_FIELDS" =>array(
						"name" => "name text",
						"email" => "email",
						"message" => "message",
				),
				"ADD_CUSTOM_FIELD" => array(
						array(
								"name" => "sity",
								"tag" => "input:text",
								"level" => "field",
						),
				),
				"USE_CAPTCHA" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
		)
);
?>
