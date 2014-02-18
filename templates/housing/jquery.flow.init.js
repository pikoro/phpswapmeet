$(document).ready(function(){
		$("#imagesnav").jFlow({
			slides: "#imageslides",
			controller: ".jFlowControl", // must be class, use . sign
			slideWrapper : "#jFlowSlide", // must be id, use # sign
			selectedWrapper: "jFlowSelected",  // just pure text, no sign
			easing: "swing",
			width: "630px",
			height: "438px",
			duration: 600,
			prev: ".jFlowPrev", // must be class, use . sign
			next: ".jFlowNext" // must be class, use . sign
		});
});