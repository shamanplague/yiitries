function playViewForAI() {

    document.write("<div style='text-align: center; width: 50%; display: inline-block;'>");

    for (var i = 0; i < 10; i++) {
        document.write('<br>');
        for (var j = 0; j < 10; j++) {
            var index = String(i) + String(j) + '_AI';
            document.write("<img id = '" + index + "' onclick='move(this)' onmouseout='defineColor(this, ai_field, true) ' onmouseover='makeRed(this)'>");

            defineColor(document.getElementById(index), ai_field, true);

        }
    }

    document.write('</div>');

}

function move(object) {
    //console.log(object.id);
    var x = object.id.substring(0,1);
    var y = object.id.substring(1,2);
    //console.log('/?action=battle&x=' + x + '&y=' + y);
    document.location.href = '/?action=move&x=' + x + '&y=' + y;
}

function playViewForUser() {

    document.write("<div style='text-align: center; width: 50%; display: inline-block;'>");

    for (i = 0; i < 10; i++) {
        document.write('<br>');
        for (j = 0; j < 10; j++) {
            var index = String(i) + String(j);
            document.write("<img id = '" + index + "'>");

            defineColor(document.getElementById(index), users_field);

        }
    }

    document.write('</div>');

}

function defineColor(cell, field, forAi=false) {

    var row = Number(cell.id.substring(0, 1));
    var col = Number(cell.id.substring(1, 2));

    switch (field[row][col]) {
        case 'e':
            makeBlue(cell);
            break;
        case 's':
            if(forAi) makeBlue(cell);
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