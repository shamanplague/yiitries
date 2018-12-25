function filling() {

    player = findGetParameter('player');

    var recieved_field = $.ajax({
        type: "GET",
        url: "http://yiitries.local/index.php?r=site%2Fgetfield",
        async: false,
        data:  'player=' + player,
        dataType: 'json'
    }).responseText;

    recieved_field = JSON.parse(recieved_field);

    console.log(recieved_field);

    field_for_placement = Array(Array(), Array(),Array(),Array(),Array(),Array(),Array(),Array(),Array(),Array());;

    console.log(recieved_field);

    for(var cell in recieved_field){
        //console.log(recieved_field[cell]);
        var currentCell = recieved_field[cell];
        var x = currentCell.x;
        var y = currentCell.y;
        var state = currentCell.state;
        field_for_placement[x][y] = state;
    }

    pre_field = [4, 3, 3, 2, 2, 2, 1, 1, 1, 1, 0];
    shipNames = [10, 9, 8, 7, 6, 5, 4, 3, 2, 1];

    deck_number = pre_field.shift();

    document.write("<h3 align='center'>Расстановка кораблей для " + player + "</h3>");

    document.write("<input type='checkbox' name='vertical'><label for='vertical'>Вертикальное размещение</label><br>");

    for (var i = 0; i < 10; i++) {
        document.write('<br>');
        for(var j = 0; j < 10; j++) {
            var index = String(i) + String(j);
            document.write("<img id = '" + index + "' onclick='placeShip(this)' onmouseout='outOfField(this)' onmouseover='overField(this)'>");

            defineColor(document.getElementById(index), field_for_placement);
        }
    }
}

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function placeShip(object){

    if (!isAvailable(object)) return;

    if (document.getElementsByName('vertical')[0].checked) {

        var row = Number(object.id.substring(0, 1));
        var col = object.id.substring(1, 2);
        var ship = [];


        for(var i = 0; i < deck_number; i++) {
            field_for_placement[row + i][col] = 's';

            ship.push({
                'x': row + i,
                'y': col
            })

        }

        $.ajax({
            url: 'http://yiitries.local/index.php?r=site%2Fplaceship',
            type: "POST",
            data: 'ship=' + JSON.stringify(ship) + '&player=' + player + '&shipname=' + shipNames.shift(),
            dataType: 'json'
        });


        //console.log(ship);

            deck_number = pre_field.shift();
        if (deck_number == 0) {
            if (player == 'PlayerOne') {

                document.write("<h1 align='center'>Расстановка кораблей второго игрока!</h1>");
                setTimeout(function () {
                    document.location.href = 'http://yiitries.local/index.php?r=site%2Fplacement&player=PlayerTwo';
                }, 2000);

            }

            else

            {
                document.write("<h1 align='center'>Игра начинается!</h1>");
                setTimeout(function () {
                    document.location.href = 'http://yiitries.local/index.php?r=site%2Fbattle&player=PlayerOne';
                }, 2000);
            }
        }

    }

    else {

        var row = object.id.substring(0, 1);
        var col = Number(object.id.substring(1, 2));
        var ship = [];

        for(var i = 0; i < deck_number; i++) {

            field_for_placement[row][col + i] = 's';

            ship.push({
                'x': row,
                'y': col + i
            })
        }

        $.ajax({
            url: 'http://yiitries.local/index.php?r=site%2Fplaceship',
            type: "POST",
            data: 'ship=' + JSON.stringify(ship) + '&player=' + player + '&shipname=' + shipNames.shift(),
            dataType: 'json'
        });

        //console.log(ship);

            deck_number = pre_field.shift();
        if (deck_number == 0){
            if (player == 'PlayerOne') {

                document.write("<h1 align='center'>Расстановка кораблей второго игрока!</h1>");
                setTimeout(function () {
                    document.location.href = 'http://yiitries.local/index.php?r=site%2Fplacement&player=PlayerTwo';
                }, 2000);

            }

            else

            {
                document.write("<h1 align='center'>Игра начинается!</h1>");
                setTimeout(function () {
                    document.location.href = 'http://yiitries.local/index.php?r=site%2Fbattle&player=PlayerOne';
                }, 2000);
            }
        }

    }

}

function defineColor(cell) {
    //console.log(cell);

    var row = Number(cell.id.substring(0, 1));
    var col = Number(cell.id.substring(1, 2));

    switch (field_for_placement[row][col]) {
        case 'e':
            makeBlue(cell);
            break;
        case 's':
            makeYellow(cell);
            break;
    }
}

function overField(obj) {

    if (document.getElementsByName('vertical')[0].checked) {

        var row = Number(obj.id.substring(0, 1));
        var col = obj.id.substring(1, 2);

        for (i = 0; i < deck_number; i++) {
            var str = '';
            if (row + i > 9) return;
            else str += String(row + i);
            str += String(col);
            if (isAvailable(obj, true)) {
                makeGreen(document.getElementById(str));
            }
            else {
                makeRed(document.getElementById(str));
            }

        }

    }

    else {

        var row = obj.id.substring(0, 1);
        var col = Number(obj.id.substring(1, 2));

        for (i = 0; i < deck_number; i++) {
            var str = String(row);
            if (col + i > 9) return;
            else str += String(col + i);
            if (isAvailable(obj, false)){
                makeGreen(document.getElementById(str));
            }
            else
            {
                makeRed(document.getElementById(str));
            }

        }

    }
}

function outOfField(obj) {

    if(document.getElementsByName('vertical')[0].checked) {

        var row = Number(obj.id.substring(0, 1));
        var col = obj.id.substring(1, 2);
        var i = 0;

        while (i < deck_number && row + i < 10){

            var str = '';
            str += String(row + i);
            str += String(col);

            defineColor(document.getElementById(str), field_for_placement);

            i++;
        }

    }

    else

    {

        var row = obj.id.substring(0,1);
        var col = Number(obj.id.substring(1,2));
        var i = 0;

        while (i < deck_number && col + i < 10){

            var str = String(row);
            str += String(col + i);

            defineColor(document.getElementById(str), field_for_placement);

            i++;
        }

    }
}

function isAvailable(object) {

    var row = Number(object.id.substring(0, 1));
    var col = Number(object.id.substring(1, 2));

    var start_point_x = row - 1;
    var start_point_y = col - 1;

    if (document.getElementsByName('vertical')[0].checked){

        for (y = start_point_y; y < start_point_y + 3; y++){
            for (x = start_point_x; x < start_point_x + deck_number + 2; x++){
                if (x < 0 || y < 0 || x == 10 || y == 10) continue;
                if (x > 10|| y > 10) return false;
                if (field_for_placement[x][y] == 's') return false;
            }
        }


    }

    else

    {

        for (x = start_point_x; x < start_point_x + 3; x++){
            for (y = start_point_y; y < start_point_y + deck_number + 2; y++) {
                if (x < 0 || y < 0 || x == 10 || y == 10) continue;
                if (x > 10 ||y > 10) return false;
                if (field_for_placement[x][y] == 's') return false;

            }
        }

    }

    return true;

}

function makeRed(object) {
    object.src = 'img/red.png';
}

function makeBlue(object) {
    object.src = 'img/blue.png';
}

function makeGreen(object) {
    object.src = 'img/green.png';
}

function makeYellow(object) {
    object.src = 'img/yellow.png';
}