<?php
$Auth = new App\models\Auth();

/*-----------------------------------
В случае если была передана форма
-----------------------------------*/
if($_POST["method_name"] == "enter")
{
    try{
        $resAuth = $Auth->enter($_POST);
    }
    catch(Exception $e)
    {
        $error = ["error_text" => $e->getMessage()];
        $inputs_val = $_POST;
        include "App/views/login.php";
        exit;
    }
}


/*-----------------------------------
Если были переданы GET параметры
-----------------------------------*/
if($_GET["confirm_email"])
{
    try{
        $resAuth = $Auth->confirm_email($_GET["confirm_email"]);
    }
    catch(Exception $e)
    {
        $error = ["error_text" => $e->getMessage()];
    }
}

/*-----------------------------------
Если существуют проблемы (errors)
-----------------------------------*/
if($error)
{
    include "App/views/for_error.php";
}
else if($resAuth["type"] == "register")
{
    $succes = ["succes_text" => "Спасибо, проверьте свою почту, для завершения регистрации."];
    include "App/views/login.php";
}
else if($resAuth["type"] == "auth")
{
    header("Location: /");
}
else{
    include "App/views/login.php";
}


