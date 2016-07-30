<?php

//Входные параметры: Get параметр для мультиленда: &utp=, имя MIGX TV: utp:
$utp = strip_tags($_GET["utp"]);
$migx = $modx->resource->getTVValue('utp');

//Функция для обработки картинок - MIGXImgThumb(изображение, ширина, высота):
if(!function_exists(MIGXImgThumb)) {
	function MIGXImgThumb($img, $w, $h) {
		global $modx;
		return $modx->runSnippet("phpthumbof", array('input' => $img, 'options' => 'w='.$w.'&height='.$h.'&zc=1'));
	}
}

$arr_migx = $modx->fromJSON($migx);
foreach($arr_migx as $arr_migx_set) {
	if($arr_migx_set['url'] == $utp) {
		
		//1) Наполняем значения из TV MIGX [В квадратных скобках имена полей из MIGX TV]:
		$data_title = $arr_migx_set['title'];
		$data_description = $arr_migx_set['description'];
		$data_image = MIGXImgThumb($arr_migx_set['image'], 250, 250);
		
	}
}

if($data_title == '') {
	
	//2) Определяем дефолтные значения: сбрасываем все поля на 0 элемент массива:
	$data_title = $arr_migx['0']['title'];
	$data_description = $arr_migx['0']['description'];
	$data_image = MIGXImgThumb($arr_migx['0']['image'], 250, 250);
	
}

switch ($element) {

	//3) Определяем вывод элементов в параметрах сниппета:
	case "title": return $data_title; break;
	case "description": return $data_description; break;
	case "image": return $data_image; break;

}
