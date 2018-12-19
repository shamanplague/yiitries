<body>

<h1 align="center">Бой!</h1>

<h3 align="center">Ходит <?=$_GET['player']?></h3>

    <script>

        if(findGetParameter('player') == 'PlayerOne') {
            playViewForPlayerOne();
        }
        else
        {
            playViewForPlayerTwo()
        }

    </script>

</body>