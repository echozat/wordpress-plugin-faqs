<?php 
namespace faqs;

function faqsGetCheckBoxVal($Value)
{
	if($Value == 'on')
	{
		return 1;
	}
	
	return 0;
}

function faqsRemoveRepeatedDataFromArray($Data)
{
    $NData = array();
    foreach ($Data as $key => $value) {

        if(!in_array($value->cat_name, $NData))
        {
            array_push($NData, $value->cat_name);
        }       
        
    }
    
    return $NData;
}

function faqsExplodeFields($Data)
{
    $Data = preg_replace('/\W/',' ', $Data);
    $Data = preg_replace('/\s+/', ' ', $Data);
    $Data = trim($Data);

    $Data = explode(' ', $Data);
    $Data = array_unique($Data);      

    return $Data;
}

function faqsGetFormFieldsData($Data)
{
    $FieldData = array();
    $FieldInnData = array();

    foreach ($Data['name'] as $key => $value) 
    {
       $FieldInnData['name'] = $value;
       array_push($FieldData, $FieldInnData);
    }

    return json_encode($FieldData);
}

function faqsCreateSlug($text)
{
   $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $text);

   return $slug;
}

function faqsGetInputFields($Fields)
{
    foreach ($Fields as $value) 
    {
        $field .= $value;
    }

    return $field;
}

function faqsGetCheckBox($Value)
{
    if($Value == '1')
    {
        echo 'checked';
    }
    else
    {
        echo '';
    }
}

function faqsRedirectTo($url)
{
    if (headers_sent())
    {
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }
    else
    {
      header('Location: ' . $url);
      die();
    }    
}

function addhttp($url) 
{
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) 
    {
        $url = "http://" . $url;
    }
    
    return $url;
}

?>