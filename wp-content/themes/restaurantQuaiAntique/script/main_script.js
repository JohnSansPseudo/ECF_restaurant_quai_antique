"use strict";
window.addEventListener('load', function(){


    document.getElementById('btnNewGame').addEventListener('click', function(){ oBoardGame.initGame(); });
    document.getElementById('btnRollDice').addEventListener('click', function(){
        if(oBoardGame.gameOn === false){ oBoardGame.messageNewGame();}
        else { oBoardGame.rollDiceBoard(); }
    });
    document.getElementById('btnHold').addEventListener('click', function(){
        if(oBoardGame.gameOn === false){ oBoardGame.messageNewGame();}
        else{ oBoardGame.hold(); }
    });

    document.getElementById('boxCtnToast').addEventListener('click', function (e){
        if(e.target.classList.contains(ToastAlert.CLASS_CTN_TOAST_ALERT)) e.target.remove();
    });

});