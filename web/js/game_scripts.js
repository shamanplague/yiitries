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