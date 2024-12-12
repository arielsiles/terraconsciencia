window.onload = function(){
    let randomModal = Math.floor(Math.random() * (6 - 1 + 1)) + 1;
    if(randomModal == 1){
        document.getElementById("m1").style.display="block";
    }else if(randomModal == 2){
        document.getElementById("m2").style.display="block";
    }else if(randomModal == 3){
        document.getElementById("m3").style.display="block";
    }else if(randomModal == 4){
        document.getElementById("m4").style.display="block";
    }else if(randomModal == 5){
        document.getElementById("m5").style.display="block";
    }else if(randomModal == 6){
        document.getElementById("m6").style.display="block";
    }
}