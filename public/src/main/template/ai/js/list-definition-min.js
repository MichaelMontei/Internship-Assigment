function initListWithDefinition(i){$(".toggle").click(function(i){var t=$(this);t.Ai_ShowLoading({loading:!0}),$.ajax({url:$(this).attr("href"),dataType:"json",success:function(i){t.Ai_ShowLoading({loading:!1,loadingClass:"loading"}),t.html('<i class="icon icon-dot toggle-'+i.toggleState+'"></i>'+i.toggleLabel)}}),i.preventDefault()}),$(".load-more, .load-previous",i).click(function(i){if("undefined"==typeof AiListDefinition)return!0;var t=jQueryBaseHref+"/ai/grid/instances/"+AiListDefinition.definitionId,e=$(this).attr("href"),n=e.indexOf("?"),a=-1!=n?e.substring(n,e.length):"",o=$(this).attr("class");$(this).Ai_ShowLoading({loading:!0,loadingClass:o+"-loading",idleClass:o});var l=$(this);return $.ajax({url:t+a,dataType:"json",success:function(i){var t=$(i.html);"load-previous"==o?($(".load-more",t).remove(),$(".list table tbody").prepend(t)):"load-more"==o&&($(".load-previous",t).remove(),$(".list table tbody").append(t)),l.Ai_ShowLoading({loading:!1,loadingClass:o+"-loading",idleClass:o}),l.parent().remove(),dispatchListUpdate(t,i)}}),i.preventDefault()})}$(document).ready(function(){$(".filters").bind("Ai_FilterInterface_Applied",function(i,t,e){var n=$(e.html);$(".list table tbody").html(n),dispatchListUpdate(n,e)}),$(".list").bind("List_Update",function(i,t,e){initListWithDefinition(t),$(".pagejumper-total").html(e.pagejumper.totalLabel),$(".pagejumper-range").html(e.pagejumper.rangeLabel);var n="undefined"!=typeof e.filters;n=n&&"undefined"!=typeof e.filters.count,n=n&&"undefined"!=typeof e.filters.description,n=n&&e.filters.count>0,$(".filters-description").html(n?e.filters.description:"")}),initListWithDefinition($(".list"))});