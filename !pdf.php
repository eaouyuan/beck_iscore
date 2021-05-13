<?php
use Xmf\Request;
include_once "header.php";
require_once(TADTOOLS_PATH.'/tcpdf/tcpdf.php');
$pdf = new TCPDF("P", "mm", "A4");

$pdf->setPrintHeader(false); //不要頁首
$pdf->setPrintFooter(false); //不要頁尾
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);  //設定自動分頁
$pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）
$pdf->SetFont('droidsansfallback', '', 16, '', true); //設定字型
$pdf->SetMargins(15, 15); //設定頁面邊界，
$pdf->AddPage(); //新增頁面，一定要有，否則內容出不來

include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$sn = Request::getInt('sn');

$myts = MyTextSanitizer::getInstance();

$tbl      = $xoopsDB->prefix('yy_student');
$sql      = "SELECT * FROM $tbl Where `sn`='{$sn}'";
$result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
$students = $xoopsDB->fetchArray($result);//fetchrow

$students['stu_sn']                 = $myts->htmlSpecialChars($students['stu_sn']);
$students['stu_name']               = $myts->htmlSpecialChars($students['stu_name']);
$students['arrival_date']           = $myts->htmlSpecialChars($students['arrival_date']);
$students['birthday']               = $myts->htmlSpecialChars($students['birthday']);
$students['national_id']            = $myts->htmlSpecialChars($students['national_id']);
$students['ori_referral']           = $myts->htmlSpecialChars($students['ori_referral']);
$students['domicile']               = $myts->htmlSpecialChars($students['domicile']);
$students['ethnic_group']           = $myts->htmlSpecialChars($students['ethnic_group']);
$students['marital']                = $myts->htmlSpecialChars($students['marital']);
$students['height']                 = $myts->htmlSpecialChars($students['height']);
$students['weight']                 = $myts->htmlSpecialChars($students['weight']);
$students['Low_income']             = $myts->htmlSpecialChars($students['Low_income']);
$students['guardian_disability']    = $myts->htmlSpecialChars($students['guardian_disability']);
$students['referral_reason']        = $myts->htmlSpecialChars($students['referral_reason']);
$students['original_education']     = $myts->htmlSpecialChars($students['original_education']);
$students['original_school']        = $myts->htmlSpecialChars($students['original_school']);
$students['family_profile']         = $myts->displayTarea($students['family_profile'], 1, 0, 0, 0, 0);



$students['family_profile'] = strip_word_html($students['family_profile']);

$html         = new Tidy;
$tidy_options = array('clean' => true, 'indent' => true);
$html->parseString($students['family_profile'], $tidy_options, 'utf8');
$html->cleanRepair();

// die($html);

// $pdf->Text($pdf->GetX(),$pdf->GetY(),$students['family_profile'],$fstroke = false, $fclip = false, $ffill = true, $border = 1, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );

$pdf->SetFont('msungstdlight', '', 12, '', true); //設定字型

// $pdf->Text(15,50,$students['family_profile'] ,$fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 2, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );

// $pdf->writeHTML($html, $ln=1, $fill=0, $reseth=true, $cell =true, $align='');
$pdf->writeHTML($html  , 1,0);

// $content = strip_word_html($content);

// $html      = new Tidy();
// $tidy_options = array('clean' => true, 'indent' => true);
// $html->parseString($content, $tidy_options, 'utf8');
// $html->cleanRepair();

// // die($html);
// $title    = $myts->htmlSpecialChars($snews['title']);
// $username = $myts->htmlSpecialChars($snews['username']);


// //$pdf->Text( $x, $y, $txt, $fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );

// $pdf->SetFont('droidsansfallback', '', 24, '', true); //設定字型
// $pdf->Text($pdf->GetX(), $pdf->GetY(), $title, false, false, true, 0, 1);

// $pdf->SetFont('msungstdlight', '', 12, '', true); //設定字型
// $pdf->Text($pdf->GetX(), $pdf->GetY(), $username, false, false, true, 0, 1);

// $pdf->writeHTML($html, 1, 0);

//PDF內容設定
$pdf->Output('student.pdf', 'I');//瀏覽器觀看

function strip_word_html($text, $allowed_tags = '<a><b><blockquote><br><dd><del><div><dl><dt><em><h1><h2><h3><h4><h5><h6><hr><i><img><li><ol><p><pre><small><strong><sub><sup><table><tcpdf><td><th><thead><tr><tt><u><ul>')
{
    mb_regex_encoding('UTF-8');
    //replace MS special characters first
    $search  = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
    $replace = array('\'', '\'', '"', '"', '-');
    $text    = preg_replace($search, $replace, $text);
    if (mb_stripos($text, '/*') !== false) {
        $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
    }
    $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
    $text = strip_tags($text, $allowed_tags);
    $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
    $search  = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
    $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
    $text    = preg_replace($search, $replace, $text);
    $num_matches = preg_match_all("/\<!--/u", $text, $matches);
    if ($num_matches) {
        $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
    }
    $text = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $text);
    return $text;
}