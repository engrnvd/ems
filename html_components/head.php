<?php require_once __DIR__ . '/get_pages.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $currentPageTitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <link rel="stylesheet" type="text/css" href="css/nvd.css">
    <?php require_once __DIR__ . '/js_import.php'; ?>
</head>
<body id='<?php echo strtolower(str_replace(" ", "_", $currentPageTitle)); ?>'>
<header class="pageHeader container hidden-print gridBkg">

    <?php if ($user->isLoggedIn()): ?>
        <div id='loginInfo' class="hidden-print">
            <p><a href="userSettings.php"><?php echo icon('user') . " " . $user->userFullName(); ?></a></p>

            <p><a href='login.php?logout=true'><?php echo icon('log-out'); ?> Logout</a></p>
        </div>
    <?php endif;
    $imgSrc = "images/Logo.png"?>
    <div id="logo"><img src="<?= $imgSrc ?>" alt=""/></div>
    <hgroup>
        <h1><?php echo $app_info['site_title']; ?></h1>

        <h2 class="hidden-xs"><?php echo $app_info['slogan']; ?></h2>
    </hgroup>
</header>