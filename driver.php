<?php
include('filesLogic.php');
require('config.php');
include("function.php");
include("auth_session.php");


error_reporting(1);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Driver Support</title>




    <!-- Bootstrap core CSS -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">



    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="register.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <a href="index.php">
                    <img class="d-block mx-auto mb-4" src="logo.png" alt="" width="72" height="72">
                </a>
                <h2>Driver Support</h2>
                <p class="lead">Get the latest drivers for your Enigma Devices</p>
            </div>

            <div class="row g-5">
                <table>
                    <thead>
                        <th>S No.</th>
                        <th>Driver</th>
                        <th>File Size</th>
                        <th>Downloads</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file) : ?>
                            <tr>
                                <td><?php echo $file['id']; ?></td>
                                <td><?php echo $file['name']; ?></td>
                                <td><?php echo floor($file['size'] / 1000) . ' KB'; ?></td>
                                <td><?php echo $file['downloads']; ?></td>
                                <td><a href="driver.php?file_id=<?php echo $file['id'] ?>">Download</a></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>


            </div>
        </main>

        <footer class="my-5 ptva-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2022 Enigma</p>

        </footer>
    </div>

</body>

</html>