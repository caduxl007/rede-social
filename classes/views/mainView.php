<?php
    namespace Views;
    
    class mainView{
        public static function render($fileName,$arr = [],$header = 'pages/includes/header.php',$footer = 'pages/includes/footer.php'){
            include($header);
            include('pages/'.$fileName);
            include($footer);
            die();
        }
    }
?>