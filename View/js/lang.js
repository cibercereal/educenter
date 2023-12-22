var translate;

/**Sets the language, if lang is not sended, the default is Spanish*/
function setLang(lang = "") {
    if (lang == "") {
        if (getCookie("lang") != "") {
            lang = getCookie("lang");
        } else {
            lang = "ES";
        }
    }
    
    setCookie("lang", lang, 1);

    switch (lang) {
      case "ES":
        translate = arrayES;
        document.getElementById("langImage").src = "./Resources/Spain.png";
        break;
      case "EN":
        translate = arrayEN;
        document.getElementById("langImage").src = "./Resources/United-Kingdom.png";
        break;
      case "GA":
        translate = arrayGA;
        document.getElementById("langImage").src = "./Resources/Galicia.png";
        break;
      default:
        translate = arrayES;
        document.getElementById("langImage").src = "./Resources/Spain.png";
        break;
    }
  
    //**Se recorre el array de traducciones buscando coincidencias una por una*/
    for (var key in translate) {
    var elements = document.getElementsByClassName(key);
    var tags = document.getElementsByTagName("LABEL");
    var inputs = document.getElementsByTagName("input");
    var imgs = document.getElementsByTagName("img");
    var options = document.getElementsByTagName("option");
    var textAreas = document.getElementsByTagName("textarea");
  
    for (var elem in elements) {
        if (elements[elem] != undefined) {
            elements[elem].innerHTML = translate[key];
        }
    }

    for (var i = 0; i < tags.length; i++) {
        if (tags[i].htmlFor == key) {
            tags[i].innerHTML = translate[key];
        }
    }

    for (var i = 0; i < inputs.length; i++) {
        var list = inputs[i].classList;
        for (var j = 0; j < list.length; j++) {
            if (list[j] == key) {
                inputs[i].placeholder = translate[key];
            }
        }
    }
  
    for (var i = 0; i < imgs.length; i++) {
        var list = imgs[i].classList;
        for (var j = 0; j < list.length; j++) {
            if (list[j] == key) {
                imgs[i].alt = translate[key];
            }
        }
    }
  
    for (var i = 0; i < options.length; i++) {
        if (options[i].className == key) {
            options[i].label = translate[key];
            options[i].value = translate[key];
        }
    }
  
        for (var i = 0; i < textAreas.length; i++) {
            var list = textAreas[i].classList;
            for (var j = 0; j < list.length; j++) {
                if (list[j] == key) {
                    textAreas[i].placeholder = translate[key];
                }
            }
        }
    }
}
  
/**Function to change the lang.*/
function changeLang(lang) {
    setCookie("lang", lang, 5);
    window.location.reload(true);
}

function translateWord(value) {
    var lang = getCookie("lang") != "" ? getCookie("lang") : "ES";
    
    setCookie("lang", lang, 1);

    switch (lang) {
        case "ES":
          translate = arrayES;
          break;
        case "EN":
          translate = arrayEN;
          break;
        case "GA":
          translate = arrayGA;
          break;
        default:
          translate = arrayES;
          break;
    }

    for (var key in translate) {
        if(key == value) {
            return translate[key];
        }
    }

    return value;
}