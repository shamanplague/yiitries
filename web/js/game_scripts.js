function playViewForPlayerOne() {

    fieldForCurrentPlayer = getField('PlayerOne');

    fieldForEnemy = getField('PlayerTwo');

    paintEnemyField();

    paintPlayersField();

}

function playViewForPlayerTwo() {

    fieldForCurrentPlayer = getField('PlayerTwo');

    fieldForEnemy = getField('PlayerOne');

    paintEnemyField();

    paintPlayersField();

}

function paintPlayersField() {

    document.write("<div name='user' style='text-align: center; width: 50%; display: inline-block;'>");

    for (var i = 0; i < 10; i++) {
        document.write('<br>');
        for (var j = 0; j < 10; j++) {
            var index = String(i) + String(j);
            document.write("<img id = '" + index + "'>");

            defineColor(document.getElementById(index), fieldForCurrentPlayer);

        }
    }

    document.write('</div>');
}

function paintEnemyField() {

    document.write("<div name='enemy' style='text-align: center; width: 50%; display: inline-block;'>");

    for (var i = 0; i < 10; i++) {
        document.write('<br>');
        for (var j = 0; j < 10; j++) {
            var index = String(i) + String(j) + '_Enemy';
             document.write("<img id = '" + index + "' onclick='move(this)' onmouseout='defineColor(this, fieldForEnemy, true) ' onmouseover='makeRed(this)'>");

            defineColor(document.getElementById(index), fieldForEnemy, true);

        }
    }

    document.write('</div>');
}

function getField(owner) {

    var recieved_field = $.ajax({
        type: "GET",
        url: "http://yiitries.local/index.php?r=site%2Fgetfield",
        async: false,
        data:  'player=' + owner,
        dataType: 'json'
    }).responseText;

    recieved_field = JSON.parse(recieved_field);

    var resultField = Array(Array(), Array(),Array(),Array(),Array(),Array(),Array(),Array(),Array(),Array());;

    for(var cell in recieved_field){
        var currentCell = recieved_field[cell];
        var x = currentCell.x;
        var y = currentCell.y;
        var state = currentCell.state;
        resultField[x][y] = state;
    }

    return resultField;
}

function move(object) {

    var row = object.id.substring(0, 1);
    var col = object.id.substring(1, 2);
    var nextplayer = (findGetParameter('player') == 'PlayerOne')? 'PlayerTwo':'PlayerOne';

    var hitResult = $.ajax({
        type: "GET",
        url: "http://yiitries.local/index.php?r=site%2Fhitresult",
        async: false,
        data:  'x=' + row + '&y=' + col + '&player=' + nextplayer,
        dataType: 'json'
    }).responseText;

    fieldForEnemy[row][col] = hitResult;

    defineColor(object, fieldForEnemy, true);

    var winner = getWinner();

    if (winner)
    {

        document.write("<h1 align='center'>Победил " + winner + "</h1>");
        document.write("<h3 align='center'><a href='/'>На главную</a></h3>");

    }

    if(hitResult == 'm')
    {

        document.write("<div align ='center'>Переход хода! Теперь бьёт " + nextplayer + "!");

        document.write("<br><a href=http://yiitries.local/index.php?r=site%2Fbattle&player="
            + nextplayer + ">Готов!</a></div>")

    }

}

function getWinner() {
    var winner = $.ajax({
        type: "GET",
        url: "http://yiitries.local/index.php?r=site%2Fgetwinner",
        async: false
    }).responseText;

    return winner;
}

function defineColor(cell, field, forEnemy=false) {

    var row = Number(cell.id.substring(0, 1));
    var col = Number(cell.id.substring(1, 2));

    switch (field[row][col]) {
        case 'e':
            makeBlue(cell);
            break;
        case 's':
            if(forEnemy) makeBlue(cell);
            else
            makeYellow(cell);
            break;
        case 'm':
            makeMiss(cell);
            break;
        case 'c':
            makeCrashed(cell);
            break;
        case 'd':
            makeDestroyed(cell);
            break;
    }
}

function makeRed(object) {
    object.src = 'img/red.png';
}

function makeBlue(object) {
    object.src = 'img/blue.png';
}

function makeYellow(object) {
    object.src = 'img/yellow.png';
}

function makeMiss(object){
    object.src = 'img/miss.png';
}

function makeCrashed(object){
    object.src = 'img/crashed.png';
}

function makeDestroyed(object){
    object.src = 'img/destroyed.png';
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