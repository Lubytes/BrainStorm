var posttop = 400;
var topPad = 250;
var leftPad = 320;

jsPlumb.ready(function () {

//this code is taken from the jsPlumb open source library, specifically the source and targets demo
//copyright info found in src/jsPlumb.js
//it's a work in progress


//get the id of the head post
var headID = $('.headPost').attr('id');

    var instance = window.instance = jsPlumb.getInstance({
        // drag options
        DragOptions: { cursor: "pointer", zIndex: 2000,  },
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

    // bind to a connection event, just for the purposes of pointing out that it can be done.
    instance.bind("connection", function (i, c) {
        if (typeof console !== "undefined")
            console.log("connection", i.connection);
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
            filter:"a",
            filterExclude: true,
            maxConnections: -1,
            allowLoopback: false,
            endpoint:[ "Dot", { radius: 3, cssClass:"small-blue" } ],
            anchor:sourceAnchors
        });

        // configure the .smallPosts as targets.
        instance.makeTarget(smallWindows, {
            dropOptions: { hoverClass: "hover" },
            endpoint:[ "Dot", { radius: 3, cssClass:"large-green" } ]
        });
        
        
        instance.makeSource(smallWindows, {
            filter:"a",
            filterExclude: true,
            allowLoopback: false,
            maxConnections: -1,
            endpoint:[ "Dot", { radius: 3, cssClass:"small-blue" } ],
            anchor:sourceAnchors
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
	var cons = [];
	var i, j;
	for (i=0; i<c.length; i++){
		cons = []; //empty the array
		$('.childOf' + c[i]).each( function(i,e) {
			/* you can use e.id instead of $(e).attr('id') */
			cons.push($(e).attr('id'));
		});
		//alert("cons is: " + cons);
		//break out of the function if it's empty
		if ( cons.length < 1 ) {
			return;
		}
		posttop = posttop + topPad;
		for (j=0; j<cons.length; j++){
			//set the positions
			
			$("#"+cons[j]).css("left", left);
			$("#"+cons[j]).css("top", posttop);
			left = left + leftPad;
			instance.connect({ source: c[i], target: cons[j], anchors:[ "Bottom", "Top" ], type:"basic", detachable:false });
			//alert("connecting: " + cons[j] + "to" + c[i]);
		}
		//posttop = posttop + topPad;
		makeConnection(cons);
	}
}
	
