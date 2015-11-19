"use strict";

var numberOfBlocks = 9;
var targetBlocks = [];
var trapBlock;
var targetTimer;
var trapTimer;
var instantTimer;


document.observe('dom:loaded', function(){
	$("start").observe("click", function(){
		$("state").innerHTML = "Ready!";
		$("score").innerHTML = "0";
		clearInterval(targetTimer);
		clearInterval(trapTimer);
		clearInterval(instantTimer);
		setTimeout(startGame, 3000);
	});
	$("stop").observe("click", stopGame);
});

function startGame(){
	targetBlocks = [];
	trapBlock = null;

	var block = $$(".block");
	for(var i=0; i<block.length; i++) {
		block[i].removeClassName("target");
		block[i].removeClassName("trap");
	}
	startToCatch();
}

function stopGame(){
	$("state").innerHTML = "Stop";
	targetBlocks = [];
	trapBlock = null;
	clearInterval(targetTimer);
	clearInterval(trapTimer);
	clearInterval(instantTimer);
	
	var block = $$(".block");
	for(var i=0; i<block.length; i++) {	//detach the event handler
		block[i].stopObserving();
	}
}

function startToCatch(){
	$("state").innerHTML = "Catch!";
	var block = $$(".block");

	var ran1;
	targetTimer = setInterval(function(){
		ran1 = Math.floor(Math.random() * numberOfBlocks);
		while(block[ran1].hasClassName("target") || block[ran1].hasClassName("trap")){
			ran1 = Math.floor(Math.random() * numberOfBlocks);
		}
		targetBlocks.push(block[ran1]);

		block[ran1].addClassName("target");

		if(targetBlocks.length > 4) {
			clearInterval(targetTimer);
			clearInterval(trapTimer);
			clearInterval(instantTimer);
			alert("you lose");
			stopGame();
		}
	}, 1000);

	var ran2;
	trapTimer = setInterval(function(){
		ran2 = Math.floor(Math.random() * numberOfBlocks);
		while(block[ran2].hasClassName("target")){
			ran2 = Math.floor(Math.random() * numberOfBlocks);
		}
		trapBlock = block[ran2];
		block[ran2].addClassName("trap");

		instantTimer = setTimeout(function(){
			block[ran2].removeClassName("trap");
		}, 2000);
	}, 3000);
	
	for (var i = 0; i < block.length; i++) {
		block[i].observe("click", function(){
			var sc = $("score").innerHTML;
			if(!this.hasClassName("target") && !this.hasClassName("trap")){
				if(Number(sc) >= 10){
					sc = Number(sc) - 10;
				}
				this.addClassName("wrong");
				var ob = this;
				instantTimer = setTimeout(function(){
					ob.removeClassName("wrong");
				}, 100);
			}
			else if(this.hasClassName("target")){
				sc = Number(sc) + 20;
				this.removeClassName("target");
				for(var i=0; i<targetBlocks.length; i++){
					if(this == targetBlocks[i]) {
						targetBlocks.splice(i, 1);
					}
				}
			}
			else if(this.hasClassName("trap")){
				sc = Number(sc) - 30;
				this.removeClassName("trap");
			}
			$("score").innerHTML = sc;
		});
	}	
}