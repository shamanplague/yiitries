<?php

use app\models\Game;

$current_game = new Game;

?>

<body>

<h1 align="center">Battle</h1>

<div id="users_field" align="center">

    <script>
        //ai_field = <?//= json_encode($current_game->ai_field->cells)?>//;
        //users_field = <?//= json_encode($current_game->users_field->cells)?>//;

        ai_field = <?= json_encode($current_game->ai_field)?>;
        users_field = <?= json_encode($current_game->users_field)?>;

        playViewForAI();
        playViewForUser();

    </script>

</div>

</body>