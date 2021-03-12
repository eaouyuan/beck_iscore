<?php
$modversion = array();

//---模組基本資訊---//
$modversion['name']        = _MI_beck_iscore_NAME;
$modversion['version']     = 1.00;
$modversion['description'] = _MI_beck_iscore_DESCRIPTION;
$modversion['author']      = 'Beck';
$modversion['credits']     = '';
$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image']       = 'images/logo.png';
$modversion['dirname']     = basename(dirname(__FILE__));

//---模組狀態資訊---//
$modversion['release_date']        = '2021/01/05';
$modversion['module_website_url']  = 'http://模組官網網址';
$modversion['module_website_name'] = '模組官網名稱';
$modversion['module_status']       = 'release';
$modversion['author_website_url']  = 'http://作者網站網址';
$modversion['author_website_name'] = '作者網站名稱';
$modversion['min_php']             = 5.4;
$modversion['min_xoops']           = '2.5';

//---paypal資訊---//
$modversion['paypal']                  = array();
$modversion['paypal']['business']      = 'eaouyuan@gmail.com';
$modversion['paypal']['item_name']     = 'Donation : ' . 'Beck';
$modversion['paypal']['amount']        = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---模組資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/nzsmr_teacher.sql';
$modversion['tables'][]         = 'yy_teacher';                //教師管理
$modversion['tables'][]         = 'yy_department';             //學程 國甲乙 餐飲 資處 美容
$modversion['tables'][]         = 'beck_iscore_files_center';  //檔案上傳
$modversion['tables'][]         = 'yy_student';                //學生基本資料
$modversion['tables'][]         = 'yy_announcement';           //公佈欄
$modversion['tables'][]         = 'yy_announcement_class';     //公佈欄分類
$modversion['tables'][]         = 'yy_dept';                   //處室分類名稱

//---後台管理介面設定---//
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 1;
//$i=1;
//$modversion['sub'][$i]['name'] = '';
//$modversion['sub'][$i]['url'] = '';
//$i++;

//---模組自動功能---//
$modversion['onInstall'] = "include/onInstall.php";//安裝時
$modversion['onUpdate'] = "include/onUpdate.php";     //更新時
$modversion['onUninstall'] = "include/onUninstall.php"; //反安裝時

//---樣板設定---//
$modversion['templates']                    = array();
$i                                          = 1;
$modversion['templates'][$i]['file']        = 'beck_iscore_adm_teacher.tpl';
$modversion['templates'][$i]['description'] = '後台教師管理樣版';

$i++;
$modversion['templates'][$i]['file']        = 'beck_iscore_adm_department.tpl';
$modversion['templates'][$i]['description'] = '後台學程管理樣版';

$i++;
$modversion['templates'][$i]['file']        = 'beck_iscore_adm_student.tpl';
$modversion['templates'][$i]['description'] = '後台學生基本資料管理樣版';

$i++;
$modversion['templates'][$i]['file']        = 'beck_iscore_index.tpl';
$modversion['templates'][$i]['description'] = '前台成績系統輸入樣板';

// $i++;
// $modversion['templates'][$i]['file']        = 'demo_adm_main.tpl';
// $modversion['templates'][$i]['description'] = '後台管理頁樣板';

//---偏好設定---//
$modversion['config']                    = array();
$i                                       = 0;
$modversion['config'][$i]['name']        = 'show_num';
$modversion['config'][$i]['title']       = '_MI_SNEWS_SHOW_NUM';
$modversion['config'][$i]['description'] = '_MI_SNEWS_SHOW_NUM_DESC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 6;

$i++;

//---搜尋---//
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.php";
$modversion['search']['func'] = "beck_iscore_search";

//---區塊設定---//
$modversion['blocks'] = array();
$i=1;
$modversion['blocks'][$i]['file']        = "beck_iscore_block_focus.php";
$modversion['blocks'][$i]['name']        = _MI_BECK_ISOCRE_BLOCK_FOCUS;
$modversion['blocks'][$i]['description'] = _MI_BECK_ISOCRE_BLOCK_FOCUS_DESC;
$modversion['blocks'][$i]['show_func']   = "beck_isocre_block_focus";
$modversion['blocks'][$i]['template']    = "beck_isocre_block_focus.tpl";
$modversion['blocks'][$i]['edit_func']   = "beck_isocre_block_focus_edit";
$modversion['blocks'][$i]['options']     = "2|240";

$i++;

//---評論---//
//$modversion['hasComments'] = 1;
//$modversion['comments']['pageName'] = '單一頁面.php';
//$modversion['comments']['itemName'] = '主編號';

//---通知---//
//$modversion['hasNotification'] = 1;
