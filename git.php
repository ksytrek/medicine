<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sync git update</title>
</head>

<body>
    <?php

    // $output = shell_exec('git add -A');
    // echo "Add อมูลจาก server ให้ปัจจุบัน \" git add -A \"";
    // echo "<pre>$output</pre><br/>";


    // $output = shell_exec('git add -A;git commit -am "server up to git"');
    // echo "commit Github ให้ปัจจุบัน";
    // echo "<pre>$output</pre><br/>";sdfsd


// git push https://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@github.com/ksytrek/nsc_backup.git
    // $output = shell_exec('git push');
    // echo "อัพเดตข้อมูลไปยัง Github ให้ปัจจุบัน";
    // echo "<pre>$output</pre><br/>";

    // git push
    // git commit -am "server up to git"

    $output = shell_exec('git pull');
    echo "อัพเดตข้อมูลจาก Github ให้ปัจจุบัน";
    echo "<pre>$output</pre><br/>";
    
    // scsddsd

    // git add -A
    // git commit -am "server up to git"
    // git commit -a

    ?>
</body>

</html>