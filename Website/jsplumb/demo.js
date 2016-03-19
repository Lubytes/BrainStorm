jsPlumb.ready(function () {

//this code is taken from the jsPlumb open source library, specifically the source and targets demo
//copyright info found in src/jsPlumb.js
//it's a work in progress


//get the id of the head post
var headID = $('.headPost').attr('id');

    // list of possible anchor locations for the blue source element
    var sourceAnchors = [
        [ 0, 1, 0, 1 ],
        [ 0.25, 1, 0, 1 ],
        [ 0.5, 1, 0, 1 ],
        [ 0.75, 1, 0, 1 ],
        [ 1, 1, 0, 1 ]
    ];

    var instance = window.instance = jsPlumb.getInstance({
        // drag options
        DragOptions: { cursor: "pointer", zIndex: 2000 },
        // default to a gradient stroke from blue to green.
        PaintStyle: {
            gradient: { stops: [
                [ 0, "#0d78bc" ],
                [ 1, "#558822" ]
            ] },
            strokeStyle: "#558822",
            lineWidth: 10
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
    var smallWindows = jsPlumb.getSelector(".childOf" + headID);
    // make them draggable
    instance.draggable(smallWindows);

    // suspend drawing and initialise.
    instance.batch(function () {

        // make 'window1' a connection source. notice the filter and filterExclude parameters: they tell jsPlumb to ignore drags
        // that started on the 'enable/disable' link on the blue window.
        instance.makeSource(headID, {
            filter:"a",
            filterExclude:true,
            maxConnections: -1,
            endpoint:[ "Dot", { radius: 7, cssClass:"small-blue" } ],
            anchor:sourceAnchors
        });

        // configure the .smallPosts as targets.
        instance.makeTarget(smallWindows, {
            dropOptions: { hoverClass: "hover" },
            anchor:"Top",
            endpoint:[ "Dot", { radius: 2, cssClass:"large-green" } ]
        });
        
        
        instance.makeSource(smallWindows, {
            filter:"a",
            filterExclude:true,
            allowLoopback:false,
            endpoint:[ "Dot", { radius: 7, cssClass:"small-blue" } ],
            anchor:sourceAnchors
        });
        
        // configure the .babyWindows as targets.
        // instance.makeTarget(babyWindows, {
//             dropOptions: { hoverClass: "hover" },
//             anchor:"Top",
//             endpoint:[ "Dot", { radius: 2, cssClass:"large-green" } ]
//         });

        // and finally connect a couple of small windows, just so its obvious what's going on when this demo loads.           
        //instance.connect({ source: "headPost", target: "targetWindow5" });
        //instance.connect({ source: "headPost", target: "targetWindow2" });
        // $( ".smallPosts" ).each(function( index ) {
//         	instance.connect({ source: "headPost", target: ($( this ).attr('id')) });
// 		});
        
    });

    jsPlumb.fire("jsPlumbDemoLoaded", instance);
    
    
    
    jsPlumb.registerConnectionTypes({
	  "basic": {
		paintStyle:{ strokeStyle:"blue", lineWidth:5  },
		hoverPaintStyle:{ strokeStyle:"red", lineWidth:7 },
		cssClass:"connector-normal",
		detachable: false
	  }
	});
	
	
	
	//var cons = ["targetWindow1", "targetWindow2", "targetWindow3", "targetWindow4", "targetWindow5"];
	//var cons = $( ".childOf" + headID ).attr("id").toArray();
	var cons = [];


	///////////////////////////////////////////////////////////////////////////////////////////////////
	// Need to write a recursive function here to get posts to display correctly
	//
	///////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	$('.childOf' + headID).each( function(i,e) {
		/* you can use e.id instead of $(e).attr('id') */
		cons.push($(e).attr('id'));
	});
	
	var i = 0;
	for (i=0; i<cons.length; i++){
		instance.connect({ source: headID, target: cons[i], type:"basic", detachable:false });
	}
	
	
	
	// var consb = [];
// 	$('.babyWindow').each( function(i,e) {
// 		/* you can use e.id instead of $(e).attr('id') */
// 		consb.push($(e).attr('id'));
// 	});
// 	
// 	var i = 0;
// 	for (i=0; i<3; i++){
// 		instance.connect({ source: headID, target: consb[i], type:"basic", detachable:false });
// 	}

	//var c = jsPlumb.connect({ source:"headPost", target:"targetWindow3", type:"basic" });
    
    
    
    //jsPlumb.connect({source:"headPost", target:"targetWindow3"});
});	