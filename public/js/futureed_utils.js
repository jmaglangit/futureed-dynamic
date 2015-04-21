function shuffle(array) {
  var m = array.length, t, i;
    // While there remain elements to shuffle
    while (m) {
      // Pick a remaining element…
      i = Math.floor(Math.random() * m--);

      // And swap it with the current element.
      t = array[m];
      array[m] = array[i];
      array[i] = t;
    }

  return array;
}

function highlight_empty(form_id) {
    var has_empty = false;
    $("#"+form_id +" input").each(function() {
      var value = $(this).val();
      
      if(value == "") {
        has_empty = true;
        $(this).addClass("required-field");
      } else {
        $(this).removeClass("required-field");
      }
    });

    $("#"+form_id +" select").each(function() {
      var value = $(this).val();

      if(value == "") {
        has_empty = true;
        $(this).addClass("required-field");
      } else {
        $(this).removeClass("required-field");
      }
    });

    return has_empty;
}