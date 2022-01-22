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
}
?>
