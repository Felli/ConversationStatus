$(function() {
	if ($("#conversationStatusControls").length)
		$("#conversationBody .scrubberContent").prepend($("#conversationStatusControls").popup({
			alignment: "left",
			content: "<i class='icon-pushpin'></i> <span class='text'>Status</span> <i class='icon-caret-down'></i>"
		}).find(".button").addClass("big").end());
});