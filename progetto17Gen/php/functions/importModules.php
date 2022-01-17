<?php
class importModules{

    public static function header() {
        $header_return = file_get_contents("../html/modules/header.html")."\n";
        $header_return .= "</header>"."\n";
        return $header_return;
    }

    public static function sidebar() {
        $sidebar_return = file_get_contents("../html/modules/sidebar.html")."\n";
        $sidebar_return .= "</sidebar>"."\n";
        return $sidebar_return;
    }

    public static function footer() {
        $footer_return = file_get_contents("../html/modules/footer.html")."\n";
        $footer_return .= "</footer>"."\n";
        return $footer_return;
    }
}
?>
