function checkLogOut(){
    window.location = "/accounts/logout";
}
function updateLastSeen(){
    $.ajax({
        type:"GET",
        url:"/accounts/update_last_seen/",
        success: function(data, textStatus){
            if(data["status"] == 302)
                checkLogOut();
        }
    });
}

(function() {
    setTimeout('updateLastSeen()',500);
    setInterval("updateLastSeen()", TIMEOFF - 1000);
})();
