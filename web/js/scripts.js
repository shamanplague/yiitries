function filling() {

    //console.log(deck_number);

    pre_field = [4, 3, 3, 2, 2, 2, 1, 1, 1, 1, 0];
    deck_number = pre_field.shift();
    field_for_placement = Array(Array(), Array(),Array(),Array(),Array(),Array(),Array(),Array(),Array(),Array());

    for (var i = 0; i < 10; i++) {
        for (var j = 0; j < 10; j++) {
            field_for_placement[i][j] = 'e';
        }
    }

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

function placeShip(object){

    if (!isAvailable(object)) return;

    if (document.getElementsByName('vertical')[0].checked) {

        var row = Number(object.id.substring(0, 1));
        var col = object.id.substring(1, 2);

        for(var i = 0; i < deck_number; i++) {
            field_for_placement[row + i][col] = 's';

        }

        deck_number = pre_field.shift();
        if (deck_number == 0){
            console.log(field_for_placement);
        }
    }

    else {

        var row = object.id.substring(0, 1);
        var col = Number(object.id.substring(1, 2));

        for(var i = 0; i < deck_number; i++) {
            field_for_placement[row][col + i] = 's';

        }
        deck_number = pre_field.shift();
        if (deck_number == 0){
            console.log(field_for_placement);
        }

    }

}

function defineColor(cell) {

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

function playViewForAI() {

    document.write("<div style='text-align: center; width: 50%; display: inline-block;'>");

    for (var i = 0; i < 10; i++) {
        document.write('<br>');
        for (var j = 0; j < 10; j++) {
            var index = String(i) + String(j) + '_AI';
            document.write("<a name='" + index +
                "' href='/battleship/battleship.php?x=" + i + "&y=" + j +
                "'><img id = '" + index + "' width='30' onmouseout='defineColor(this, ai_field, true) ' onmouseover='makeRed(this)'></a> ");

            defineColor(document.getElementById(index), ai_field, true);

        }
    }

    document.write('</div>');

}

function playViewForUser() {

    document.write("<div style='text-align: center; width: 50%; display: inline-block;'>");

    for (i = 0; i < 10; i++) {
        document.write('<br>');
        for (j = 0; j < 10; j++) {
            var index = String(i) + String(j);
            document.write("<img id = '" + index + "' width='30'> ");

            defineColor(document.getElementById(index), users_field);

        }
    }

    document.write('</div>');

}

function defineColor(cell) {

    var row = Number(cell.id.substring(0, 1));
    var col = Number(cell.id.substring(1, 2));

    switch (field_for_placement[row][col]) {
        case 'e':
            makeBlue(cell);
            break;
        case 's':
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

function makeGreen(object) {
    object.src = 'img/green.png';
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