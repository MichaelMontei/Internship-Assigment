function enableConfirmDialogs(e){$(".confirm",e).click(function(e){var n=$(this).attr("data-confirm");return n||(n="Ben je zeker dat je deze operatie wenst uit te voeren op je selectie?"),confirm(n)?void 0:(e.preventDefault(),!1)})}$(document).ready(function(){enableConfirmDialogs(),$(".list").bind("List_Update",function(e,n,i){enableConfirmDialogs(n)})});