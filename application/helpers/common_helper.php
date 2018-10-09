<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('send_response')){
	
	function send_response($message, $data = [])
	{
		//header('Content-Type: application/json');
		if(!empty($data))
			echo json_encode(array('status' => 'ok', 'message' => $message, 'data' => $data));
		else
			echo json_encode(array('status' => 'ok', 'message' => $message));
		exit;
	}
	
}


if(!function_exists('send_error_response')){
	
	function send_error_response($message)
	{
		//header('Content-Type: application/json');
		echo json_encode(array('status' => 'error', 'message' => $message));
		exit;
	}
	
}

function excelToArray($filePath, $header=true){
        //Create excel reader after determining the file type
        $inputFileName = $filePath;
        /**  Identify the type of $inputFileName  **/
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /** Set read type to read cell data onl **/
        $objReader->setReadDataOnly(true);
        /**  Load $inputFileName to a PHPExcel Object  **/
        $objPHPExcel = $objReader->load($inputFileName);
        //Get worksheet and built array with first row as header
        $objWorksheet = $objPHPExcel->getActiveSheet();
        //excel with first row header, use header as key
        if($header){
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();
            $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
            $headingsArray = $headingsArray[1];
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][strtolower(str_replace(' ', '_', $columnHeading))] = $dataRow[$row][$columnKey];
                    }
                }
            }
        }
        else{
            //excel sheet with no header
            $namedDataArray = $objWorksheet->toArray(null,true,true,true);
        }
        return $namedDataArray;
}

 function nice_number($n) {
    // first strip any formatting;
    $n = (0+str_replace(",", "", $n));

    // is this a number?
    if (!is_numeric($n)) return false;

    // now filter it;
    if ($n > 1000000000000) return round(($n/1000000000000), 2).' T';
    elseif ($n > 1000000000) return round(($n/1000000000), 2).' B';
    elseif ($n > 1000000) return round(($n/1000000), 2).' M';
    elseif ($n > 1000) return round(($n/1000), 2).' K';

    return number_format($n);
}

function profile_img($img){
    if($img=='')
        return "./dist/img/user.jpg";
    else
        return "./upload/$img";
}

function time_elapsed_string($datetime, $full = false) {
    date_default_timezone_set('Asia/Colombo');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
