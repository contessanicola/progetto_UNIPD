<?php
class importModules{

    public static function header() {
        $header_return = file_get_contents("../html/modules/header.html")."\n";
        return $header_return;
    }

    public static function nav_offline() {
        $header_return = file_get_contents("../html/modules/nav_offline.html")."\n";
        return $header_return;
    }

    public static function nav_online() {
        $header_return = file_get_contents("../html/modules/nav_online.html")."\n";
        return $header_return;
    }

    public static function sidebar() {
        $sidebar_return = file_get_contents("../html/modules/sidebar.html")."\n";
        return $sidebar_return;
    }

    public static function footer() {
        $footer_return = file_get_contents("../html/modules/footer.html")."\n";
        return $footer_return;
    }

    public static function metatags() {
        $meta_return = file_get_contents("../html/modules/metatags.html")."\n";
        return $meta_return;
    }

    public static function importEverythingOnline($output){
        $output = str_replace('<meta>',importModules::metatags(),$output);
        $output = str_replace('<header></header>',importModules::header(),$output);
        $output = str_replace('<nav id="sidebar"></nav>',importModules::sidebar(),$output);
        $output = str_replace('<footer></footer>',importModules::footer(),$output);
        $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_online(), $output);
        return $output;
    }

    public static function importEverythingOffline($output){
        $output = str_replace('<meta>',importModules::metatags(),$output);
        $output = str_replace('<header></header>',importModules::header(),$output);
        $output = str_replace('<nav id="sidebar"></nav>',importModules::sidebar(),$output);
        $output = str_replace('<footer></footer>',importModules::footer(),$output);
        $output = str_replace('<div id="nav_area_riservata"></div>',importModules::nav_offline(), $output);
        return $output;
    }
}
?>
