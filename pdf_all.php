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

// $pdf->Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = nil, $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M')
$pdf->SetFont('droidsansfallback', '', 24, '', true); //設定字型
$pdf->Cell(180, 24, '學生基本資料總表', 0, 1, 'C', 0);


include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$sn = Request::getInt('sn');

$myts = MyTextSanitizer::getInstance();

$tbl      = $xoopsDB->prefix('yy_student');
$sql      = "SELECT * FROM $tbl ORDER BY create_time DESC";
$result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

$pdf->SetFont('droidsansfallback', '', 12, '', true); //設定字型

while ($students = $xoopsDB->fetchArray($result)){
    $stu_sn              = $myts->htmlSpecialChars($students['stu_sn']);
    $stu_name            = $myts->htmlSpecialChars($students['stu_name']);
    $arrival_date        = $myts->htmlSpecialChars($students['arrival_date']);
    $birthday            = $myts->htmlSpecialChars($students['birthday']);
    $national_id         = $myts->htmlSpecialChars($students['national_id']);
    $ori_referral        = $myts->htmlSpecialChars($students['ori_referral']);
    $domicile            = $myts->htmlSpecialChars($students['domicile']);
    $ethnic_group        = $myts->htmlSpecialChars($students['ethnic_group']);
    $marital             = $myts->htmlSpecialChars($students['marital']);
    $height              = $myts->htmlSpecialChars($students['height']);
    $weight              = $myts->htmlSpecialChars($students['weight']);
    $Low_income          = $myts->htmlSpecialChars($students['Low_income']);
    $guardian_disability = $myts->htmlSpecialChars($students['guardian_disability']);
    $referral_reason     = $myts->htmlSpecialChars($students['referral_reason']);
    $original_education  = $myts->htmlSpecialChars($students['original_education']);
    $original_school     = $myts->htmlSpecialChars($students['original_school']);
    $family_profile      = $myts->displayTarea($students['family_profile'], 1, 0, 0, 0, 0);

    // $pdf->Cell(40, 10, $stu_sn, $border = 1,0,  'c',  0, XOOPS_URL."/modules/beck_iscore/index.php?op=student_show&sn={$students['sn']}",1);
    // $pdf->Cell(80, 10, $stu_name, $border = 1,0,  'c',  0, XOOPS_URL."/modules/beck_iscore/index.php?op=student_show&sn={$students['sn']}",1);
    // $pdf->Cell(40, 10, $arrival_date, $border = 1,1,  'c',  0, XOOPS_URL."/modules/beck_iscore/index.php?op=student_show&sn={$students['sn']}",1);

    // $pdf->MultiCell( $w, $h, $txt, $border = 0, $align = 'J', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false );
    // (1) $reseth若true會重設最後一格的高度
    // (2) $maxh高度上限（需>$h）
    // (3) $fitcell自動縮放字大小到格內
    
    // $pdf->MultiCell( 40, $height, $stu_sn, 1, 'L', false, 0,  '', '',  false, 0, false, false, $height, 'M', true);

    // $pdf->MultiCell( 80, $height, $stu_name, 1, 'L', false, 0,  '', '',  false, 0, false, false, $height, 'M', true);
    $pdf->MultiCell( 20, $height, $arrival_date, 1, 'C', false, 1,  '', '',  true, 0, false, false, $height, 'M', true);


}
$pdf->Image('images/aa.png', 180, 250, 20, 20, 'png');
$pdf->SetXY(100, 240);

$pdf->SetFont('droidsansfallback', '', 16, '', true); //設定字型
$pdf->Cell(20, 10, '簽名：', 0, 0);
$pdf->Cell(50, 10, '', 'B', 0, 0);





// $students['family_profile'] = strip_word_html($students['family_profile']);

// $html         = new Tidy;
// $tidy_options = array('clean' => true, 'indent' => true);
// $html->parseString($students['family_profile'], $tidy_options, 'utf8');
// $html->cleanRepair();

// die($html);

// $pdf->Text($pdf->GetX(),$pdf->GetY(),$students['family_profile'],$fstroke = false, $fclip = false, $ffill = true, $border = 1, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );

// $pdf->SetFont('msungstdlight', '', 12, '', true); //設定字型

// $pdf->Text(15,50,$students['family_profile'] ,$fstroke = false, $fclip = false, $ffill = true, $border = 0, $ln = 2, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M', $rtloff = false );

// $pdf->writeHTML($html, $ln=1, $fill=0, $reseth=true, $cell =true, $align='');
// $pdf->writeHTML($html  , 1,0);

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

