<?php
namespace MoneyChanger;

class View
{
    public static function getResponseView($exchangeString)
    {
        View::getInitialView();

        $html = '<link rel="stylesheet" type="text/css" href="../style.css"/>';

        $html .= '
            <div id="response" class="white_content" onload="script();">' . $exchangeString . '</div>

            <script>
                console.log("dupa");
                document.getElementById("light").style.display="block";
                document.getElementById("fade").style.display="block"
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
                <form action="index.php" method="post">
                    <input name="money" type="text">
                    <input type="submit">
                </form>
            </div>
        ';

        echo $html;
    }
}