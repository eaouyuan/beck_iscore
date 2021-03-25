<?php
namespace XoopsModules\beck_iscore;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\StarRating;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\SyntaxHighlighter;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;

//TadNews物件
/*



 */
class dept_school
{


    private static $_instance;
    public $kind = 'news'; //news,page,mixed
 

    //建構函數
    public function __construct()
    {
        // global $xoopsConfig;

        // xoops_loadLanguage('main', 'tadnews');

        // $this->now = date('Y-m-d', xoops_getUserTimestamp(time()));
        // $this->today = date('Y-m-d H:i:s', xoops_getUserTimestamp(time()));

        // $moduleHandler = xoops_getHandler('module');
        // $this->tadnewsModule = $moduleHandler->getByDirname('tadnews');
        // $this->module_id = $this->tadnewsModule->getVar('mid');
        // $configHandler = xoops_getHandler('config');
        // $this->tadnewsConfig = $configHandler->getConfigsByCat(0, $this->tadnewsModule->getVar('mid'));

        // if ('1' == $this->tadnewsConfig['use_star_rating']) {
        //     $this->set_use_star_rating(true);
        // }
        // $this->TadUpFiles = new TadUpFiles('tadnews');
        // $this->TadDataCenter = new TadDataCenter('tadnews');
    }

    public static function aaa()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

    //處室分類下拉選單
    public static function GetDept_Class_Sel_htm($Dept_c_id,$space='0')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;

        $tbl     = $xoopsDB->prefix('yy_dept_school');
        $sql     = "SELECT * FROM $tbl WHERE `enable` ='1' ORDER BY `sn`";
        $result  = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        if($space=='0'){
            $htm='<option selected></option>';
        }else{
            $htm='';
        }

        while($Dept_cls= $xoopsDB->fetchArray($result)){
            $selected= ($Dept_c_id==$Dept_cls['sn'])?'selected':'';
            $htm.='<option value="'.$Dept_cls['sn'].'" '.$selected.'  >'.$Dept_cls['dept_name'].'</option>';
        }

        // var_dump($htm);die();
        return ($htm);
    }

    //取得處室
    public static function GetDept($id)
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;

        $tbl    = $xoopsDB->prefix('yy_dept_school');
        $sql    = "SELECT * FROM $tbl WHERE `sn` ='{$id}'  ORDER BY `sn`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $Dept   = $xoopsDB->fetchArray($result);
    
        // var_dump($Dept);die();
        return ($Dept);
    }

    //取得分類新聞
    public function get_cate_news($mode = 'assign', $include_sub_cate = false)
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser;


        $pic_w = $this->tadnewsConfig['cate_pic_width'] + 10;

        $SyntaxHighlighter = new SyntaxHighlighter();
        $SyntaxHighlighter->render();

        //取得目前使用者的所屬群組
        if ($xoopsUser) {
            $User_Groups = $xoopsUser->getGroups();
            $now_uid = $xoopsUser->uid();
        } else {
            $User_Groups = [];
            $now_uid = 0;
        }

        $where_news = '';

        //分析目前觀看得是新聞還是自訂頁面
        if ('news' === $this->kind) {
            $kind_chk = "and not_news!='1'";
        } elseif ('page' === $this->kind) {
            $kind_chk = "and not_news='1'";
        } else {
            $kind_chk = '';
        }

        if (is_array($this->view_ncsn)) {
            $show_ncsn = implode(',', $this->view_ncsn);
            $and_cate = empty($show_ncsn) ? '' : "and ncsn in({$show_ncsn})";
        } elseif ('' == $this->view_ncsn) {
            $and_cate = '';
        } else {
            $and_cate = "and ncsn={$this->view_ncsn}";
        }

        $sql = 'select ncsn,nc_title,enable_group,enable_post_group,cate_pic,setup from ' . $xoopsDB->prefix('tad_news_cate') . " where 1  $and_cate $kind_chk order by sort";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $i = 0;
        $only_title = false;
        $only_title_cate = [];
        while (list($ncsn, $nc_title, $enable_group, $enable_post_group, $cate_pic, $setup) = $xoopsDB->fetchRow($result)) {
            //只有可讀的分類才納入
            $cate_read_power = $this->chk_cate_power($ncsn, $User_Groups, $enable_group, 'read');

            if (!$cate_read_power) {
                //是否僅秀出標題
                $only_title = false !== mb_strpos($setup, 'only_title=1') ? true : false;
                $only_title_cate[$ncsn] = $only_title;
                $only_title_cate_group[$ncsn] = Utility::txt_to_group_name($enable_group, '', ' , ');
                if (!$only_title) {
                    // die($nc_title);
                    continue;
                }
            }

            $pic = (empty($cate_pic)) ? XOOPS_URL . '/modules/tadnews/images/no_cover.png' : XOOPS_URL . "/uploads/tadnews/cate/{$cate_pic}";

            $and_enable = (1 == $this->show_enable) ? "and enable='1'" : '';

            $sql2 = ('page' === $this->kind) ? 'select * from ' . $xoopsDB->prefix('tad_news') . " where ncsn='{$ncsn}' $and_enable order by page_sort" : 'select * from ' . $xoopsDB->prefix('tad_news') . " where ncsn='{$ncsn}' $and_enable and start_day < '" . $this->today . "' and (end_day > '" . $this->today . "' or end_day='0000-00-00 00:00:00') order by always_top desc , start_day desc limit 0," . $this->show_num;

            $result2 = $xoopsDB->query($sql2) or Utility::web_error($sql2, __FILE__, __LINE__);

            $j = 0;
            $subnews = [];
            $only_title_cate = [];

            $myts = \MyTextSanitizer::getInstance();
            while (false !== ($news = $xoopsDB->fetchArray($result2))) {
                foreach ($news as $k => $v) {
                    $$k = $v;
                }

                if (!empty($passwd)) {
                    require_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
                    $XoopsFormHiddenToken = new \XoopsFormHiddenToken();
                    $XOOPS_TOKEN = $XoopsFormHiddenToken->render();

                    $tadnews_passw = (isset($_POST['tadnews_passwd'])) ? $_POST['tadnews_passwd'] : '';
                    if ($tadnews_passw != $passwd and !in_array($nsn, $have_pass)) {
                        if ('one' === $this->show_mode) {
                            $news_content = "
                        <div class='jumbotron'>
                        <p>" . _TADNEWS_NEWS_NEED_PASSWD . "</p>
                        <form action='" . XOOPS_URL . "/modules/tadnews/index.php' method='post'>
                                <fieldset>
                                <input type='hidden' name='nsn' value='{$nsn}'>
                                <input type='password' name='tadnews_passwd'>
                                $XOOPS_TOKEN
                                <button type='submit' class='btn btn-primary'>" . _TADNEWS_SUBMIT . '</button>
                                </fieldset>
                        </form>
                        </div>';
                        } else {
                            $news_content = '
                        <div>
                        <div>' . _TADNEWS_NEWS_NEED_PASSWD . "</div>
                        <form action='" . XOOPS_URL . "/modules/tadnews/index.php' method='post' style='display:inline'>
                            <fieldset>
                            <input type='hidden' name='nsn' value='{$nsn}'>
                            <input type='password' name='tadnews_passwd'>
                            $XOOPS_TOKEN
                            <button type='submit' class='btn btn-primary'>" . _TADNEWS_SUBMIT . '</button>
                            </fieldset>
                        </form>
                        </div>';
                        }
                        $tadnews_files = '';
                    } else {
                        $_SESSION['have_pass'][] = $nsn;
                    }
                } elseif (isset($only_title_cate[$ncsn]) and !empty($only_title_cate[$ncsn])) {
                    // die('enable_group:' . $enable_group);
                    $news_content = sprintf(_TADNEWS_NEED_LOGIN, $only_title_cate_group[$ncsn]);
                }

                // $news_read_power = $this->chk_news_power($enable_group, $User_Groups);
                // if (!$news_read_power) {
                //     continue;
                // }

                if (is_numeric($this->summary_num) and !empty($this->summary_num) and empty($passwd)) {
                    $news_content = strip_tags($news_content);
                    $style = (empty($this->summary_css)) ? '' : "style='{$this->summary_css}'";
                    //支援xlanguage
                    $news_content = $this->xlang($news_content);

                    $content = "<div $style>" . mb_substr($news_content, 0, $this->summary_num, _CHARSET) . '...</div>';
                } else {
                    $content = '';
                }
                if ('summary' === $this->show_mode or 'one' === $this->show_mode) {
                    $need_sign = (!empty($have_read_group)) ? XOOPS_URL . '/modules/tadnews/images/sign_bg.png' : '';
                } else {
                    $need_sign = (!empty($have_read_group)) ? XOOPS_URL . '/modules/tadnews/images/sign_s.png' : '';
                }

                $news_title = (empty($news_title)) ? _TADNEWS_NO_TITLE : $news_title;

                $subnews[$j]['content'] = $myts->displayTarea($content, 1, 1, 1, 1, 0);
                $subnews[$j]['post_date'] = mb_substr($start_day, 0, 10);
                $subnews[$j]['always_top_pic'] = $this->get_news_pic($always_top, mb_substr($start_day, 0, 10));
                $subnews[$j]['prefix_tag'] = $this->mk_prefix_tag($prefix_tag);
                $subnews[$j]['nsn'] = $nsn;
                $subnews[$j]['news_title'] = $myts->htmlSpecialChars($news_title);
                $subnews[$j]['counter'] = $counter;
                $subnews[$j]['need_sign'] = $need_sign;
                $subnews[$j]['files'] = $this->get_news_files($nsn, 'small');
                $j++;
            }
            $all_news[$i]['pic_w'] = $pic_w;
            $all_news[$i]['show_pic'] = $this->cover_use;
            $all_news[$i]['pic'] = $pic;
            $all_news[$i]['nc_title'] = $nc_title;
            $all_news[$i]['ncsn'] = $ncsn;
            $all_news[$i]['news'] = $subnews;
            $all_news[$i]['rowspan'] = $j + 1;

            // if ($include_sub_cate) {
            //     $this->get_cate_news('return', $include_sub_cate);
            // }

            $i++;
        }

        if ('return' === $mode) {
            $main['all_news'] = $all_news;

            return $main;
        }
        $xoopsTpl->assign('all_news', $all_news);
    }

}
