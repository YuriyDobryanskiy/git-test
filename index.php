<?php
session_start();
if ($_POST["text_sms"]){
	$text_sms = rus2translit($_POST["text_sms"]);
	$reg = '/ \r\n/';

	$text_sms = preg_replace($reg, "\r\n", $text_sms);
	$strLenght = mb_strlen(trim($text_sms));
	$countENTER = substr_count(trim($text_sms), "\n");

	$strLenght = $strLenght - $countENTER;
	$count_sms = ceil($strLenght / 160);

	if($count_sms>1){
		$count_sms = ceil($strLenght / 153);
		$lefts = (153*$count_sms) % $strLenght;
	}else{
		$count_sms = ceil($strLenght / 160);
		$lefts = (160*$count_sms) % $strLenght;
	}
	
	$_SESSION['textSms'] = $text_sms;
	$_SESSION['countSms'] = $count_sms;
	$_SESSION['strLenght'] = $strLenght;
	$_SESSION['lefts'] = $lefts;	

	
	header('Location: '.$_SERVER['HTTP_REFERER']);
}
if(!isset($_SESSION['strLenght'])){
	$_SESSION['countSms'] = 1;
	$_SESSION['strLenght'] = 0;		
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Check sms len</title>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Caveat|Gabriela" rel="stylesheet">

<style>
*{margin:0;padding:0;}

.wrapper{
	width:100%;overflow:hidden;min-width:1000px;
}
.wrapper-message{
	width:840px;
	min-width:500px;
	margin:0 auto 5%;
	height:580px;
	overflow:hidden;
	border-radius:15px;
	padding-top:20px;
}
.message{
	width: 100%;
    height: 100%;
    background: white url(img/popup_bg.jpg) no-repeat 100% 100% / 100% 100%;
	border-radius: 15px;
}
.main-block{padding:10px 35px;}

.main-block h1{
	font-family: 'Caveat', cursive;
	color:black;
	font-size: 38px;
	padding: 30px 10px 10px 12%;
	margin:0 0 10px;
}
.main-block p{
	font-family: 'Gabriela', cursive;
	color: black;
	font-size: 16px;
	padding: 15px 10px 30px 55px;
	border-top: 1px dashed orange;
}

table{width:100%;}
table td:first-child{width:12%;}
table label{
	font-family: 'Gabriela', cursive;
    color: black;
    font-size: 17px;
    font-weight: bold;
    margin-right: 12px;
}
table textarea{
	border: 1px dashed orange;
	font-family: 'Gabriela', cursive;
	color: black;
	font-size: 14px;
	padding: 10px;
	resize:none;
}
table textarea:focus{
	outline-offset: 0px !important;
	outline: none !important;
}
table #button{
	padding-top: 11px;
	text-align: right;	
}
table #button button{
	border: 0;
	background-color: #ffcb05;
	padding: 5px 25px;
	border-radius: 8px;
	font-family: 'Caveat', cursive;
	color: black;
	font-size: 25px;
	font-weight: bold;
	cursor:pointer;
	border:1px solid white;
	box-shadow: 3px 3px 6px #eaeaea;
	margin: 0 0 20px;
}
table #button button:hover{box-shadow: 0px 0px 0px #eaeaea;}


.testBlock{
	width:120%;
	padding-bottom:15px;
	background:rgba(239,64,70,.2) url(img/land_figure_big2.png) repeat 107% 49% / 50%;
	border-bottom-right-radius:220% 130%;
	border-bottom-left-radius:220% 130%;
	margin-left: -10%;
}

#tabs{
	display: inline-block;
    background-color: rgba(239,64,70,.2);
    padding: 6px 10px;
    border-radius: 7px;
    margin-right: 10px;
    box-shadow: 2px 2px 3px rgba(0,0,0,.1);
	font-family: 'Gabriela', cursive;
}
.footer-block{
	outline: 1px solid yellow;
}
</style>
</head>

<body>
<?php
//var_dump ($_SESSION);
?>
	<div class="wrapper">
		<div class="testBlock">
			<div class="wrapper-message">
				<div class="message">
					<div class="main-block">
						<h1>Перевірка смс повідомлення</h1>
						<form action="" method="post">
						<table>
							<tr>
								<td valign="top"><label>Текст:</label></td>
								<td><textarea name="text_sms" rows="15" cols="70" id="bar"><?=trim($_SESSION['textSms']);?></textarea></td>	
							</tr>
							<tr>
								<td colspan="2" id="button"><button type="submit" value="send" name="submit">Перевірити</button></td>
							</tr>
						</table>
						</form>
						<div>
						<div id="tabs"><?= "довжина: <strong> $_SESSION[strLenght]</strong>"?></div>
						<div id="tabs"><?= "к-сть: <strong>$_SESSION[countSms]</strong>"?></div>
						<div id="tabs"><?= "залишилось символів: <strong>$_SESSION[lefts]</strong>"?></div>
						</div>
					</div>
				</div>
				<div class="footer-block">
					
				</div>
			</div>
			
		</div>
	
	</div>

</body>
</html>


<?php
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',	 'є' => 'ie',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i', 	'і' => 'i',  'ї' => 'yi',	'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',	'–' => '-',		';' => ',' ,
		'«' => '"',		'»' => '"' ,
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',   'Є' => 'IE',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'І' => 'I',	'Ї' => 'YI',	'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}

?>