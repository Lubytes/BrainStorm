var posttop = 400;
var topPad = 250;
var leftPad = 320;

jsPlumb.ready(function () {

//this code is taken from the jsPlumb open source library, specifically the source and targets demo
//copyright info found in src/jsPlumb.js
//it's a work in progress
var sourceAnchors = [
        [ 0, 1, 0, 1 ],
        [ 0.25, 1, 0, 1 ],
        [ 0.5, 1, 0, 1 ],
        [ 0.75, 1, 0, 1 ],
        [ 1, 1, 0, 1 ]
    ];

//get the id of the head post
var headID = $('.headPost').attr('id');

    var instance = window.instance = jsPlumb.getInstance({
        // drag options
        //DragOptions: { cursor: "pointer", zIndex: 2000,  },
        // default to a gradient stroke from blue to green.
        PaintStyle: {
            gradient: { stops: [
                [ 0, "#0d78bc" ],
                [ 1, "#558822" ]
            ] },
            strokeStyle: "#558822",
            lineWidth: 3
        },
        Container: "canvas"
    });

    // click listener for the enable/disable link.
    jsPlumb.on(document.getElementById("enableDisableSource"), "click", function (e) {
        var state = instance.toggleSourceEnabled(headID);
        this.innerHTML = (state ? "disable" : "enable");
        jsPlumbUtil.consume(e);
    });

    

    // get the list of ".childOf" + headID elements.            
    var smallWindows = jsPlumb.getSelector(".smallPost");
    // make them draggable
    //instance.draggable(smallWindows);

    // suspend drawing and initialise.
    instance.batch(function () {

        // make 'window1' a connection source. notice the filter and filterExclude parameters: they tell jsPlumb to ignore drags
        // that started on the 'enable/disable' link on the blue window.
        instance.makeSource(headID, {
            filter:"button",
            filterExclude: true,
            maxConnections: -1,
            allowLoopback: false,
            dragAllowedWhenFull:false
            
        });

        // configure the .smallPosts as targets.
        instance.makeTarget(smallWindows, {
            filter:"button",
            filterExclude: true
        });
        
        
        instance.makeSource(smallWindows, {
            filter:"button",
            filterExclude: true,
            allowLoopback: false,
            maxConnections: -1,
            dragAllowedWhenFull:false
        });
        
        
    });

    //jsPlumb.fire("jsPlumbDemoLoaded", instance);
    
    
    
    jsPlumb.registerConnectionTypes({
	  "basic": {
		paintStyle:{ strokeStyle:"blue", lineWidth:5  },
		hoverPaintStyle:{ strokeStyle:"red", lineWidth:7 },
		cssClass:"connector-normal",
		detachable: false
	  }
	});
	

	var cons = [];

	$('.childOf' + headID).each( function(i,e) {
		/* you can use e.id instead of $(e).attr('id') */
		cons.push($(e).attr('id'));
		
	});
	
	var i = 0;
	var left = 50;
	var top = topPad + 100;
	for (i=0; i<cons.length; i++){
		$("#"+cons[i]).css("left", left);
		$("#"+cons[i]).css("top", top);
		left = left + leftPad;
		instance.connect({ source: headID, target: cons[i], anchors:[ "Bottom", "Top" ], type:"basic", detachable:false });
		//alert("connecting: " + cons[i] + " to " + headID);
	}
	
	//recursively makes connections
	//topPad += 150;
	makeConnection(cons);
	
});	

function makeConnection(c){
	var left = 30;
	//var cons = [];
	var k, j;
	for (k=0; k<c.length; k++){
		var head = c[k];
		var cons = []; //empty the array
		$('.childOf' + head).each( function(i,e) {
			/* you can use e.id instead of $(e).attr('id') */
			cons.push(e.id);
		});
		
		//break out of the function if it's empty
		if ( cons.length < 1 ) {
			return;
		}
		posttop = posttop + topPad;
		for (j=0; j<cons.length; j++){
			//set the positions
			var idstring = "#" + cons[j];
			$(idstring).css("left", left);
			$(idstring).css("top", posttop);
			left = left + leftPad;
			instance.connect({ source: c[k], target: cons[j], anchors:[ "Bottom", "Top" ], type:"basic", detachable:false });
		}
		//posttop = posttop + topPad;
		makeConnection(cons);
	}
}
	
