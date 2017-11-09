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

function getTarget(e) {
  var e = e || window.event;
  var target = e.currentTarget || e.srcElement;

  return target;
}

function getEvent(e) {
  var e = e || window.event;
  return e;
}

function isStringNullorEmpty(string) {
  if(string == null || string.trim().length == 0) {
    return true;
  }

  return false;
}

function isDataEmpty(data){
  if(data == null || data.length == 0){
    return true;
  }
  return false;
}

function isEmpty(obj) {

    // null and undefined are "empty"
    if (obj == null) return true;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }

    return true;
}