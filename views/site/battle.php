<?php

/**
 * Created by PhpStorm.
 * User: shaman
 * Date: 01.12.18
 * Time: 12:20
 */

use app\models\Game;

$current_game = new Game;

echo '<h1 align="center">Battle</h1>';

?>

<body>

<div id="users_field" align="center">

    <script>
        ai_field = <?= json_encode($current_game->ai_field)?>;
        users_field = <?= json_encode($current_game->users_field)?>;
        playViewForAI();
        playViewForUser();
    </script>

</div>

</body>