
var world;
var futureMorph;
var scripts;
var target_script;
var cur_code;
window.onload = function () {
        world = new WorldMorph(document.getElementById('world'), false);
        world.worldCanvas.focus();
        futureMorph = new IDE_Morph();
        futureMorph.openIn(world);
        var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
            document.xxx = xhttp;
      if (xhttp.readyState == 4 && xhttp.status == 200) {
                futureMorph.rawOpenProjectString(xhttp.responseText);
        futureMorph.selectSprite(futureMorph.sprites.contents[1]);
        scripts = futureMorph.sprites.contents[1].scripts.children;
        hideUnwantedScripts();
                futureMorph.stage.fireGreenFlagEvent();
      }
    };
    xhttp.open("GET", "/snap/test.xml", true);
    xhttp.send();
    element = document.getElementById("world_container");
        world.resize(element.clientWidth-18,560);
        //world.resizeChildren();
        setInterval(loop, 1);
    };
  function hideUnwantedScripts() {
    var len = scripts.length;
    for (var i = 0; i < len; i++) {
      if (scripts[i].selector != "evaluateCustomBlock") {
        scripts[i].hide()
      } else {
        target_script = scripts[i];
        scripts[i].isDraggable = false
        var ring = scripts[i].children[scripts[i].children.length-1]
        ring.isDraggable = false;
        ring.children[ring.children.length-1].hide();
        ring.fixLayout();
      }
    }
  }
	function loop() {
		world.doOneCycle();
	}

  function update_code() {
    target_script.mouseClickLeft(true);
  }

  function viewCode() {
    update_code();
    futureMorph.stage.doCustomBroadcastEvent("show_code");
  }

  function runCode() {
    update_code();
    futureMorph.stage.doCustomBroadcastEvent("run_code");
  }

  function showCode() {
    displayCode();
    $("#cur_code").modal();
  }

  function displayCode() {
    $(".cur_code").text(cur_code);
  }

  function successful() {
    displayCode();
    $("#cash_points").text("5");
    $("#reward_points").text("1");
    $("#badge_points").text("1");
    $("#successful").modal();
  }

  function unsuccessful() {
    displayCode();
    $("#unsuccessful").modal();
  }

  $( window ).resize(function() {
    element = document.getElementById("world_container");
		world.resize(element.clientWidth-18,560);
  });

  $('a[popup]').on('click', function(event) {
    event.preventDefault();
    return PopupCenter(this.href, 'popup', '500', '500');
  });
