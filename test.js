var aTag = document.createElement("div");
aTag.innerHTML = "test";
aTag.style.position = fixed;
aTag.style.position = "fixed";
aTag.style.height = "100vh";
aTag.style.width = "100vw";
aTag.style.position = "fixed";
aTag.style.background= "black";



var parent = document.getElementsByTagName('body');

parent.appendChild(aTag);
