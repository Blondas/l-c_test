<?php
namespace MoneyChanger;

class View
{
    public static function getResponseView($exchangeString)
    {
        View::getInitialView();

        $html = '<link rel="stylesheet" type="text/css" href="src/MoneyChanger/style.css">';

        $html .= '
            <div id="response" onclick="window.location = window.location.href;" class="white_content" onload="script();">'
            . htmlentities($exchangeString) .
            '</div>

            <script>
                document.getElementById("response").style.display="block";
                document.getElementById("moneyChanger").style.display="block"
            </script>
        ';

        echo $html;
    }


    public static function getErrorView($errorMessage)
    {
        View::getInitialView();

        $html = '<div>' . $errorMessage . '</div>';

        echo $html;
    }


    public static function getInitialView()
    {
        $html = '';

        $html .= '
            <div id="moneyChanger" class="black_overlay">
                <form action="index.php" method="post" class="black_overlay">
                    <input name="money" type="text">
                    <input type="submit">
                </form>
            </div>
        ';

        echo $html;
    }
}